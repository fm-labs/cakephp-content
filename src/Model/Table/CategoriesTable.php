<?php
namespace Content\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Categories Model
 *
 * @method \Content\Model\Entity\Category get($primaryKey, $options = [])
 * @method \Content\Model\Entity\Category newEntity($data = null, array $options = [])
 * @method \Content\Model\Entity\Category[] newEntities(array $data, array $options = [])
 * @method \Content\Model\Entity\Category|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Content\Model\Entity\Category patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Content\Model\Entity\Category[] patchEntities($entities, array $data, array $options = [])
 * @method \Content\Model\Entity\Category findOrCreate($search, callable $callback = null, $options = [])
 */
class CategoriesTable extends BaseTable
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

        $this->setTable(self::$tablePrefix . 'categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Articles', [
            'className' => 'Content.Articles',
            'foreignKey' => 'refid',
            'conditions' => ['Articles.refscope' => 'Content.Categories'],
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
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug');

        $validator
            ->boolean('is_published')
            ->requirePresence('is_published', 'create')
            ->notEmptyString('is_published');

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
        $rules->add($rules->isUnique(['name']));

        return $rules;
    }
}
