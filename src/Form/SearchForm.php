<?php
namespace Content\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * Class SearchForm
 *
 * @package Content\Form
 */
class SearchForm extends Form
{
    /**
     * @param Schema $schema
     * @return $this
     */
    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('query', 'string');
    }

    /**
     * @param Validator $validator
     * @return $this
     */
    protected function _buildValidator(Validator $validator)
    {
        return $validator->add('query', 'length', [
            'rule' => ['minLength', 1],
            'message' => 'A query is required'
        ]);
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function _execute(array $data)
    {
        // Send an email.
        return true;
    }
}
