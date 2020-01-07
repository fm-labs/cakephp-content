<?php
namespace Content\View\Module;

use Banana\Menu\Menu;
use Cake\Cache\Cache;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\View\Cell;
use Content\Model\Table\MenusTable;
use Content\Model\Table\PagesTable;
use Banana\View\ViewModule;

/**
 * Class MenuModule
 *
 * @package Content\View\Module
 * @property MenusTable $Menus
 */
class MenuModule extends ViewModule
{
    public $modelClass = "Content.Menus";

    public $menu = [];
    public $start_node = 0;
    public $depth = 0;
    public $level = 0;
    public $class = '';
    public $element_path = 'Content.Modules/Menu/menu_list';

    protected $_validCellOptions = ['menu', 'start_node', 'depth', 'level', 'class', 'element_path'];

    protected $_index = [];
    protected $_activeIndex;
    protected $_depth = 0;

    public function display()
    {
        if (empty($this->menu)) {
            $this->loadModel('Content.Menus');
            $startNodeId = $this->_getStartNodeId();
            $menu = $this->Menus->getMenu($startNodeId, ['maxDepth' => $this->depth]);
            $menu = ($menu instanceof Menu) ? $menu->toArray() : (array)$menu;
            $this->menu = $menu;
        }

        //$this->element_path = ($this->element_path) ?: 'Content.Modules/Menu/menu_list';

        $this->set('menu', $this->menu);
        $this->set('level', $this->level);
        $this->set('class', $this->class);
        $this->set('element_path', $this->element_path);
        $this->set('start_node', $this->start_node);

        //$this->set('index', $this->_index);
        //$this->set('activeIndex', $this->_activeIndex);
        //$this->set('activePageId', $this->request->param('page_id'));
    }

    public function selectbox($params = [])
    {
        $this->loadModel('Content.Menus');
        $startNodeId = $this->_getStartNodeId();
        $list = $this->Menus->getMenuTree($startNodeId, ['maxDepth' => $this->depth]);

        $this->element_path = 'Content.Modules/Menu/select_list';

        $this->set('opts', $list);
        $this->set('attrs', $params);
    }

    protected function _getStartNodeId()
    {
        if ($this->start_node == 0) {
            $startNode = $this->Menus->find()->where(['parent_id IS NULL'])->first();
            if ($startNode) {
                return $startNode->id;
            }
        }

        return $this->start_node;
    }
}
