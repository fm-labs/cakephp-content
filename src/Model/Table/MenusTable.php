<?php
namespace Content\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Content\Model\Entity\Menu;

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
}
