<?php
namespace Content\Controller\Admin;

use Banana\Lib\ClassRegistry;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Content\Lib\ContentManager;

/**
 * Modules Controller
 *
 * @property \Content\Model\Table\ModulesTable $Modules
 */
class ModulesController extends AppController
{
    /**
     * @var string
     */
    public $modelClass = 'Content.Modules';

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'limit' => 50,
            'order' => ['Modules.name' => 'ASC']
        ];

        $this->set('fields.whitelist', ['name', 'path', 'params']);

        $this->set('rowActions', [
            [__d('content', 'Edit'), ['action' => 'edit', ':id']],
            [__d('content', 'Configure'), ['action' => 'configure', ':id']],
            [__d('content', 'Delete'), ['action' => 'delete', ':id'], ['type' => 'post']]
        ]);

        return $this->Action->execute();
    }

    /**
     * View method
     *
     * @param string|null $id Module id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Action->execute();
    }

    /**
     * @param null $id
     */
    public function configure($id = null)
    {
        $module = $this->Modules->get($id);
        $moduleOptions = $userArgs = [];

        //if (!$module->path || !$module->cellClass) {
        //    $this->Flash->error("Invalid module path set");
        //}

        if ($this->request->is(['put', 'post'])) {
            $params = $this->request->data();

            $save = false;
            if (isset($params['_save']) && $params['_save']) {
                $save = true;
                unset($params['_save']);
            }
            $module->setParams($params);

            if ($save && $this->Modules->save($module)) {
                $this->Flash->success(__d('content', 'Module configuration saved'));
            }
        }

        $previewUrl = $module->getAdminPreviewUrl();
        $this->set('previewUrl', Router::url($previewUrl));

        $this->request->data = $moduleOptions = $module->params_arr;
        $this->set(compact('module', 'moduleOptions', 'userArgs'));
    }

    /**
     *
     */
    public function preview()
    {

        $path = $this->request->query('path');
        $params = $this->request->query('params');
        if ($params) {
            $params = json_decode(base64_decode($params), true);
        }

        $class = ClassRegistry::getClass('ContentModule', $path);

        $this->set('moduleClass', $class);
        $this->set('moduleParams', $params);

        $this->viewBuilder()
            ->layout('frontend')
            ->theme(Configure::read('Site.theme'))
            ->className('Content.Content');

        $this->set('_bare', true);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $module = $this->Modules->newEntity();
        if ($this->request->is('post')) {
            $module = $this->Modules->patchEntity($module, $this->request->data);
            if ($this->Modules->save($module)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'module')));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'module')));
            }
        }
        $this->set('paths', ContentManager::getModulesAvailable());
        $this->set(compact('module'));
        $this->set('_serialize', ['module']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Module id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $module = $this->Modules->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $module = $this->Modules->patchEntity($module, $this->request->data);
            if ($this->Modules->save($module)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'module')));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'module')));
            }
        }
        $this->set('paths', ContentManager::getModulesAvailable());
        $this->set(compact('module'));
        $this->set('_serialize', ['module']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Module id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $module = $this->Modules->get($id);
        if ($this->Modules->delete($module)) {
            $this->Flash->success(__d('content', 'The {0} has been deleted.', __d('content', 'module')));
        } else {
            $this->Flash->error(__d('content', 'The {0} could not be deleted. Please, try again.', __d('content', 'module')));
        }

        return $this->redirect(['action' => 'index']);
    }
}
