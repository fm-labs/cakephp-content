<?php
namespace Content\View\Module;

use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\View\Cell;
use Content\Model\Table\PagesTable;
use Banana\View\ViewModule;

/**
 * Class PagesMenuModule
 *
 * @package Content\View\Module
 */
class PagesMenuModule extends ViewModule
{
    public $modelClass = "Content.Pages";

    public $menu = [];
    public $start_node = 0;
    public $depth = 1;
    public $level = 0;
    public $class = '';
    public $element_path = null;

    protected $_validCellOptions = ['menu', 'start_node', 'depth', 'level', 'class', 'element_path'];

    protected $_index = [];
    protected $_activeIndex;
    protected $_depth = 0;

    public function display()
    {

        if (empty($this->menu)) {
            
            $this->loadModel('Content.Pages');

            $startNodeId = $this->_getStartNodeId();
            if ($startNodeId) {
                $children = $this->Pages
                    ->find('children', ['for' => $startNodeId])
                    ->find('threaded')
                    ->orderAsc('lft')
                    ->contain([])
                    ->toArray();

                $this->menu = $this->_buildMenu($children);
            } else {
                debug("Start node not found");
                $this->menu = [];
            }
        }

        $this->element_path = ($this->element_path) ?: 'Content.Modules/PagesMenu/menu_list';

        $this->set('menu', $this->menu);
        $this->set('level', $this->level);
        $this->set('class', $this->class);
        $this->set('element_path', $this->element_path);
        $this->set('start_node', $this->start_node);

        $this->set('index', $this->_index);
        $this->set('activeIndex', $this->_activeIndex);
        $this->set('activePageId', $this->request->param('page_id'));
    }

    protected function _buildMenu($children)
    {
        $this->_depth++;
        $menu = [];
        foreach ($children as $child) {
            $isActive = false;
            $class = $child->cssclass;

            if ($child->isPageHiddenInNav()) {
                continue;

            } elseif (!$child->isPagePublished()) {
                continue;

            //} elseif ($this->request->param('page_id') == $child->id) {
            //    $isActive = true;

            } elseif ($child->type == 'controller') {
                $plugin = $this->request->param('plugin');
                $controller = $this->request->param('controller');
                $needle = ($plugin)
                    ? Inflector::camelize($plugin) . '.' . Inflector::camelize($controller)
                    : Inflector::camelize($controller);

                //if ($child->redirect_location == $needle) {
                //    $isActive = true;
                //}
            }

            if ($isActive) {
                $class .= ' active';
            }

            $itemPageId = $child->getPageId();
            $item = [
                'title' => $child->getPageTitle(),
                'url' => $child->getPageUrl(),
                'class' => $class,
                '_children' => []
            ];

            $indexKey = count($this->_index) . ':' . Router::url($item['url'], true);
            $this->_index[$indexKey] = str_repeat('_', $this->_depth - 1) . $item['title'];
            //if ($isActive) {
            //    $this->_activeIndex = $indexKey;
            //}

            /*
            if ($child->children) {
                $item['_children'] = $this->_buildMenu($child->children);
            }
            */

            if ($this->_depth <= $this->depth && $child->getPageChildren()) {
                $item['_children'] = $this->_buildMenu($child->getPageChildren());
            }

            $menu[] = $item;
        }

        $this->_depth--;
        return $menu;
    }

    protected function _getStartNodeId()
    {
        if ($this->start_node > 0) {
            $nodeId = $this->start_node;
        } elseif ($this->start_node < 0) {
            $nodeId = $this->refid;
        } else {
            $rootNode = $this->Pages->findHostRoot();
            if (!$rootNode) {
                throw new \Exception('MenuListModule: No root node found');
            }
            $nodeId = $rootNode->id;
        }
        return $nodeId;
    }
}
