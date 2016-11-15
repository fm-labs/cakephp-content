<?php
namespace Content\Controller\Admin;

use Content\Controller\Admin\AppController;

/**
 * MenuItems Controller
 *
 * @property \Content\Model\Table\MenuItemsTable $MenuItems
 */
class MenuItemsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Menus', 'ParentMenuItems']
        ];
        $this->set('menuItems', $this->paginate($this->MenuItems));
        $this->set('_serialize', ['menuItems']);
    }

    /**
     * View method
     *
     * @param string|null $id Menu Item id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $menuItem = $this->MenuItems->get($id, [
            'contain' => ['Menus', 'ParentMenuItems', 'ChildMenuItems']
        ]);
        $this->set('menuItem', $menuItem);
        $this->set('_serialize', ['menuItem']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $menuItem = $this->MenuItems->newEntity();
        if ($this->request->is('post')) {
            $menuItem = $this->MenuItems->patchEntity($menuItem, $this->request->data);
            if ($this->MenuItems->save($menuItem)) {
                $this->Flash->success(__('The {0} has been saved.', __('menu item')));
                if ($menuItem->menu_id) {
                    return $this->redirect(['controller' => 'Menus', 'action' => 'manage', $menuItem->menu_id]);
                }
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('menu item')));
            }
        }
        $menus = $this->MenuItems->Menus->find('list', ['limit' => 200]);
        $parentMenuItems = $this->MenuItems->ParentMenuItems->find('list', ['limit' => 200]);
        $this->set(compact('menuItem', 'menus', 'parentMenuItems'));
        $this->set('_serialize', ['menuItem']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Menu Item id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $menuItem = $this->MenuItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menuItem = $this->MenuItems->patchEntity($menuItem, $this->request->data);
            if ($this->MenuItems->save($menuItem)) {
                $this->Flash->success(__('The {0} has been saved.', __('menu item')));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('menu item')));
            }
        }
        $menus = $this->MenuItems->Menus->find('list', ['limit' => 200]);
        $parentMenuItems = $this->MenuItems->ParentMenuItems->find('list', ['limit' => 200]);
        $this->set(compact('menuItem', 'menus', 'parentMenuItems'));
        $this->set('_serialize', ['menuItem']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu Item id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menuItem = $this->MenuItems->get($id);
        if ($this->MenuItems->delete($menuItem)) {
            $this->Flash->success(__('The {0} has been deleted.', __('menu item')));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('menu item')));
        }
        return $this->redirect(['action' => 'index']);
    }
}
