<?php
namespace Content\Controller\Admin;

use Backend\Controller\JsTreeAwareTrait;
use Banana\Controller\PrimaryModelAwareTrait;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Content\ContentManager;

/**
 * Galleries Controller
 *
 * @property \Content\Model\Table\GalleriesTable $Galleries
 */
class GalleriesController extends AppController
{
    use JsTreeAwareTrait;
    use PrimaryModelAwareTrait;

    /**
     * @var array
     */
    public $actions = [
        'index'     => 'Backend.Index',
        'view'      => 'Backend.View',
        'add'       => 'Backend.Add',
        'edit'      => 'Backend.Edit',
        'delete'    => 'Backend.Delete',
        'publish'   => 'Backend.Publish',
        'unpublish' => 'Backend.Unpublish',
    ];

    /**
     * @param Event $event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        if (!Plugin::isLoaded('Media')) {
            //$this->request->param('action', 'index');
            $this->Flash->warning(__d('content', '{0} plugin not loaded', 'Media'));
        }
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        if ($this->request->getQuery('id')) {
            $this->redirect(['action' => 'edit', $this->request->getQuery('id')]);
        }

        $this->paginate['limit'] = 100;
        $this->paginate['order'] = ['Galleries.title' => 'ASC'];
        $this->paginate['contain'] = ['Parent'];

        $this->set('fields.whitelist', true);
        $this->set('fields', [
            //'id' => [],
            'title' => [
                'formatter' => function ($val, $row, $args, $view) {
                    return $view->Html->link($val, ['action' => 'edit', $row->id]);
                },
            ],
            //'parent.title' => [],
            'parent_id' => [
                'formatter' => function ($val, $row, $args, $view) {
                    if ($row->parent) {
                        return $view->Html->link($row->parent['title'], ['action' => 'edit', $val]);
                        //return h($val->title);
                    }
                },
            ],
            'view_template' => [],
            'source' => [],
        ]);

        $this->Action->execute();
    }

    /**
     * Tree index method
     */
    public function indexTree()
    {
        $this->set('dataUrl', ['action' => 'treeData']);
    }

    /**
     * View method
     *
     * @param string|null $id Gallery id.
     * @return void
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $gallery = $this->Galleries->get($id, [
            'contain' => ['Articles'],
        ]);
        $this->set('gallery', $gallery);
        $this->set('_serialize', ['gallery']);
    }

    /**
     *
     */
    public function treeView()
    {
        $id = $this->request->getQuery('id');
        $this->setAction('edit', $id);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $gallery = $this->Galleries->newEntity();
        if ($this->request->is('post')) {
            $gallery = $this->Galleries->patchEntity($gallery, $this->request->getData());
            if ($this->Galleries->save($gallery)) {
                $this->Flash->success(__d('content', 'The gallery has been saved.'));

                return $this->redirect(['action' => 'edit', $gallery->id]);
            } else {
                $this->Flash->error(__d('content', 'The gallery could not be saved. Please, try again.'));
            }
        }

        $parents = $this->Galleries->find('list')->toArray();
        $sources = $this->Galleries->getSources();
        $sourceFolders = $this->Galleries->getSourceFolders();
        $viewTemplates = ContentManager::getAvailableGalleryTemplates();

        $this->set(compact('gallery', 'parents', 'sources', 'sourceFolders', 'viewTemplates'));
        $this->set('_serialize', ['gallery']);
    }

    /**
     * @param null $id
     * @return \Cake\Http\Response|null
     */
    public function addArticle($id = null)
    {
        $gallery = $this->Galleries->get($id, [
            'contain' => [],
        ]);

        $article = $this->Galleries->Articles->newEntity([
            'refscope' => 'Content.Galleries',
            'refid' => $id,
        ]);
        if ($this->request->is('post')) {
            $article = $this->Galleries->Articles->patchEntity($article, $this->request->getData());
            if ($this->Galleries->Articles->save($article)) {
                $this->Flash->success(__d('content', 'The gallery post has been saved.'));

                return $this->redirect(['action' => 'editArticle', $article->id]);
            } else {
                $this->Flash->error(__d('content', 'The gallery could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('gallery', 'post'));
        $this->set('_serialize', ['gallery', 'post']);
    }

    /**
     * @param null $id
     * @return \Cake\Http\Response|null
     */
    public function edit($id = null)
    {
        $gallery = $this->Galleries->get($id, [
            'contain' => ['Parent'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $gallery = $this->Galleries->patchEntity($gallery, $this->request->getData());
            if ($this->Galleries->save($gallery)) {
                $this->Flash->success(__d('content', 'The gallery has been saved.'));

                return $this->redirect(['action' => 'index', 'id' => $gallery->id]);
            } else {
                $this->Flash->error(__d('content', 'The gallery could not be saved. Please, try again.'));
            }
        }

        $parents = $this->Galleries->find('list')->toArray();
        $sources = $this->Galleries->getSources();
        $sourceFolders = $this->Galleries->getSourceFolders();
        $viewTemplates = ContentManager::getAvailableGalleryTemplates();
        $galleryArticles = $this->Galleries->Articles->find('sorted')->where(['refid' => $id]);

        $modules = TableRegistry::getTableLocator()->get('Content.Modules')->find()->where([
            'path' => 'flexslider',
            'params' => json_encode(['gallery_id' => (int)$id]),
        ])->all()->toArray();

        $this->set(compact('gallery', 'parents', 'sources', 'sourceFolders', 'viewTemplates', 'galleryArticles', 'modules'));
        $this->set('_serialize', ['gallery']);
    }

    /**
     * Manage method
     *
     * @param string|null $id Gallery id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function manage($id = null)
    {
        $this->setAction('edit', $id);
    }

    /**
     * @param null $articleId
     * @return \Cake\Http\Response|null
     */
    public function editArticle($articleId = null)
    {
        $article = $this->Galleries->Articles->get($articleId, [
            'contain' => ['ContentModules' => ['Modules']],
            'media' => true,
        ]);

        $gallery = $this->Galleries->get($article->refid);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $article = $this->Galleries->Articles->patchEntity($article, $this->request->getData());
            if ($this->Galleries->Articles->save($article)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'content')));

                return $this->redirect(['action' => 'edit_post', $article->id]);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'content')));
            }
        }

        $templates = ContentManager::getAvailableArticleTemplates();

        // HtmlEditor config
        $editor = Configure::read('HtmlEditor.content');
        $editor['body_class'] = $article->cssclass;
        $editor['body_id'] = $article->cssid;

        $this->set(compact('post', 'templates', 'editor', 'gallery'));
        $this->set('_serialize', ['post', 'gallery']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Gallery id.
     * @return void Redirects to index.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        //$this->request->allowMethod(['post', 'delete']);
        $gallery = $this->Galleries->get($id);
        if ($this->Galleries->delete($gallery)) {
            $this->Flash->success(__d('content', 'The gallery has been deleted.'));
        } else {
            $this->Flash->error(__d('content', 'The gallery could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
