<?php
namespace Content\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Content\Model\Entity\MenuItem;

/**
 * MenuItems Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Menus
 * @property \Cake\ORM\Association\BelongsTo $ParentMenuItems
 * @property \Cake\ORM\Association\HasMany $ChildMenuItems
 */
class MenuItemsTable extends Table
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

        $this->table('bc_menu_items');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree.Tree', [
            'level' => 'level',
        ]);

        $this->belongsTo('Menus', [
            'foreignKey' => 'menu_id',
            'joinType' => 'INNER',
            'className' => 'Content.Menus'
        ]);
        $this->belongsTo('ParentMenuItems', [
            'className' => 'Content.MenuItems',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildMenuItems', [
            'className' => 'Content.MenuItems',
            'foreignKey' => 'parent_id'
        ]);
    }

    public function getTypeList()
    {

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
            ->add('menu_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('menu_id', 'create')
            ->notEmpty('menu_id');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->allowEmpty('type');

        $validator
            ->allowEmpty('typeid');

        $validator
            ->allowEmpty('type_params');

        $validator
            ->allowEmpty('cssid');

        $validator
            ->allowEmpty('cssclass');

        $validator
            ->add('hide_in_nav', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('hide_in_nav');

        $validator
            ->add('hide_in_sitemap', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('hide_in_sitemap');

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
        $rules->add($rules->existsIn(['menu_id'], 'Menus'));
        $rules->add($rules->existsIn(['parent_id'], 'ParentMenuItems'));
        return $rules;
    }
}
