<?php
declare(strict_types=1);

namespace Content\Model\Table;

use Cake\Core\Plugin;
use Cake\Database\Schema\TableSchemaInterface;
use Cake\Validation\Validator;

/**
 * Modules Model
 *
 */
class ModulesTable extends BaseTable
{
    protected function _initializeSchema(TableSchemaInterface $schema): TableSchemaInterface
    {
        //$table->setColumnType('params', 'json');
        return $schema;
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
