<?php
namespace Content\Model\Table;

use Banana\Menu\Menu;
use Cake\Cache\Cache;
use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Routing\Router;
use Cake\Validation\Validator;
use Content\Exception\MissingPageTypeHandlerException;
use Content\Lib\PageTypeRegistry;
use Content\Model\Entity\Page;
use Content\Page\PageTypeInterface;
use Seo\Sitemap\SitemapLocation;

/**
 * Pages Model
 *
 * @property PageLayoutsTable $PageLayouts
 */
class PagesTable extends Table
{

    /**
     * @var PageTypeRegistry
     */
    protected $_types;

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
        $this->addBehavior('Banana.Sluggable');
        $this->addBehavior('Banana.Publishable');
        $this->addBehavior('Backend.JsTree', ['dataFields' => ['slug', 'type']]);

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

        //$this->addBehavior('Banana.InputSchema');

        if (Plugin::loaded('Search')) {
            $this->addBehavior('Search.Search');
            $this->searchManager()
                ->add('q', 'Search.Like', [
                    'before' => true,
                    'after' => true,
                    'fieldMode' => 'OR',
                    'comparison' => 'LIKE',
                    'wildcardAny' => '*',
                    'wildcardOne' => '?',
                    'field' => ['title']
                ])
                ->add('title', 'Search.Like', [
                    'before' => true,
                    'after' => true,
                    'fieldMode' => 'OR',
                    'comparison' => 'LIKE',
                    'wildcardAny' => '*',
                    'wildcardOne' => '?',
                    'field' => ['title']
                ])
                ->value('is_published', [
                    'filterEmpty' => true
                ]);
        }

        $this->_loadPageTypes();
    }


    public function buildInputs(\Banana\Model\TableInputSchema $inputs)
    {
        $inputs->addField('meta_desc', ['type' => 'Html']);
        return $inputs;
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

    /**
     * @param Event $event
     * @param EntityInterface $entity
     * @param \ArrayObject $options
     */
    public function afterSave(Event $event, EntityInterface $entity, \ArrayObject $options)
    {
        Cache::clear(false, 'content_menu');
    }

    /**
     * Load available page types into types registry
     */
    protected function _loadPageTypes()
    {
//        if (!TableRegistry::config('PageTypes')) {
//            TableRegistry::config('PageTypes', ['className' => 'Content.PageTypes']);
//        }
//        $PageTypes = TableRegistry::get('PageTypes');
//        $types = $PageTypes->find()->all();

        $types = (array) Configure::read('Content.PageTypes');

        $this->_types = new PageTypeRegistry();
        foreach ($types as $type => $config) {
            $this->_types->load($type, $config);
        }
    }

    /**
     * @param null $startNodeId
     * @param array $options
     * @return array|mixed
     */
    public function getMenu($startNodeId = null, array $options = [])
    {
        $options += ['maxDepth' => null, 'includeHidden' => null];
        $maxDepth = ($options['maxDepth']) ?: -1;
        $includeHidden = $options['includeHidden'];

        if ($startNodeId === null) {
            $root = $this->findRoot();
            $startNodeId = $root->id;
        }
        $cacheKey = sprintf("pages-%s-%s", $startNodeId, md5(serialize($options)));
        $menu = Cache::read($cacheKey, 'content_menu');
        if (empty($menu)) {
            if ($startNodeId) {
                $children = $this
                    ->find('children', ['for' => $startNodeId])
                    ->find('threaded')
                    ->orderAsc('lft')
                    ->contain([])
                    ->toArray();

                $menu = $this->_buildMenu($children, 0, $maxDepth, $includeHidden);
            }
            Cache::write($cacheKey, $menu->toArray(), 'content_menu');
        }

        return $menu;
    }

    /**
     * @param EntityInterface|Page $page
     * @return PageTypeInterface
     */
    public function getTypeHandler(EntityInterface $page)
    {
        $type = $page->type;
        if (!$this->_types->has($type)) {
            throw new MissingPageTypeHandlerException(['type' => $type]);
        }
        return $this->_types->get($type);
    }

    /**
     * @param $children
     * @param int $level
     * @param int $maxDepth
     * @param null $includeHidden
     * @return Menu
     */
    protected function _buildMenu($children, $level = 0, $maxDepth = -1, $includeHidden = null)
    {
        $menu = new Menu();
        foreach ($children as $child) {

            try {
                $handler = $this->getTypeHandler($child);
                $item = $handler->toMenuItem($child);

            } catch (MissingPageTypeHandlerException $ex) {
                //@todo handle exception
                debug($ex->getMessage());
                continue;
            } catch (\Exception $ex) {
                //@todo handle exception
                debug($ex->getMessage());
                continue;
            }

            if (!$includeHidden && !$handler->isEnabled($child)) {
                continue;
            }

            if (($maxDepth < 0 || $level < $maxDepth) && $handler->findChildren($child)) {
                $_children = $this->_buildMenu($handler->findChildren($child), $level + 1, $maxDepth);
                $item->setChildren($_children);
            }

            $menu->addItem($item);
        }

        return $menu;
    }

    /**
     * @param null $startNodeId
     * @param array $options
     * @return array
     */
    public function getMenuTree($startNodeId = null, array $options = [])
    {
        $tree = [];
        $options += ['maxDepth' => null, 'includeHidden' => null];
        $maxDepth = ($options['maxDepth']) ?: 1;

        if ($startNodeId === null) {
            $root = $this->findRoot();
            $startNodeId = $root->id;
        }

        $cacheKey = sprintf("pages-tree-%s-%s", $startNodeId, md5(serialize($options)));
        //$tree = Cache::read($cacheKey, 'content_menu');
        $tree = [];
        if (empty($tree)) {
            $tree = [];
            if ($startNodeId) {
                $children = $this
                    ->find('children', ['for' => $startNodeId])
                    ->find('threaded')
                    ->orderAsc('lft')
                    ->contain([])
                    ->toArray();

                $tree = [];
                $this->_buildMenuTree($tree, $children, 0, $maxDepth);
            }
            Cache::write($cacheKey, $tree, 'content_menu');
        }

        return $tree;
    }

    /**
     * @param $tree
     * @param $children
     * @param int $level
     * @param int $maxDepth
     */
    protected function _buildMenuTree(&$tree, $children, $level = 0, $maxDepth = -1)
    {
        foreach ($children as $child) {
            $handler = $this->getTypeHandler($child);
            if (!$handler->isEnabled($child)) {
                continue;
            }

            $key = $child->id . ':' . Router::url($handler->toUrl($child));
            $tree[$key] = str_repeat('_', $level) . $handler->getLabel($child);

            if (($maxDepth < 0 || $level < $maxDepth) && $child->children) {
                $this->_buildMenuTree($tree, $child->children, $level + 1, $maxDepth);
            }
        }
    }

    /**
     * @param $page
     * @return null
     */
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

    /**
     * @return mixed
     */
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

    /**
     * @param bool|false $fallback
     * @param null $host
     * @return mixed
     */
    public function findHostRoot($fallback = false, $host = null)
    {
        if (is_null($host)) {
            $host = (defined('BANANA_HOST')) ? BANANA_HOST : $host;
            $host = (!$host && defined('BC_SITE_HOST')) ? BC_SITE_HOST : $host;
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

    /**
     * @param null $slug
     * @return mixed
     */
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

    /**
     * @return Collection
     */
    public function findSitemap()
    {
        $locations = [];

        $root = $this->findHostRoot();
        $locations[] = new SitemapLocation(Router::url('/', true), 1, 'weekly');

        $pages = $this->find('children', ['for' => $root->id])->find('threaded')->order(['lft' => 'ASC'])->contain([])->all();
        $this->_buildSitemap($locations, $pages);

        return new Collection($locations);
    }

    /**
     * @param $locations
     * @param $pages
     * @return void
     */
    protected function _buildSitemap(&$locations, $pages, $level = 0)
    {
        foreach ($pages as $page) {

            $handler = $this->getTypeHandler($page);
            if (!$handler->isEnabled($page)) {
                continue;
            }

            $url = Router::url($handler->toUrl($page), true);

            // skip external urls
            $baseUrl = Configure::read('App.fullBaseUrl');
            if (substr($url, 0, strlen($baseUrl)) . '/' !== $baseUrl  . '/') {
                continue;
            }
            $priority = 1 - ( $level / 10 );
            $lastmod = $page->modified;
            $changefreq = 'weekly';

            $locations[] = new SitemapLocation($url, $priority, $lastmod, $changefreq);

            if ($page->children) {
                $this->_buildSitemap($locations, $page->children, $level + 1);
            }
        }
    }
}
