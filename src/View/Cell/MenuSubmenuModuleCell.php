<?php
namespace Content\View\Cell;

use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\View\Cell;
use Content\Model\Table\MenuItemsTable;
use Content\Model\Table\PagesTable;

/**
 * Class MenuSubmenuModuleCell
 * @package Content\View\Cell
 *
 * @property MenuItemsTable $MenuItems
 */
class MenuSubmenuModuleCell extends MenuModuleCell
{
    public $modelClass = "Content.MenuItems";

    public function display($menuItemId = null)
    {
        $this->loadModel('Content.MenuItems');
        $menu_items = $this->MenuItems->find('children', ['for' => $this->params['start_node']]);
        $this->params['menu'] = $this->_buildMenu($menu_items);
        $this->params['element_path'] = ($this->params['element_path']) ?: 'Content.Modules/Menu/menu_list';

        $this->set('params', $this->params);
    }

}
