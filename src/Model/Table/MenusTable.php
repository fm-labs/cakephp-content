<?php
namespace Content\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Validation\Validator;
use Content\Model\Entity\Menu;
use Content\Model\Entity\Node;

/**
 * Menus Model
 *
 * @property NodesTable $Nodes
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

        $this->hasMany('Nodes', [
            'className' => 'Content.Nodes',
            'foreignKey' => 'site_id'
        ]);

        $this->hasMany('RootNodes', [
            'className' => 'Content.Nodes',
            'foreignKey' => 'site_id',
            'conditions' => [
                'RootNodes.parent_id IS NULL'
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


        $nodeFormatter = function(Node $node) use (&$id) {

            $publishedClass = ($node->isHiddenInNav()) ? 'unpublished' : 'published';
            $class = $node->type;
            $class.= " " . $publishedClass;

            return [
                'id' => 'node__' . $node->id,
                'title' => $node->getLabel(),
                'url' => $node->getAdminUrl()
            ];
        };

        $nodesFormatter = function($nodes) use ($nodeFormatter, &$nodesFormatter) {
            $formatted = [];
            foreach ($nodes as $node) {
                $_node = $nodeFormatter($node);
                if ($node->getChildren()) {
                    $_node['children'] = $nodesFormatter($node->getChildren()->all()->toArray());
                }
                $formatted[] = $_node;
            }
            return $formatted;
        };


        $nodes = TableRegistry::get('Content.Nodes')->find()->where(['site_id' => $menu->id, 'parent_id IS' => null])->all();
        $menuArray = [
            'title' => $menu->title,
            'items' => $nodesFormatter($nodes)
        ];

        return $menuArray;
    }


    public function toJsTree($siteId = null)
    {

        $id = 1;
        $nodeFormatter = function(Node $node) use (&$id) {

            $publishedClass = ($node->isHiddenInNav()) ? 'unpublished' : 'published';
            $class = $node->type;
            $class.= " " . $publishedClass;

            return [
                'id' => $node->id,
                'text' => $node->getLabel(),
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
                    'id' => $node->id,
                    'site_id' => $node->site_id,
                    'type' => $node->type,
                    'typeid' => $node->typeid,
                    'parent_id' => $node->parent_id,
                    'level' => $node->level,
                    'lft' => $node->lft,
                    'url' => Router::url($node->getAdminUrl()),
                ]
            ];
        };

        $nodesFormatter = function($nodes) use ($nodeFormatter, &$nodesFormatter) {
            $formatted = [];
            foreach ($nodes as $node) {
                $_node = $nodeFormatter($node);
                if ($node->getChildren()) {
                    $_node['children'] = $nodesFormatter($node->getChildren()->all()->toArray());
                }
                $formatted[] = $_node;
            }
            return $formatted;
        };

        $menu = TableRegistry::get('Content.Menus')->find()->where(['site_id' => $siteId])->first();
        $nodes = TableRegistry::get('Content.Nodes')
            ->find()
            ->where(['site_id' => $menu->id, 'parent_id IS' => null])
            ->order(['Nodes.lft' => 'ASC'])
            ->all();

        return $nodesFormatter($nodes);

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
                'children' => $nodesFormatter($nodes),
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
