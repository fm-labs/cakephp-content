<?php
/**
 * Created by PhpStorm.
 * User: flow
 * Date: 11/27/16
 * Time: 1:48 PM
 */

namespace Content\Form;


use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class SearchForm extends Form
{

    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('query', 'string');
    }

    protected function _buildValidator(Validator $validator)
    {
        return $validator->add('query', 'length', [
            'rule' => ['minLength', 1],
            'message' => 'A query is required'
        ]);
    }

    protected function _execute(array $data)
    {
        // Send an email.
        return true;
    }
}
