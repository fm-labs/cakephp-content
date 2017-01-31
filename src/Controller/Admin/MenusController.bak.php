<?php
namespace Content\Controller\Admin;

use Content\Controller\Admin\AppController;

/**
 * Menus Controller
 *
 * @property \Content\Model\Table\MenusTable $Menus
 */
class MenusController extends AppController
{

    public function manage($id = null) {
        $this->edit($id);

        $this->loadModel('Content.Nodes');
        $nodes = $this->Nodes->find()->where(['Nodes.site_id' => $id])->all()->toArray();
        $this->set('nodes', $nodes);

        $node = $this->Nodes->newEntity();
        $this->set('node', $node);
    }

}
