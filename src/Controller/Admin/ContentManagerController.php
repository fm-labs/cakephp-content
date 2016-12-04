<?php

namespace Content\Controller\Admin;

use Cake\Network\Exception\NotFoundException;

class ContentManagerController extends AppController
{

    public function index()
    {
    }

    public function treeData()
    {
        $this->viewBuilder()->className('Json');

        $this->loadModel('Banana.Sites');
        $sitesTree = $this->Sites->toJsTree();
        $this->set('tree', $sitesTree);
        $this->set('_serialize', 'tree');
    }

}