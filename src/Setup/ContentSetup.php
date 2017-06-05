<?php

namespace Content\Setup;

use Cake\Core\Exception\MissingPluginException;
use Cake\Core\Plugin;
use Cake\ORM\TableRegistry;
use Eav\Model\Table\EavAttributeSetsTable;
use Eav\Model\Table\EavAttributesTable;

/**
 * Class ContentSetup
 * @package Content\src\Setup
 *
 * @property EavAttributeSetsTable AttributeSets
 * @property EavAttributesTable Attributes
 *
 * @TODO !Experimental class!
 */
class ContentSetup
{
    public $pluginName = 'Content';

    public function __construct()
    {

        if (!Plugin::loaded('Eav')) {
            throw new MissingPluginException(['plugin' => 'Eav']);
        }

        $this->AttributeSets = TableRegistry::get('Eav.EavAttributeSets');
        $this->Attributes = TableRegistry::get('Eav.EavAttributes');
    }

    public function activate()
    {
        if (!$this->AttributeSets->register('Content.Posts', 'default', ['title' => __d('content', 'Default'), 'is_system' => true])) {
            throw new \Exception('Failed to register attribute set default');
        }

        $this->Attributes->register('Content.Posts', 'default', [
           'test_attribute' => [
               'title' => 'Test Attribute String',
               'type' => 'string',
               'is_required' => true
           ],
            'test_attribute_int' => [
                'title' => 'Test Attribute Int',
                'type' => 'int',
                'is_required' => true
            ]
        ]);
    }

    public function deactivate()
    {
        //$this->AttributeSets->unregister('Content.Posts', 'default');
        //$this->Attributes->unregister('Content.Posts', 'default', ['test_attribute']);
    }
}