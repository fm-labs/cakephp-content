<?php
namespace Content\Model\Table;

use Banana\Menu\Menu;
use Cake\Cache\Cache;
use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\Database\Schema\TableSchema;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Routing\Router;
use Cake\Validation\Validator;

/**
 * Menus Model
 *
 */
class MenusTable extends BaseTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->setTable(self::$tablePrefix . 'pages');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree.Tree', [
            'level' => 'level'
        ]);

        $this->belongsTo('ParentMenus', [
            'className' => 'Content.Menus',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildMenus', [
            'className' => 'Content.Menus',
            'foreignKey' => 'parent_id'
        ]);

        /*
        $this->addBehavior('Translate', [
            'fields' => ['title', 'slug'],
            'translationTable' => 'bc_i18n'
        ]);
        */
    }

    protected function _initializeSchema(TableSchema $schema)
    {
        $schema->setColumnType('type_params', 'json');

        return $schema;
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        $types = [
            'root' => [
                'label' => __('Root Page'),
                'className' => '\\Content\\Model\\Entity\\Menu\\RootType',
                'content' => false,
                'menu' => true,
            ],
            'content' => [
                'label' => __('Page'),
                'className' => '\\Content\\Model\\Entity\\Menu\\PageType',
                'content' => ['page'],
                'menu' => true,
            ],
            'shop_category' => [
                'label' => __('Shop Category'),
                'className' => '\\Content\\Model\\Entity\\Menu\\ShopCategoryType',
                'content' => false,
                'menu' => true,
            ],
            'static' => [
                'label' => __('Static Page'),
                'className' => '\\Content\\Model\\Entity\\Menu\\RootType',
                'content' => false,
                'menu' => true,
            ],
            'controller' => [
                'label' => __('Custom Controller'),
                'className' => '\\Content\\Model\\Entity\\Menu\\ControllerType',
                'content' => false,
                'menu' => true,
            ],
            'redirect' => [
                'label' => __('Redirect'),
                'className' => '\\Content\\Model\\Entity\\Menu\\LinkType',
                'content' => false,
                'menu' => true,
            ],
            'link' => [
                'label' => __('Custom Link'),
                'className' => '\\Content\\Model\\Entity\\Menu\\LinkType',
                'content' => false,
                'menu' => true,
            ],
        ];

        return $types;
    }

    /**
     * @return array
     */
    public function getTypeList()
    {
        $c = new Collection($this->getTypes());
        $list = $c->map(function ($v, $k) {
            return $v['label'];
        });

        return $list->toArray();
    }

    /**
     * @param string $type Page type
     * @return object
     */
    public function getTypeObject($type)
    {
        $types = $this->getTypes();
        if (!isset($types[$type])) {
            throw new \RuntimeException("Unkown type: " . $type);
        }

        $class = $types[$type]['className'];
        if (!class_exists($class)) {
            throw new \RuntimeException("Type class not found for type " . $type);
        }

        $obj = new $class();

        return $obj;
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
            ->add('level', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('level');

        $validator
            ->add('parent_id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('parent_id');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->allowEmpty('type');

        /*
        $validator
            ->add('type_params', 'valid', [
                'rule' => 'checkTypeParams',
                'provider' => 'table'
            ]);
        */

        return $validator;
    }

    /*
    public function checkTypeParams($value, $context)
    {
        debug(func_get_args());
        // Get type handler and check params

        if ($context['data']['type'] == "root") {
            if (!isset($value['redirect_page_id']) || !$value['redirect_page_id']) {
                return "Redirect page id not set";
            }
        }

        return "Type Params failed";
    }
    */

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parent_id'], 'ParentMenus'));

        return $rules;
    }

    /**
     * @param Event $event
     * @param EntityInterface $entity
     * @param \ArrayObject $options
     */
    public function beforeMarshal(Event $event,  \ArrayObject $data, \ArrayObject $options)
    {
        //debug($data);
    }

    /**
     * @param Event $event
     * @param EntityInterface $entity
     * @param \ArrayObject $options
     */
    public function beforeSave(Event $event, EntityInterface $entity, \ArrayObject $options)
    {
        /*
        if ($entity->dirty('type_params') === true) {
            if ($entity->type == "root") {
                $entity->errors('type_params', 'Fail em all');
                return false;
            }
        }
        */
    }

    /**
     * @param Event $event
     * @param EntityInterface $entity
     * @param \ArrayObject $options
     */
    public function afterSave(Event $event, EntityInterface $entity, \ArrayObject $options)
    {
    }

    /**
     * @param null $startNodeId
     * @param array $options
     * @return array|mixed
     */
    public function getMenu($startNodeId, array $options = [])
    {
        $options += ['maxDepth' => null, 'includeHidden' => null];
        $maxDepth = ($options['maxDepth'] !== null) ? $options['maxDepth'] : -1;
        $includeHidden = $options['includeHidden'];

        //$cacheKey = sprintf("menus-%s-%s", $startNodeId, md5(serialize($options)));
        //$menu = Cache::read($cacheKey, 'content_menu');
        $menu = [];
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
            //Cache::write($cacheKey, $menu->toArray(), 'content_menu');
        }

        return $menu;
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
        /*
        $types = $this->getTypes();
        $handlerBuilder = function (EntityInterface $entity) use ($types) {
            $type = $entity->get('type');
            $params = (array)$entity->get('type_params');

            if (!isset($types[$type])) {
                throw new \Exception('Unknown menu type: ' . $type);
            }

            $className = $types[$type]['className'];
            if (!class_exists($className)) {
                throw new \Exception('Class not found: ' . $className);
            }

            $params += $entity->extract(['type', 'title', 'hide_in_nav', 'hide_in_sitemap', 'cssid', 'cssclass']);
            $handler = new $className($params);

            return $handler;
        };
        */

        $menu = new Menu();
        foreach ($children as $child) {
            /* @var \Content\Model\Entity\Menu $child */
            try {
                //$handler = $this->getTypeHandler($child);
                //$handler = $handlerBuilder($child->type, $child->type_params);
                /* @var \Content\Page\TypeInterface $handler */
                //$handler = $handlerBuilder($child);
                //$item = $handler->toMenuItem($maxDepth);
                $item = $child->toMenuItem($maxDepth);

                /*
                if (!$includeHidden && !$handler->isEnabled($child)) {
                    continue;
                }

                if (($maxDepth < 0 || $level < $maxDepth) && $handler->findChildren($child)) {
                    $_children = $this->_buildMenu($handler->findChildren($child), $level + 1, $maxDepth);
                    $item->setChildren($_children);
                }
                */
                if (($maxDepth < 0 || $level < $maxDepth) && isset($child['children'])) {
                    $_submenu = $this->_buildMenu($child['children'], $level + 1, $maxDepth);
                    $item->addChildren($_submenu->getItems());
                }

                $menu->addItem($item);
            /*
            } catch (MissingMenuTypeHandlerException $ex) {
                //@todo handle exception
                debug($ex->getMessage());
            */
            } catch (\Exception $ex) {
                //@todo handle exception
                debug($ex->getMessage());
            }

        }

        return $menu;
    }

    /**
     * @param null $startNodeId
     * @param array $options
     * @return array
     */
    public function getMenuTree($startNodeId, array $options = [])
    {
        $tree = [];
        $options += ['maxDepth' => null, 'includeHidden' => null];
        $maxDepth = ($options['maxDepth']) ?: 1;

        $cacheKey = sprintf("menus-tree-%s-%s", $startNodeId, md5(serialize($options)));
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
            //Cache::write($cacheKey, $tree, 'content_menu');
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
            /* @var \Content\Model\Entity\Menu $child */
            //$handler = $this->getTypeHandler($child);
            //if (!$handler->isEnabled($child)) {
            //    continue;
            //}

            //$key = $child->id . ':' . Router::url($handler->toUrl($child));
            $key = $child->id . ':' . Router::url($child->getUrl(), true);
            $tree[$key] = str_repeat('_', $level) . $child->title;

            if (($maxDepth < 0 || $level < $maxDepth) && $child->children) {
                $this->_buildMenuTree($tree, $child->children, $level + 1, $maxDepth);
            }
        }
    }
}
