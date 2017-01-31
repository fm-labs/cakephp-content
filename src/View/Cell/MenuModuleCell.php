<?php
namespace Content\View\Cell;

use Content\Model\Entity\Node;
use Content\Model\Table\NodesTable;

/**
 * Class MenuModuleCell
 * @package Content\View\Cell
 *
 * @property NodesTable $Nodes
 */
class MenuModuleCell extends ModuleCell
{
    public $modelClass = "Content.Nodes";

    public static $defaultParams = [
        'menu' => [],
        'start_node' => null,
        'depth' => 1,
        'level' => 0,
        'class' => '',
        'element_path' => null
    ];

    protected $_currentDepth = 0;
    protected $_manage = false;

    public function display()
    {
        if (empty($this->params['menu'])) {
            $this->loadModel('Content.Nodes');

            if (!$this->params['start_node']) {

                $siteId = $this->request->session()->read('Site.id');
                //@TODO Throw and handle exception when site id not found. Or fallback to default site.
                $rootNode = $this->Nodes->find()
                    ->where(['Nodes.site_id' => $siteId, 'Nodes.parent_id IS NULL'])
                    ->first();

                $this->params['start_node'] = $rootNode->id;
            }

            $nodes = $this->Nodes->find('children', [
                'for' => $this->params['start_node'],
                'direct' => true
            ])->all();

            //@TODO cache menu nodes
            $this->params['menu'] = $this->_buildMenu($nodes);
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
            
            $item = $this->_buildNode($item);
            if ($item) {
                $menu[] = $item;
            }
        }

        $this->_currentDepth--;
        return $menu;
    }
    
    protected function _buildNode(Node $item)
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

        $node = [
            'title' => $title,
            'url' => $url,
            'class' => $class,
            'children' => $children
        ];
        return $node;
    }
}
