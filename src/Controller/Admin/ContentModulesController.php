<?php
namespace Content\Controller\Admin;

use Content\Controller\Admin\AppController;

/**
 * ContentModules Controller
 *
 * @property \Content\Model\Table\ContentModulesTable $ContentModules
 */
class ContentModulesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->Backend->executeAction();
    }

    /**
     * View method
     *
     * @param string|null $id Content Module id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Backend->executeAction();
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contentModule = $this->ContentModules->newEntity();
        if ($this->request->is('post')) {
            $contentModule = $this->ContentModules->patchEntity($contentModule, $this->request->data);
            if ($this->ContentModules->save($contentModule)) {
                $this->Flash->success(__d('content','The {0} has been saved.', __d('content','content module')));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__d('content','The {0} could not be saved. Please, try again.', __d('content','content module')));
            }
        }
        $modules = $this->ContentModules->Modules->find('list', ['limit' => 200]);
        $this->set(compact('contentModule', 'modules'));
        $this->set('_serialize', ['contentModule']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Content Module id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contentModule = $this->ContentModules->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contentModule = $this->ContentModules->patchEntity($contentModule, $this->request->data);
            if ($this->ContentModules->save($contentModule)) {
                $this->Flash->success(__d('content','The {0} has been saved.', __d('content','content module')));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__d('content','The {0} could not be saved. Please, try again.', __d('content','content module')));
            }
        }
        $modules = $this->ContentModules->Modules->find('list', ['limit' => 200]);
        $this->set(compact('contentModule', 'modules'));
        //$this->set('templates', $this->getModuleTemplatesAvailable());
        $this->set('_serialize', ['contentModule']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Content Module id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        //$this->request->allowMethod(['post', 'delete']);
        $contentModule = $this->ContentModules->get($id);
        if ($this->ContentModules->delete($contentModule)) {
            $this->Flash->success(__d('content','The {0} has been deleted.', __d('content','content module')));
        } else {
            $this->Flash->error(__d('content','The {0} could not be deleted. Please, try again.', __d('content','content module')));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function related($model = null, $modelId = null)
    {

        $contentModules = $this->ContentModules->find()->where([
            'refscope' => $model,
            'refid' => $modelId
        ])->contain(['Modules'])->all();

        //@TODO Read custom sections from page layout
        $sections = ['main', 'top', 'bottom', 'before', 'after', 'left', 'right'];
        $sections = array_combine($sections, $sections);

        //$sectionsModules = $this->Pages->ContentModules->find()->where(['refscope' => 'Content.Pages', 'refid' => $id]);
        //debug($sectionsModules);

        $availableModules = $this->ContentModules->Modules->find('list');

        $this->set('model', $model);
        $this->set('modelId', $modelId);
        $this->set('contentModules', $contentModules);
        $this->set('sections', $sections);
        $this->set('availableModules', $availableModules);

        $this->set('_serialize', ['model', 'modelId', 'contentModules', 'sections', 'availableModules']);
    }

    public function linkModule($model = null, $modelId = null)
    {

        $contentModule = $this->ContentModules->newEntity(
            [],
            ['validate' => false]
        );
        if ($this->request->is(['put', 'post'])) {

            $this->ContentModules->patchEntity($contentModule, $this->request->data);
            if ($this->ContentModules->save($contentModule)) {
                $this->Flash->success(__d('content','The content module has been saved for {0} {1}.', $model, $modelId));
            } else {
                $this->Flash->error(__d('content','The content module could not be saved for {0} {1}.', $model, $modelId));
            }

            list($plugin, $model) = pluginSplit($model);
            $redirect = ['controller' => $model, 'action' => 'manage', $modelId, '#' => 'content_modules'];
            if ($this->request->data('_redirect')) {
                $redirect = $this->request->data('_redirect');
            }

            return $this->redirect($redirect);
        }

    }
}
