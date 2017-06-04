<?php
namespace Content\Controller\Admin;

use Content\Controller\Admin\AppController;

/**
 * Categories Controller
 *
 * @property \Content\Model\Table\CategoriesTable $Categories
 */
class CategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('categories', $this->paginate($this->Categories));
        $this->set('_serialize', ['categories']);
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->className('Content.Category');
        $category = $this->Categories->get($id, [
            'contain' => ['Posts']
        ]);
        $this->set('category', $category);
        $this->set('_serialize', ['category']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'category')));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'category')));
            }
        }
        $this->set(compact('category'));
        $this->set('_serialize', ['category']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'category')));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'category')));
            }
        }
        $this->set(compact('category'));
        $this->set('_serialize', ['category']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__d('content', 'The {0} has been deleted.', __d('content', 'category')));
        } else {
            $this->Flash->error(__d('content', 'The {0} could not be deleted. Please, try again.', __d('content', 'category')));
        }
        return $this->redirect(['action' => 'index']);
    }
}
