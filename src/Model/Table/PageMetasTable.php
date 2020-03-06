<?php
namespace Content\Model\Table;

use Content\Model\Entity\PageMeta;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PageMetas Model
 *
 */
class PageMetasTable extends BaseTable
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

        $this->setTable(self::$tablePrefix . 'page_metas');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');
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
            ->requirePresence('model', 'create')
            ->notEmpty('model');

        $validator
            ->add('foreignKey', 'valid', ['rule' => 'numeric'])
            ->requirePresence('foreignKey', 'create')
            ->notEmpty('foreignKey');

        $validator
            ->allowEmpty('title');

        $validator
            ->allowEmpty('description');

        $validator
            ->allowEmpty('keywords');

        $validator
            ->allowEmpty('robots');

        $validator
            ->allowEmpty('lang');

        return $validator;
    }
}
