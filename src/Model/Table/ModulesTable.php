<?php
namespace Content\Model\Table;

use Cake\Core\Plugin;
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
class ModulesTable extends BaseTable
{
    protected function _initializeSchema(Schema\Table $table)
    {
        //$table->setColumnType('params', 'json');
        return $table;
    }

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        $this->setTable(self::$tablePrefix . 'modules');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        if (Plugin::isLoaded('Search')) {
            $this->addBehavior('Search.Search');
            $this->searchManager()
                ->add('name', 'Search.Like', [
                    'before' => true,
                    'after' => true,
                    'fieldMode' => 'OR',
                    'comparison' => 'LIKE',
                    'wildcardAny' => '*',
                    'wildcardOne' => '?',
                    'field' => ['name'],
                ])
                ->add('path', 'Search.Like', [
                    'before' => true,
                    'after' => true,
                    'fieldMode' => 'OR',
                    'comparison' => 'LIKE',
                    'wildcardAny' => '*',
                    'wildcardOne' => '?',
                    'field' => ['path'],
                ]);
        }
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
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->allowEmptyString('title');

        $validator
            ->requirePresence('path', 'create')
            ->notEmptyString('path');

        $validator
            ->allowEmptyString('params');

        return $validator;
    }
}
