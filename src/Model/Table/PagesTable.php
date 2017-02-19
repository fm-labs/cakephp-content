<?php
namespace Content\Model\Table;

use Content\Model\Entity\Page;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Routing\Router;
use Cake\Validation\Validator;
use Content\Model\Table\PageModulesTable;
use Content\Model\Table\PageLayoutsTable;
use Content\Page\PageInterface;

/**
 * Pages Model
 *
 * @property PageModulesTable $PageModules
 * @property PageLayoutsTable $PageLayouts
 */
class PagesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('bc_pages');
        $this->displayField('title');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree.Tree', [
            'level' => 'level'
        ]);
        $this->addBehavior('Content.ContentModule', [
            'alias' => 'ContentModules',
            'scope' => 'Content.Pages'
        ]);
        $this->addBehavior('Banana.Copyable', [
            'excludeFields' => ['lft', 'rght', 'slug']
        ]);
        $this->addBehavior('Content.Page');
        $this->addBehavior('Banana.Sluggable');
        $this->addBehavior('Banana.Publishable');


        /*
        $this->addBehavior('Banana.Sortable', [
            'field' => 'pos',
            'scope' => []
        ]);
        */

        $this->belongsTo('ParentPages', [
            'className' => 'Content.Pages',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildPages', [
            'className' => 'Content.Pages',
            'foreignKey' => 'parent_id'
        ]);

        $this->belongsTo('PageLayouts', [
            'className' => 'Content.PageLayouts',
            'foreignKey' => 'page_layout_id'
        ]);

        /*
        $this->hasMany('PageModules', [
            'className' => 'Content.PageModules',
            'foreignKey' => 'page_id'
        ]);
        */

        /*
        $this->hasMany('PageModules', [
            'className' => 'Content.ContentModules',
            'foreignKey' => 'refid',
            'conditions' => ['refscope' => 'Content.Pages']
        ]);
        */

        $this->hasMany('Posts', [
            'className' => 'Content.Posts',
            'foreignKey' => 'refid',
            'conditions' => ['refscope' => 'Content.Pages'],
            'order' => ['Posts.pos' => 'DESC', 'Posts.id' => 'ASC']
        ]);

        $this->addBehavior('Translate', [
            'fields' => ['title', 'slug'],
            'translationTable' => 'bc_i18n'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');
            
        $validator
            ->add('lft', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('lft');
            
        $validator
            ->add('rght', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('rght');
            
        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');
            
        $validator
            //->requirePresence('slug', 'create')
            ->allowEmpty('slug');

        $validator
            ->allowEmpty('type');

        $validator
            ->add('redirect_status', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('redirect_status');

        $validator
            ->allowEmpty('redirect_location');

        $validator
            ->allowEmpty('redirect_controller');

        $validator
            ->add('redirect_page_id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('redirect_page_id');

        $validator
            ->add('redirect_page_id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('page_layout_id');

        $validator
            ->allowEmpty('page_template');
            
        $validator
            ->add('is_published', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('is_published');
            
        $validator
            ->add('publish_start_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('publish_start_date');
            
        $validator
            ->add('publish_end_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('publish_end_date');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parent_id'], 'ParentPages'));
        return $rules;
    }

    public function getPageLayoutFor($page)
    {
        if (is_numeric($page)) {
            $page = $this->get($page, ['contain' => 'PageLayouts']);
        }

        if ($page->page_layout) {
            return $page->page_layout;
        }

        if ($page->page_layout_id) {
            return $this->PageLayouts->get($page->page_layout_id);
        }

        if ($page->parent_id) {
            return $this->getPageLayoutFor($page->parent_id);
        }

        return null;
    }

    public function findRoot()
    {
        $rootPage = $this
            ->find()
            ->find('published')
            ->where([
                'parent_id IS NULL',
                'type' => 'root'
            ])
            ->first();

        return $rootPage;
    }

    public function findHostRoot($fallback = false, $host = null)
    {
        if (is_null($host)) {
            $host = (defined('BANANA_HOST')) ? BANANA_HOST : env('HTTP_HOST');
        }

        $page = $this
            ->find()
            ->find('published')
            ->where([
                'type' => 'root',
                'parent_id IS NULL',
                'title' => $host
            ])
            ->first();

        if (!$page && $fallback === true) {
            return $this->findRoot();
        }

        return $page;
    }

    public function findBySlug($slug = null)
    {
        $page = $this
            ->find()
            ->find('published')
            ->where([
                'slug' => $slug
            ])
            ->contain([])
            ->first();

        return $page;
    }

    /**
     * @param null $slug
     * @return mixed Model Id or null
     */
    public function findIdBySlug($slug = null)
    {
        $page = $this
            ->find()
            ->where([
                'slug' => $slug
            ])
            ->select('id')
            ->contain([])
            ->hydrate(false)
            ->first();

        return $page['id'];
    }

    public function toJsTree($rootId = null)
    {
        $nodes = $this->find('threaded')
            ->all()
            ->toArray();


        $id = 1;
        $nodeFormatter = function(PageInterface $node) use (&$id) {

            $publishedClass = ($node->isPagePublished()) ? 'published' : 'unpublished';
            $class = $node->getPageType();
            $class.= " " . $publishedClass;

            return [
                'id' => $id++,
                'text' => $node->getPageTitle(),
                'icon' => $class,
                'state' => [
                    'opened' => false,
                    'disabled' => false,
                    'selected' => false,
                ],
                'children' => [],
                'li_attr' => ['class' => $class],
                'a_attr' => [],
                'data' => [
                    'type' => $node->getPageType(),
                    'viewUrl' => Router::url($node->getPageAdminUrl()),
                ]
            ];
        };

        $nodesFormatter = function($nodes) use ($nodeFormatter, &$nodesFormatter) {
            $formatted = [];
            foreach ($nodes as $node) {
                $_node = $nodeFormatter($node);
                if ($node->getPageChildren()) {
                    $_node['children'] = $nodesFormatter($node->getPageChildren());
                }
                $formatted[] = $_node;
            }
            return $formatted;
        };

        $nodesFormatted = $nodesFormatter($nodes);
        return $nodesFormatted;
    }
}
