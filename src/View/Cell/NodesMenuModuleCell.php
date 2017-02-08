<?php
namespace Content\View\Cell;

use Cake\Cache\Cache;
use Cake\Routing\Router;
use Content\Model\Entity\Node;
use Content\Model\Entity\Node\NodeInterface;
use Content\Model\Table\NodesTable;

/**
 * Class NodesMenuModuleCell
 * @package Content\View\Cell
 *
 * @property NodesTable $Nodes
 */
class NodesMenuModuleCell extends ModuleCell
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

    protected $_index = [];
    protected $_currentDepth = 0;

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

            $cacheKey = 'nodes_menu_' . $this->params['start_node'];
            $cached = Cache::read($cacheKey);


            if (!$cached) {
                $nodes = $this->Nodes->find('children', [
                    'for' => $this->params['start_node'],
                    'direct' => true
                ])->all()->toArray();

                $menu = $this->_buildMenu($nodes);
                $index = $this->_index;

                //Cache::write($cacheKey, compact('menu', 'index'));
            } else {
                $menu = $cached['menu'];
                $index = $cached['index'];
            }

            $this->params['menu'] = $menu;
        }

        $this->params['element_path'] = ($this->params['element_path']) ?: 'Content.Modules/NodesMenu/list';

        $this->set('params', $this->params);
        $this->set('index', $index);
    }

    protected function _buildMenu(array $nodes)
    {
        $this->_currentDepth++;
        $menu = [];
        foreach ($nodes as $node) {

            $item = $this->_buildMenuItem($node);
            if ($item) {
                $menu[] = $item;
            }
        }

        $this->_currentDepth--;
        return $menu;
    }
    
    protected function _buildMenuItem(NodeInterface $node)
    {
        if (!$node->isNodeEnabled()) {
            return false;
        }

        $url = $node->getNodeUrl();
        $title = $node->getNodeLabel();
        $class = $node->cssclass;
        $children = [];

        if ($this->_currentDepth <= $this->params['depth']) {
            $children = $this->_buildMenu($node->getChildNodes());
        }

        $item = [
            'title' => $title,
            'url' => $url,
            'class' => $class,
            'children' => $children
        ];

        // Index
        $indexKey = count($this->_index) . ':' . Router::url($url, true);
        $indexLabel = str_repeat('_', $this->_currentDepth - 1) . $title;
        $this->_index[$indexKey] = $indexLabel;


        return $item;
    }
}
