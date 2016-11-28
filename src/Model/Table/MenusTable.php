<?php
namespace Content\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Validation\Validator;
use Content\Model\Entity\Menu;
use Content\Model\Entity\MenuItem;

/**
 * Menus Model
 *
 * @property MenuItemsTable $MenuItems
 */
class MenusTable extends Table
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

        $this->table('bc_menus');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->belongsTo('Sites', [
            'className' => 'Banana.Sites',
            'foreignKey' => 'site_id'
        ]);

        $this->hasMany('MenuItems', [
            'className' => 'Content.MenuItems',
            'foreignKey' => 'menu_id'
        ]);

        $this->hasMany('RootMenuItems', [
            'className' => 'Content.MenuItems',
            'foreignKey' => 'menu_id',
            'conditions' => [
                'RootMenuItems.parent_id IS NULL'
            ]
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
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        return $validator;
    }

    /**
     * @param $menuId
     * @return array
     */
    public function toMenu($menuId)
    {
        $menu = $this->get($menuId);


        $nodeFormatter = function(MenuItem $menuItem) use (&$id) {

            $publishedClass = ($menuItem->isHiddenInNav()) ? 'unpublished' : 'published';
            $class = $menuItem->type;
            $class.= " " . $publishedClass;

            return [
                'id' => 'menu_item__' . $menuItem->id,
                'title' => $menuItem->getLabel(),
                'url' => $menuItem->getAdminUrl()
            ];
        };

        $nodesFormatter = function($menuItems) use ($nodeFormatter, &$nodesFormatter) {
            $formatted = [];
            foreach ($menuItems as $menuItem) {
                $_node = $nodeFormatter($menuItem);
                if ($menuItem->getChildren()) {
                    $_node['children'] = $nodesFormatter($menuItem->getChildren());
                }
                $formatted[] = $_node;
            }
            return $formatted;
        };


        $menuItems = TableRegistry::get('Content.MenuItems')->find()->where(['menu_id' => $menu->id, 'parent_id IS' => null])->all();
        $menuArray = [
            'title' => $menu->title,
            'items' => $nodesFormatter($menuItems)
        ];

        return $menuArray;
    }


    public function toJsTree($siteId = null)
    {

        $id = 1;
        $nodeFormatter = function(MenuItem $menuItem) use (&$id) {

            $publishedClass = ($menuItem->isHiddenInNav()) ? 'unpublished' : 'published';
            $class = $menuItem->type;
            $class.= " " . $publishedClass;

            return [
                'id' => $menuItem->id,
                'text' => $menuItem->getLabel(),
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
                    'id' => $menuItem->id,
                    'menu_id' => $menuItem->menu_id,
                    'type' => $menuItem->type,
                    'typeid' => $menuItem->typeid,
                    'parent_id' => $menuItem->parent_id,
                    'level' => $menuItem->level,
                    'lft' => $menuItem->lft,
                    'url' => Router::url($menuItem->getAdminUrl()),
                ]
            ];
        };

        $nodesFormatter = function($menuItems) use ($nodeFormatter, &$nodesFormatter) {
            $formatted = [];
            foreach ($menuItems as $menuItem) {
                $_node = $nodeFormatter($menuItem);
                if ($menuItem->getChildren()) {
                    $_node['children'] = $nodesFormatter($menuItem->getChildren());
                }
                $formatted[] = $_node;
            }
            return $formatted;
        };

        $menu = TableRegistry::get('Content.Menus')->find()->where(['site_id' => $siteId])->first();
        $menuItems = TableRegistry::get('Content.MenuItems')
            ->find()
            ->where(['menu_id' => $menu->id, 'parent_id IS' => null])
            ->order(['MenuItems.lft' => 'ASC'])
            ->all();

        return $nodesFormatter($menuItems);

        /*
        foreach ($menus as $menu) {

            $menuNode = [
                'id' => 'menu__' . $menu->id,
                'text' => $menu->title,
                'icon' => null,
                'state' => [
                    'opened' => true,
                    'disabled' => false,
                    'selected' => false,
                ],
                'children' => $nodesFormatter($menuItems),
                'li_attr' => ['class' => ''],
                'a_attr' => [],
                'data' => [
                    'type' => 'menu',
                    'typeid' => $menu->id,
                    'viewUrl' => Router::url(['controller' => 'Menus', 'action' => 'view', $menu->id])
                ]
            ];
            $nodes[] = $menuNode;
        }
        return $nodes;
        */
    }

}
