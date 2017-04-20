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
 * @property PagesTable $Pages
 */
class PagesMenuModule extends ViewModule
{
    public $modelClass = "Content.Pages";

    public $menu = [];
    public $start_node = 0;
    public $depth = 1; //@TODO Rename to maxDepth
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
            $this->menu = $this->Pages->getMenu($startNodeId, ['maxDepth' => $this->depth]);
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
