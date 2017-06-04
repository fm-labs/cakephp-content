<?php

namespace Content\Controller\Admin;

/**
 * Class ContentManagerController
 * @package Content\Controller\Admin
 */
class ContentManagerController extends AppController
{
    /**
     * Index method
     */
    public function index()
    {
    }

    /**
     * Treedata method
     */
    public function treeData()
    {
        $this->viewBuilder()->className('Json');

        $this->loadModel('Banana.Sites');
        $sitesTree = $this->Sites->toJsTree();
        $this->set('tree', $sitesTree);
        $this->set('_serialize', 'tree');
    }
}
