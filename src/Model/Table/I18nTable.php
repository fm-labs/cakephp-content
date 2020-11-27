<?php
declare(strict_types=1);

namespace Content\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContentI18n Model
 *
 * @method \Content\Model\Entity\I18N newEmptyEntity()
 * @method \Content\Model\Entity\I18N newEntity(array $data, array $options = [])
 * @method \Content\Model\Entity\I18N[] newEntities(array $data, array $options = [])
 * @method \Content\Model\Entity\I18N get($primaryKey, $options = [])
 * @method \Content\Model\Entity\I18N findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Content\Model\Entity\I18N patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Content\Model\Entity\I18N[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Content\Model\Entity\I18N|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Content\Model\Entity\I18N saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Content\Model\Entity\I18N[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Content\Model\Entity\I18N[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Content\Model\Entity\I18N[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Content\Model\Entity\I18N[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class I18NTable extends BaseTable
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

        $this->setTable('i18n');
        $this->setDisplayField('id');
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('locale')
            ->maxLength('locale', 6)
            ->requirePresence('locale', 'create')
            ->notEmptyString('locale');

        $validator
            ->scalar('model')
            ->maxLength('model', 255)
            ->requirePresence('model', 'create')
            ->notEmptyString('model');

        $validator
            ->integer('foreign_key')
            ->requirePresence('foreign_key', 'create')
            ->notEmptyString('foreign_key');

        $validator
            ->scalar('field')
            ->maxLength('field', 255)
            ->requirePresence('field', 'create')
            ->notEmptyString('field');

        $validator
            ->scalar('content')
            ->allowEmptyString('content');

        return $validator;
    }
}
