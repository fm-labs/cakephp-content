<?php
declare(strict_types=1);

namespace Content\View\Module;

use Cake\View\Cell;
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

    public $menu;
    public $start_node = 0;
    public $depth = 0;
    public $level = 0;
    public $class = '';

    protected $_validCellOptions = ['menu', 'start_node', 'depth', 'level', 'class'];

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
            $menu = $this->Menus->getMenu($startNodeId, ['maxDepth' => $this->depth]);
            $menu = $menu instanceof Menu ? $menu->toArray() : (array)$menu;
            $this->menu = $menu;
        }

        $this->set('menu', $this->menu);
        $this->set('level', $this->level);
        $this->set('class', $this->class);
        $this->set('element_path', $this->element_path);
        $this->set('start_node', $this->start_node);
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
        if ($this->start_node == 0) {
            $startNode = $this->Menus->find()->where(['parent_id IS NULL'])->first();
            if ($startNode) {
                return $startNode->id;
            }
        }

        return $this->start_node;
    }
}
