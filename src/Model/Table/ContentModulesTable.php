<?php
declare(strict_types=1);

namespace Content\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * PageModules Model
 */
class ContentModulesTable extends BaseTable
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        $this->setTable(self::$tablePrefix . 'content_modules');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        /*
        $this->belongsTo('Pages', [
            'foreignKey' => 'page_id',
            'className' => 'Content.Pages'
        ]);
        */
        $this->belongsTo('Modules', [
            'foreignKey' => 'module_id',
            'joinType' => 'INNER',
            'className' => 'Content.Modules',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): \Cake\Validation\Validator
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmptyString('id', 'create');

        $validator
            ->allowEmptyString('refscope');

        $validator
            ->add('refid', 'valid', ['rule' => 'numeric'])
            ->allowEmptyString('refid');

        $validator
            //->add('template', 'valid', ['rule' => 'alphanumeric'])
            ->allowEmptyString('template');

        $validator
            ->add('section', 'valid', ['rule' => 'alphanumeric'])
            ->allowEmptyString('section');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): \Cake\ORM\RulesChecker
    {
        //$rules->add($rules->existsIn(['page_id'], 'Pages'));
        $rules->add($rules->existsIn(['module_id'], 'Modules'));

        return $rules;
    }
}
