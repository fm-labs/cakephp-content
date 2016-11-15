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

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('menus', $this->paginate($this->Menus));
        $this->set('_serialize', ['menus']);
    }

    /**
     * View method
     *
     * @param string|null $id Menu id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => ['MenuItems', 'RootMenuItems']
        ]);
        $this->set('menu', $menu);
        $this->set('_serialize', ['menu']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $menu = $this->Menus->newEntity();
        if ($this->request->is('post')) {
            $menu = $this->Menus->patchEntity($menu, $this->request->data);
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('The {0} has been saved.', __('menu')));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('menu')));
            }
        }
        $this->set(compact('menu'));
        $this->set('_serialize', ['menu']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Menu id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menu = $this->Menus->patchEntity($menu, $this->request->data);
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('The {0} has been saved.', __('menu')));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('menu')));
            }
        }
        $this->set(compact('menu'));
        $this->set('_serialize', ['menu']);
    }


    public function manage($id = null) {
        $this->edit($id);

        $this->loadModel('Content.MenuItems');
        $menuItems = $this->MenuItems->find()->where(['MenuItems.menu_id' => $id])->all()->toArray();
        $this->set('menuItems', $menuItems);

        $menuItem = $this->MenuItems->newEntity();
        $this->set('menuItem', $menuItem);
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Menus->get($id);
        if ($this->Menus->delete($menu)) {
            $this->Flash->success(__('The {0} has been deleted.', __('menu')));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('menu')));
        }
        return $this->redirect(['action' => 'index']);
    }
}
