<?php
namespace Content\Controller\Admin;

use Content\Controller\Admin\AppController;

/**
 * PageLayouts Controller
 *
 * @property \Content\Model\Table\PageLayoutsTable $PageLayouts
 */
class PageLayoutsController extends AppController
{
    /**
     * @var array
     */
    public $actions = [
        'index'     => 'Backend.Index',
        'view'      => 'Backend.View',
        'add'       => 'Backend.Add',
        'edit'      => 'Backend.Edit',
        'delete'    => 'Backend.Delete',
    ];

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->Action->execute();
    }

    /**
     * View method
     *
     * @param string|null $id Page Layout id.
     * @return void
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Action->execute();
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pageLayout = $this->PageLayouts->newEntity();
        if ($this->request->is('post')) {
            $pageLayout = $this->PageLayouts->patchEntity($pageLayout, $this->request->data);
            if ($this->PageLayouts->save($pageLayout)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'page layout')));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'page layout')));
            }
        }
        $this->set(compact('pageLayout'));
        $this->set('_serialize', ['pageLayout']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Page Layout id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pageLayout = $this->PageLayouts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pageLayout = $this->PageLayouts->patchEntity($pageLayout, $this->request->data);
            if ($this->PageLayouts->save($pageLayout)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'page layout')));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'page layout')));
            }
        }
        $this->set(compact('pageLayout'));
        $this->set('_serialize', ['pageLayout']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Page Layout id.
     * @return void Redirects to index.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pageLayout = $this->PageLayouts->get($id);
        if ($this->PageLayouts->delete($pageLayout)) {
            $this->Flash->success(__d('content', 'The {0} has been deleted.', __d('content', 'page layout')));
        } else {
            $this->Flash->error(__d('content', 'The {0} could not be deleted. Please, try again.', __d('content', 'page layout')));
        }

        return $this->redirect(['action' => 'index']);
    }
}
