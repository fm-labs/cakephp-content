<?php
namespace Content\Controller\Admin;

use Cake\Core\Configure;
use Cake\Routing\Router;
use Content\Lib\ContentManager;

/**
 * Posts Controller
 *
 * @property \Content\Model\Table\PostsTable $Posts
 */
class PostsController extends AppController
{
    protected $postType = 'post';

    /**
     * @var string
     */
    public $modelClass = 'Content.Posts';

    /**
     * @var array
     */
    public $actions = [
        'index' => 'Backend.Index',
        'view' => 'Backend.View',
        //'add' => 'Backend.Add',
        'edit' => 'Backend.Edit',
        'delete' => 'Backend.Delete',
        'publish' => 'Backend.Publish',
        'unpublish' => 'Backend.Unpublish',
    ];

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => [],
            'order' => ['Posts.title ASC'],
            'conditions' => ['Posts.type' => $this->postType],
            'limit' => 200,
            'maxLimit' => 200,
        ];

        $this->set('fields.whitelist', ['title', 'type', 'slug', 'is_published']);
        $this->set('fields', [
            'title' => ['formatter' => function ($val, $row, $args, $view) {
                return $view->Html->link($val, ['action' => 'edit', $row->id]);
            }],
            'type' => ['formatter' => function ($val, $row, $args, $view) {
                $out = $val;
                $out .= "<br />";
                $out .= "Url: " . $view->Html->link($row->getViewUrl()) . "<br />";
                $out .= "PermaUrl: " . $view->Html->link($row->getPermaUrl()) . "<br />";
                $out .= "Admin Url: " . $view->Html->link($row->getAdminUrl()) . "<br />";

                return $out;
            }],
        ]);

        $this->Action->execute();
    }

    /**
     * Index method
     *
     * @return void
     * @deprecated
     */
    public function _index()
    {

        $scope = ['Posts.refscope' => 'Content.Posts', 'Posts.refid IS' => null];
        $order = ['Posts.title' => 'ASC'];

        $q = $this->request->getQuery('q');
        if ($q) {
            $scope['Posts.title LIKE'] = '%' . $q . '%';
        }
        $type = $this->request->getQuery('type');
        if ($type) {
            $scope['Posts.type'] = $type;
        }

        $this->paginate = [
            'contain' => [],
            'order' => $order,
            'limit' => 200,
            'maxLimit' => 200,
            'conditions' => $scope,
            //'media' => true,
        ];
        $posts = $this->paginate($this->Posts);

        // if in search mode and there is only a single result
        // go straight to the result item edit
        if ($q && count($posts) == 1) {
            $this->Flash->info('Redirected from search for \'' . $q . '\'');
            $this->redirect(['action' => 'edit', $posts->first()->id ]);
        }

        $this->set('postsList', $this->Posts->find('list')->where($scope)->order($order));
        $this->set('posts', $posts);
        $this->set('_serialize', ['posts']);
    }

    /**
     * @deprecated
     */
    public function quick()
    {
        if ($this->request->is(['post', 'put'])) {
            $id = $this->request->data('post_id');
            if ($id) {
                $this->redirect(['action' => 'edit', $id]);

                return;
            }
        }

        $this->Flash->error('Bad Request');
        $this->redirect($this->referer(['action' => 'index']));
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $post = $this->Posts->newEntity($this->request->query, ['validate' => false]);
        $post->type = $this->postType;

        if ($this->request->is('post')) {
            $post->accessible('type', false);
            $post = $this->Posts->patchEntity($post, $this->request->data);
            if ($this->Posts->save($post)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'content')));

                /*
                if ($link == true && $refid && $refscope) {
                    $this->loadModel('Content.Modules');
                    $module = $this->Modules->newEntity([
                        'name' => sprintf('Post_%s_%s', $content->id, uniqid()),
                        'path' => 'Content.PostsView',
                    ]);
                    $module->setParams(['post_id' => $content->id]);

                    if ($this->Modules->save($module)) {
                        $this->loadModel('Content.ContentModules');
                        $contentModule = $this->ContentModules->newEntity();
                        $contentModule->refscope = $refscope;
                        $contentModule->refid = $refid;
                        $contentModule->module_id = $module->id;
                        $contentModule->section = 'main';

                        if ($this->ContentModules->save($contentModule)) {
                            $this->Flash->success(__d('content','Content module has been created for post {0}', $content->id));
                        } else {
                            debug($contentModule->getErrors());
                        }
                    } else {
                        debug($module->getErrors());
                    }
                }
                */

                return $this->redirect(['action' => 'edit', $post->id]);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'content')));
            }
        } else {
            $this->Posts->patchEntity($post, $this->request->query, ['validate' => false]);
        }

        $this->set(compact('post'));
        $this->set('_serialize', ['content']);
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
        $post = $this->Posts->get($id, [
            'contain' => ['Parent', 'ContentModules' => ['Modules']],
            'media' => true,
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->Posts->patchEntity($post, $this->request->data);
            if ($this->Posts->save($post)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'content')));

                return $this->redirect(['action' => 'edit', $post->id]);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'content')));
            }
        }

        $teaserTemplates = ContentManager::getAvailablePostTeaserTemplates();
        $templates = ContentManager::getAvailablePostTemplates();

        //@TODO HtmlEditor config
        //$editor = Configure::read('HtmlEditor.content');
        //$editor['body_class'] = $post->cssclass;
        //$editor['body_id'] = $post->cssid;
        $editor = [];

        $template = 'edit';
        /*
        if (!$post->parent_id) {
            $template .= '_parent';
        }
        if ($post->type) {
            $template .= '_' . $post->type;
        } else {
            $template = 'edit_type';
        }
        */

        $this->set(compact('post', 'teaserTemplates', 'templates', 'editor'));
        $this->set('_serialize', 'post');
        //$this->set('typeElement', 'Content.Admin/Posts/' . 'edit_' . $post->type);

        $this->autoRender = false;
        $this->render($template);
    }

    /**
     * @param null $id
     */
    public function view($id = null)
    {
        $post = $this->Posts->get($id, [
            'contain' => ['ContentModules' => ['Modules']],
            'media' => true,
        ]);

        $this->set('post', $post);
        $this->set('_serialize', $post);
    }
}
