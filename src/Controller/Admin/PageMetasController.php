<?php
namespace Content\Controller\Admin;

use Content\Controller\Admin\AppController;

/**
 * PageMetas Controller
 *
 * @property \Content\Model\Table\PageMetasTable $PageMetas
 */
class PageMetasController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('pageMetas', $this->paginate($this->PageMetas));
        $this->set('_serialize', ['pageMetas']);
    }

    /**
     * View method
     *
     * @param string|null $id Page Meta id.
     * @return void
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pageMeta = $this->PageMetas->get($id, [
            'contain' => [],
        ]);
        $this->set('pageMeta', $pageMeta);
        $this->set('_serialize', ['pageMeta']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pageMeta = $this->PageMetas->newEntity();
        if ($this->request->is('post')) {
            $pageMeta = $this->PageMetas->patchEntity($pageMeta, $this->request->data);
            if ($this->PageMetas->save($pageMeta)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'page meta')));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'page meta')));
            }
        }
        $this->set('robots', $this->_getRobotsOptions());
        $this->set(compact('pageMeta'));
        $this->set('_serialize', ['pageMeta']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Page Meta id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pageMeta = $this->PageMetas->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pageMeta = $this->PageMetas->patchEntity($pageMeta, $this->request->data);
            if ($this->PageMetas->save($pageMeta)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'page meta')));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'page meta')));
            }
        }
        $this->set('robots', $this->_getRobotsOptions());
        $this->set(compact('pageMeta'));
        $this->set('_serialize', ['pageMeta']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Page Meta id.
     * @return void Redirects to index.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pageMeta = $this->PageMetas->get($id);
        if ($this->PageMetas->delete($pageMeta)) {
            $this->Flash->success(__d('content', 'The {0} has been deleted.', __d('content', 'page meta')));
        } else {
            $this->Flash->error(__d('content', 'The {0} could not be deleted. Please, try again.', __d('content', 'page meta')));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @return array
     */
    protected function _getRobotsOptions()
    {
        return [
            'index,follow' => 'Index, Follow',
            'noindex,nofollow' => 'NoIndex, NoFollow',
            'index,nofollow' => 'Index, No Follow',
            'noindex,follow' => 'NoIndex, Follow',
        ];
    }
}
