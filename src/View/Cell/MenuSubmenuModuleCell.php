<?php
namespace Content\View\Cell;

use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\View\Cell;
use Content\Model\Table\MenuItemsTable;
use Content\Model\Table\PagesTable;

/**
 * Class PagesSubmenuModuleCell
 * @package Content\View\Cell
 *
 * @property MenuItemsTable $MenuItems
 */
class PagesSubmenuModuleCell extends MenuModuleCell
{
    public $modelClass = "Content.MenuItems";


    public function display($menuItemId = null)
    {
        $menu_items = $this->MenuItems->find('children', ['for' => $menuItemId]);
        $this->params['menu'] = $this->_buildMenu($menu_items);
        $this->params['element_path'] = ($this->params['element_path']) ?: 'Content.Modules/Menu/menu_list';

        $this->set('params', $this->params);
    }

}
