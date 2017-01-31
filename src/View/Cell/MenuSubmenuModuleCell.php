<?php
namespace Content\View\Cell;

use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\View\Cell;
use Content\Model\Table\NodesTable;
use Content\Model\Table\PagesTable;

/**
 * Class MenuSubmenuModuleCell
 * @package Content\View\Cell
 *
 * @property NodesTable $Nodes
 */
class MenuSubmenuModuleCell extends MenuModuleCell
{
    public $modelClass = "Content.Nodes";

    public function display($nodeId = null)
    {
        $this->loadModel('Content.Nodes');
        $nodes = $this->Nodes->find('children', ['for' => $this->params['start_node']]);
        $this->params['menu'] = $this->_buildMenu($nodes);
        $this->params['element_path'] = ($this->params['element_path']) ?: 'Content.Modules/Menu/menu_list';

        $this->set('params', $this->params);
    }

}
