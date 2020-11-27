<?php
declare(strict_types=1);

namespace Content\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Options Model
 *
 * @method \Content\Model\Entity\Option newEmptyEntity()
 * @method \Content\Model\Entity\Option newEntity(array $data, array $options = [])
 * @method \Content\Model\Entity\Option[] newEntities(array $data, array $options = [])
 * @method \Content\Model\Entity\Option get($primaryKey, $options = [])
 * @method \Content\Model\Entity\Option findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Content\Model\Entity\Option patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Content\Model\Entity\Option[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Content\Model\Entity\Option|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Content\Model\Entity\Option saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Content\Model\Entity\Option[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Content\Model\Entity\Option[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Content\Model\Entity\Option[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Content\Model\Entity\Option[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class OptionsTable extends BaseTable
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('options');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('model')
            ->maxLength('model', 255)
            ->allowEmptyString('model');

        $validator
            ->nonNegativeInteger('foreign_key')
            ->allowEmptyString('foreign_key');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('value')
            ->allowEmptyString('value');

        return $validator;
    }
}
