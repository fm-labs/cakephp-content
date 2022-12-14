<?php
declare(strict_types=1);

namespace Content\View\Cell;

use Cake\View\Cell;
use Content\Model\Entity\Menu;
use Cupcake\Menu\MenuItemCollection;

/**
 * Class MenuModule
 *
 * @package Content\View\Module
 * @property \Content\Model\Table\MenusTable $Menus
 */
class MenuCell extends Cell
{
    public $modelClass = "Content.Menus";

    public $menuId;
    public $menu;
    public $start_node = 0;
    public $depth = 0;
    public $level = 0;
    public $class = '';
    public $element_path = 'Content.Menu/default';

    protected $_validCellOptions = ['menu', 'menuId', 'start_node', 'depth', 'level', 'class', 'element_path'];

    /**
     * Display method.
     *
     * @return void
     */
    public function display(): void
    {
        if (!isset($this->menu)) {
            $this->loadModel('Content.Menus');
            $startNodeId = $this->_getStartNodeId();
            if (!$startNodeId) {
                debug("No menu start node found");
                return;
            }
            $menu = $this->Menus->getMenu($startNodeId, ['maxDepth' => $this->depth]);
            $menu = $menu instanceof MenuItemCollection ? $menu->toArray() : (array)$menu;
            $this->menu = $menu;
        }

        $this->set('menu', $this->menu);
        //$this->set('level', $this->level);
        //$this->set('class', $this->class);
        $this->set('element_path', $this->element_path);
        //$this->set('start_node', $this->start_node);
    }

    /**
     * Selectbox display method.
     *
     * @param array $attrs Additional selectbox attributes
     * @return void
     */
    public function selectbox($attrs = []): void
    {
        $this->loadModel('Content.Menus');
        $startNodeId = $this->_getStartNodeId();
        $list = $this->Menus->getMenuTree($startNodeId, ['maxDepth' => $this->depth]);

        $this->set('opts', $list);
        $this->set('attrs', $attrs);
    }

    /**
     * Find menu start node ID.
     *
     * @return int|mixed
     */
    protected function _getStartNodeId()
    {
        $startNode = null;
        if (!$this->start_node && $this->menuId) {
          $startNode = $this->Menus->find()->where(['parent_id IS NULL'])->andWhere(['title' => $this->menuId])->first();
        } elseif ($this->start_node < 1) {
            $startNode = $this->Menus->find()->where(['parent_id IS NULL'])->first();
        }
        if ($startNode) {
            return $startNode->id;
        }

        return $this->start_node;
    }
}
