<?php

namespace Content\Controller\Admin;

use Cupcake\Menu\MenuManager;

class ContentController extends AppController
{
    public function index() {
        return $this->redirect(['controller' => 'pages', 'action' => 'index']);
    }

    public function menus() {
        $menus = MenuManager::configured();
        $this->set(compact('menus'));

    }
}