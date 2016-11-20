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

        $this->loadModel('Content.MenuItems');
        $menuItems = $this->MenuItems->find()->where(['MenuItems.menu_id' => $id])->all()->toArray();
        $this->set('menuItems', $menuItems);

        $menuItem = $this->MenuItems->newEntity();
        $this->set('menuItem', $menuItem);
    }

}
