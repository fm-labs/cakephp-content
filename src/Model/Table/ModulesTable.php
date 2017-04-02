<?php
namespace Content\Model\Table;

use Content\Model\Entity\Module;
use Cake\Core\App;
use Cake\Event\Event;
use Cake\Database\Schema;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Modules Model
 *
 */
class ModulesTable extends Table
{
    protected function _initializeSchema(Schema\Table $table)
    {
        //$table->columnType('params', 'json');
        return $table;
    }

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('bc_modules');
        $this->displayField('name');
        $this->primaryKey('id');
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');
            
        $validator
            ->allowEmpty('title');
            
        $validator
            ->requirePresence('path', 'create')
            ->notEmpty('path');
            
        $validator
            ->allowEmpty('params');

        return $validator;
    }
}
