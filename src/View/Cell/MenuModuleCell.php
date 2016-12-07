<?php
namespace Content\View\Cell;

use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\View\Cell;
use Content\Model\Entity\MenuItem;
use Content\Model\Table\MenusTable;

/**
 * Class MenuModuleCell
 * @package Content\View\Cell
 *
 * @property MenusTable $Menus
 */
class MenuModuleCell extends ModuleCell
{
    public $modelClass = "Content.Menus";

    public static $defaultParams = [
        'menu' => [],
        'start_node' => 0,
        'depth' => 1,
        'level' => 0,
        'class' => '',
        'element_path' => null
    ];

    protected $_currentDepth = 0;
    protected $_manage = false;

    public function display($menuId = null)
    {
        if (empty($this->params['menu']) && $menuId) {
            $this->loadModel('Content.Menus');

            $menu = $this->Menus->find()
                ->where(['Menus.id' => $menuId])
                ->contain(['MenuItems' => function (Query $q) use ($menuId) {
                    return $q
                        ->where(['MenuItems.menu_id' => $menuId, 'MenuItems.parent_id IS NULL']);
                }
                ])
                ->first();

            if ($menu) {
                $this->params['menu'] = $this->_buildMenu($menu->menu_items);
            }
        }

        $this->params['element_path'] = ($this->params['element_path']) ?: 'Content.Modules/Menu/menu_list';

        $this->set('params', $this->params);
    }

    public function manage($menuId = null) {
        $this->_manage = true;
        $this->display($menuId);
        $this->_manage = false;
    }

    protected function _buildMenu($items)
    {
        $this->_currentDepth++;
        $menu = [];
        foreach ($items as $item) {
            
            $item = $this->_buildMenuItem($item);
            if ($item) {
                $menu[] = $item;
            }
        }

        $this->_currentDepth--;
        return $menu;
    }
    
    protected function _buildMenuItem(MenuItem $item)
    {
        if ($item->handler()->isHiddenInNav()) {
            return false;
        }

        $title = $item->handler()->getLabel();
        $url = ($this->_manage) ? $item->getAdminUrl() : $item->getViewUrl();
        $class = $item->cssclass;
        $children = [];

        if ($this->_currentDepth <= $this->params['depth'] && $item->getChildren()) {
            $children = $this->_buildMenu($item->getChildren()->all()->toArray());
        }

        $menuItem = [
            'title' => $title,
            'url' => $url,
            'class' => $class,
            'children' => $children
        ];
        return $menuItem;
    }
}
