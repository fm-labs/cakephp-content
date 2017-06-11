<?php

namespace Content\Model\Table;

use Banana\Model\ArrayTable;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Content\Lib\PageTypeRegistry;

class PageTypesTable extends ArrayTable
{
    /**
     * @var PageTypeRegistry
     */
    protected $_registry;

    /**
     * @var array
     */
    protected $_items;

    /**
     * Initialize
     */
    public function initialize()
    {
        $this->_registry = new PageTypeRegistry();
    }

    /**
     * Return array table data
     *
     * @return array
     */
    public function getItems()
    {
        if (!$this->_items) {
            $event = EventManager::instance()->dispatch(new Event('Content.Model.PageTypes.get'));
            $this->_items = $event->result;
        }

        return $this->_items;
    }
}
