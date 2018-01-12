<?php
namespace Content\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Content\Lib\ContentManager;
use Content\Model\Entity\Gallery;
use Cake\Core\Plugin;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Routing\Router;
use Cake\Validation\Validator;
use Media\Lib\Media\MediaManager;

/**
 * Galleries Model
 *
 */
class GalleriesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('bc_galleries');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->belongsTo('Parent', [
            'className' => 'Content.Galleries',
            'foreignKey' => 'parent_id',
        ]);

        $this->hasMany('Posts', [
            'className' => 'Content.Posts',
            'foreignKey' => 'refid',
            'conditions' => ['refscope' => 'Content.Galleries']
        ]);

        if (Plugin::loaded('Search')) {
            $this->addBehavior('Search.Search');
            $this->searchManager()
                ->add('title', 'Search.Like', [
                    'before' => true,
                    'after' => true,
                    'fieldMode' => 'OR',
                    'comparison' => 'LIKE',
                    'wildcardAny' => '*',
                    'wildcardOne' => '?',
                    'field' => ['title']
                ])
                ->value('parent_id', [
                    'filterEmpty' => true
                ])
                ->value('is_published', [
                    'filterEmpty' => true
                ]);
        }
    }

    public function sources($field, array $options = [])
    {
        if ($field === 'source') {
            return $this->getSources();
        }

        switch ($field) {
            case "source":
                return $this->getSources();
            case "source_folder":
                return $this->getSourceFolders();
            case "view_template":
                return ContentManager::getAvailableGalleryTemplates();
            case "parent_id":
                return $this->find('list')->toArray();
        }
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
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->allowEmpty('desc_html');

        return $validator;
    }

    public function afterSave(Event $event, EntityInterface $entity, \ArrayObject $options)
    {
        if ($entity->get('_generate_slider')) {
            $Modules = TableRegistry::get('Content.Modules');
            $module = $Modules->newEntity();
            $module->name = sprintf("Mod %s", $entity->title);
            $module->path = "flexslider";
            $module->params = json_encode(['gallery_id' => $entity->id]);

            if (!$Modules->save($module)) {
                Log::error('GalleriesTable: Failed to create slider module for gallery with ID ' . $entity->id);
            }
        }
    }

    /**
     * Get list of available gallery sources
     */
    public function getSources()
    {
        return [
            'folder' => __d('content', 'Folder'),
            'posts' => __d('content', 'Posts')
        ];
    }

    /**
     * Get a recursive directory list of available gallery source folders
     */
    public function getSourceFolders()
    {
        $folders = [];
        if (Plugin::loaded('Media')) {
            $mm = MediaManager::get('default');

            return $mm->getSelectFolderListRecursive('gallery/');
        }

        return $folders;
    }

    public function toJsTree()
    {
        $nodes = $this->find('threaded')
            ->orderAsc('Galleries.title')
            ->all()
            ->toArray();

        //debug($nodes);

        $id = 1;
        $nodeFormatter = function (Gallery $node) use (&$id) {

            $class = "content published";

            return [
                'id' => $id++,
                'text' => $node->title,
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
                    'type' => 'content',
                    'viewUrl' => Router::url(['controller' => 'Galleries', 'action' => 'manage', $node->id]),
                ]
            ];
        };

        $nodesFormatter = function ($nodes) use ($nodeFormatter, &$nodesFormatter) {
            $formatted = [];
            foreach ($nodes as $node) {
                $_node = $nodeFormatter($node);
                if ($node->children) {
                    $_node['children'] = $nodesFormatter($node->children);
                }
                $formatted[] = $_node;
            }

            return $formatted;
        };

        $nodesFormatted = $nodesFormatter($nodes);

        return $nodesFormatted;
    }
}
