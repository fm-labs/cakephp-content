<?php
namespace Content\Controller\Admin;

use Cake\Core\Exception\Exception;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\Form\Form;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\Table;
use Content\Lib\ContentManager;
use Media\Lib\Media\MediaManager;

/**
 * Class ContentController
 *
 * @package Content\Controller\Admin
 */
abstract class ContentController extends AppController
{
    /**
     * @var Table
     */
    protected $Model;

    /**
     * @var null|string
     */
    public $modelClass = null;

    /**
     * @param Event $event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        if (!$this->modelClass) {
            throw new Exception('No modelClass defined in controller ' . get_called_class());
        }

        $this->loadComponent('RequestHandler');
        //debug($this->RequestHandler->getConfig('viewClassMap'));
        //debug($this->RequestHandler->ext);
        //$this->components()->unload('RequestHandler');
    }

    /**
     * @param Event $event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);

        if ($this->request->is('json')) {
            $this->viewBuilder()->setClassName('Json');
        }

        $this->set('layoutsAvailable', $this->getLayoutsAvailable());
        $this->set('modulesAvailable', $this->getModulesAvailable());
        $this->set('moduleTemplatesAvailable', $this->getModuleTemplatesAvailable());
        $this->set('themesAvailable', $this->getThemesAvailable());
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('contents', $this->paginate($this->model()));
        $this->set('_serialize', ['contents']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Post id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $content = $this->model()->get($id, [
            'contain' => ['ContentModules' => ['Modules']],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $content = $this->model()->patchEntity($content, $this->request->data);
            if ($this->model()->save($content)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'content')));
                //return $this->redirect(['action' => 'edit', $content->id]);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'content')));
            }
        }

        if (Plugin::isLoaded('Media')) {
            $mm = MediaManager::get('default');
            $this->set('image_files', $mm->getSelectListRecursive());
        } else {
            $this->Flash->info(__("Recommended plugin: Media"));
        }

        $this->set(compact('content'));
        $this->set('_serialize', ['content']);
    }

    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return void
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $content = $this->model()->get($id, [
            'contain' => [],
        ]);
        $this->set('content', $content);
        $this->set('_serialize', ['content']);
    }

    /**
     * @param null $id
     */
    public function preview($id = null)
    {
        $this->redirect(['prefix' => false, 'plugin' => 'Content', 'controller' => 'Posts', 'action' => 'view', $id]);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $content = $this->model()->newEntity();
        if ($this->request->is('post')) {
            $content = $this->model()->patchEntity($content, $this->request->data);
            if ($this->model()->save($content)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'content')));

                return $this->redirect(['action' => 'edit', $content->id]);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'content')));
            }
        }
        $this->set(compact('content'));
        $this->set('_serialize', ['content']);
    }

    /**
     * @param null $id
     * @TODO Refactore with Backend action
     */
    public function duplicate($id = null)
    {
        $this->setAction('copy', $id);
    }

    /**
     * @param null $id
     * @return \Cake\Http\Response|null
     * @TODO Refactore with Backend action
     */
    public function copy($id = null)
    {
        $content = $this->model()->get($id);
        if (!$content) {
            throw new NotFoundException();
        }

        $duplicate = $this->model()->copyEntity($content);
        if ($this->request->is('post')) {
            $duplicate = $this->model()->patchEntity($duplicate, $this->request->data);

            if ($this->model()->save($duplicate)) {
                $this->Flash->success(__d('content', 'The {0} has been duplicated.', __d('content', 'content')));

                return $this->redirect(['action' => 'edit', $duplicate->id]);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be duplicated. Please, try again.', __d('content', 'content')));

                return $this->redirect($this->referer(['action' => 'index']));
            }
        }

        $this->set('content', $duplicate);
        $this->render('add');
    }

    /**
     * @param null $id
     */
    public function moveUp($id = null)
    {
        $node = $this->model()->moveUp($this->model()->get($id));

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setClassName('Json');
        } else {
            if ($node) {
                $this->Flash->success(__d('content', 'Moved'));
            } else {
                $this->Flash->error(__d('content', 'Failed to move'));
            }
            $this->redirect($this->referer(['action' => 'index']));
        }

        $this->set('node', $node);
        $this->set('_serialize', 'node');
    }

    /**
     * Delete method
     *
     * @param string|null $id Post id.
     * @return void Redirects to index.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        //$this->request->allowMethod(['post', 'delete']);
        $content = $this->model()->get($id);
        if ($this->model()->delete($content)) {
            $this->Flash->success(__d('content', 'The {0} has been deleted.', __d('content', 'content')));
        } else {
            $this->Flash->error(__d('content', 'The {0} could not be deleted. Please, try again.', __d('content', 'content')));
        }
        $this->redirect($this->referer(['action' => 'index']));
    }

    /**
     * @param null $id
     * @return \Cake\Http\Response|null
     */
    public function edit_modules($id = null)
    {
        $content = $this->model()->get($id, [
            'contain' => ['ContentModules' => ['Modules']],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $content = $this->model()->patchEntity($content, $this->request->data);
            if ($this->model()->save($content)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'content')));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'content')));
            }
        }
        $parentPages = $this->model()->ParentPages->find('list', ['limit' => 200]);
        $this->set(compact('content', 'parentPages'));
        $this->set('_serialize', ['content']);
    }

    /**
     * @param null $moduleId
     */
    public function edit_module($moduleId = null)
    {
        $this->loadModel('Content.Modules');
        //$content = $this->model()->get($id);
        $module = $this->Modules->get($moduleId);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $params = json_encode($this->request->data);
            $module = $this->Modules->patchEntity($module, ['params' => $params]);
            if ($this->Modules->save($module)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'module')));
                $this->redirect(['action' => 'edit_module', $moduleId]);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'content')));
            }
        }

        $this->set(compact('content', 'module'));
        $this->set('_serialize', ['content', 'module']);
    }

    /**
     * @param null $contentId
     */
    public function addPost($contentId = null)
    {
        $this->redirect([
            'controller' => 'Posts',
            'action' => 'add',
            'refscope' => 'Content.Pages',
            'refid' => $contentId,
            'link' => true,
        ]);
    }

    /**
     * @param null $contentId
     */
    public function addContentModule($contentId = null)
    {
        if (!$contentId) {
            $contentId = $this->request->getQuery('content_id');
        }

        $isAjax = ($this->request->getQuery('ajax') || $this->request->is('ajax'));
        $isIframe = $this->request->getQuery('iframe');

        if ($isIframe || $isAjax) {
            $this->layout = "iframe_module";
        }

        $content = $this->model()->get($contentId);
        if (!$content) {
            throw new NotFoundException("Page with ID %s not found", $contentId);
        }

        $this->loadModel('Content.ContentModules');
        $contentModule = $this->ContentModules->newEntity();

        if ($this->request->is('post')) {
            $contentModule = $this->ContentModules->patchEntity($contentModule, $this->request->data);
            debug($contentModule);
            if ($this->ContentModules->save($contentModule)) {
                $this->Flash->success(__d('content', 'Module {0} has been added to Content with ID {1}', $contentModule->module, $contentModule->refid));
                //$this->redirect(['action' => 'edit', $content->id]);
            } else {
                debug($contentModule->getErrors());
                $this->Flash->error('Ups. Something went wrong while creating the content module.');
            }
        } else {
            $contentModule->refid = ($contentModule->refid) ?: $contentId;
        }

        $this->set('availableModules', $this->ContentModules->Modules->find('list'));
        $this->set('sections', ContentManager::listContentSections());

        $this->set('contentModule', $contentModule);
    }

    /**
     * @param $contentId
     */
    public function createModule($contentId)
    {
        $content = $this->model()->get($contentId);

        $form = new Form();

        $module = $this->Modules->newEntity();
        $modulePath = 'Content.Text/Html';
        $moduleParams = [];

        if ($this->request->is('post')) {
            // verify module params form
            if ($form->execute($this->request->data)) {
                // module params are valid
                // now create content module
                $moduleParams = $this->request->data();
                $module = $this->Modules->patchEntity($module, [
                    'name' => sprintf('Module for Content %s [%s]', $content->id, uniqid()),
                    'path' => $modulePath,
                    'params' => json_encode($moduleParams),
                ]);
                /*
                $contentModule = $this->model()->ContentModules->newEntity();
                $contentModule->refscope = $this->modelClass;
                $contentModule->refid = $contentId;
                $contentModule->content = $content;
                $contentModule->module = $module;
                $contentModule->section = $section;

                if ($this->model()->ContentModules->save($contentModule)) {
                    $this->Flash->success(__d('content','Module {0} has been added to Content with ID {1}', $contentModule->module, $contentModule->refid));
                    $this->redirect(['action' => 'edit', $content->id]);
                } else {
                    $this->Flash->error('Ups. Something went wrong while creating the content module.');
                }
                */
            } else {
                $this->Flash->error('Please check your module params.');
            }
        } else {
            $this->request->data = $moduleParams;
        }
    }

    /**
     * Subclasses can override this method and return the primary model used in the controller
     * @return Table
     */
    protected function model()
    {
        if (!$this->Model) {
            $this->Model = $this->loadModel($this->modelClass);
        }

        return $this->Model;
    }
}
