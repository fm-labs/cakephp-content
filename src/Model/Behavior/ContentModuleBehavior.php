<?php

namespace Content\Model\Behavior;

use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\Utility\Inflector;

/**
 * Class ContentModuleBehavior
 *
 * @package Banana\Model\Behavior
 */
class ContentModuleBehavior extends Behavior
{
    /**
     * @var array
     */
    protected $_defaultConfig = [
        'alias' => null,
        'scope' => null,
        'className' => 'Content.ContentModules'
    ];

    /**
     * @param array $config Content module configuration
     * @return void
     */
    public function initialize(array $config)
    {
    }

    /**
     * @param Event $event The 'Model.initialize' event handler
     * @return void
     */
    public function modelInitialize(Event $event)
    {
        $tableAlias = $event->getSubject()->alias();

        if (!$this->getConfig('alias')) {
            $this->config('alias', Inflector::singularize($tableAlias) . 'Modules');
        }

        if (!$this->getConfig('scope')) {
            $this->config('scope', $tableAlias);
        }

        $this->_prepareTable($event->getSubject());
    }

    /**
     * Create model associations
     *
     * @param Table $table The model table
     * @return void
     */
    protected function _prepareTable(Table $table)
    {
        $config = $this->getConfig();
        $table->hasMany($config['alias'], [
            'className' => $config['className'],
            'foreignKey' => 'refid',
            'conditions' => ['refscope' => $config['scope']]
        ]);
    }

    /**
     * Listen to all Model events, including the 'Model.initialize' event
     *
     * @return array Implemented events
     */
    public function implementedEvents()
    {
        $events = parent::implementedEvents();
        $events['Model.initialize'] = 'modelInitialize';

        return $events;
    }
}
