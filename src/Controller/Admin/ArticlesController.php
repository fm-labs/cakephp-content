<?php
declare(strict_types=1);

namespace Content\Controller\Admin;

use Cake\Routing\Router;
use Content\ContentManager;

/**
 * Articles Controller
 *
 * @property \Content\Model\Table\ArticlesTable $Articles
 */
class ArticlesController extends AppController
{
    protected $articleType = 'post';

    /**
     * @var string
     */
    public $modelClass = 'Content.Articles';

    /**
     * @var array
     */
    public $actions = [
        'index' => 'Admin.Index',
        'view' => 'Admin.View',
        //'add' => 'Admin.Add',
        //'edit' => 'Admin.Edit',
        'delete' => 'Admin.Delete',
        'publish' => 'Admin.Publish',
        'unpublish' => 'Admin.Unpublish',
    ];

    /**
     * @param null $id
     */
    public function preview($id = null)
    {
        $previewKey = uniqid('preview');
        $this->getRequest()->getSession()->write('Content.previewKey', $previewKey);
        $article = $this->Articles->get($id);
        $url = $article->getUrl();
        $url = Router::url($url);

        $url .= strpos('?', $url) === 0 ? '?' : '&';
        $url .= 'preview=' . $previewKey;
        $this->redirect($url);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => [],
            'order' => ['Articles.title ASC'],
            'conditions' => ['Articles.type' => $this->articleType],
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
        $this->set('queryObj', $this->Articles->find()->find('withUri')->find('withAttributes'));

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

        $scope = ['Articles.refscope' => 'Content.Articles', 'Articles.refid IS' => null];
        $order = ['Articles.title' => 'ASC'];

        $q = $this->request->getQuery('q');
        if ($q) {
            $scope['Articles.title LIKE'] = '%' . $q . '%';
        }
        $type = $this->request->getQuery('type');
        if ($type) {
            $scope['Articles.type'] = $type;
        }

        $this->paginate = [
            'contain' => [],
            'order' => $order,
            'limit' => 200,
            'maxLimit' => 200,
            'conditions' => $scope,
            //'media' => true,
        ];
        $articles = $this->paginate($this->Articles);

        // if in search mode and there is only a single result
        // go straight to the result item edit
        if ($q && count($articles) == 1) {
            $this->Flash->info('Redirected from search for \'' . $q . '\'');
            $this->redirect(['action' => 'edit', $articles->first()->id ]);
        }

        $this->set('articlesList', $this->Articles->find('list')->where($scope)->order($order));
        $this->set('articles', $articles);
        $this->set('_serialize', ['articles']);
    }

    /**
     * @deprecated
     */
    public function quick()
    {
        if ($this->request->is(['post', 'put'])) {
            $id = $this->request->getData('id');
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
        $article = $this->Articles->newEntity($this->request->getQuery(), ['validate' => false]);
        $article->type = $this->articleType;

        if ($this->request->is('post')) {
            $article->setAccess('type', false);
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'content')));

                /*
                if ($link == true && $refid && $refscope) {
                    $this->loadModel('Content.Modules');
                    $module = $this->Modules->newEntity([
                        'name' => sprintf('Article_%s_%s', $content->id, uniqid()),
                        'path' => 'Content.ArticlesView',
                    ]);
                    $module->setParams(['post_id' => $content->id]);

                    if ($this->Modules->save($module)) {
                        $this->loadModel('Content.ContentModules');
                        $contentModule = $this->ContentModules->newEmptyEntity();
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

                return $this->redirect(['action' => 'edit', $article->id]);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'content')));
            }
        } else {
            $this->Articles->patchEntity($article, $this->request->getQuery(), ['validate' => false]);
        }

        $this->set(compact('article'));
        $this->set('_serialize', ['content']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $article = $this->Articles
            ->find('all', [
                'contain' => ['Parent'/*, 'ContentModules' => ['Modules']*/],
                'media' => true,
            ])
            ->find('withAttributes')
            ->where(['Articles.id' => $id])
            ->firstOrFail();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'content')));

                return $this->redirect(['action' => 'edit', $article->id]);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'content')));
            }
        }

        $teaserTemplates = ContentManager::getAvailableArticleTeaserTemplates();
        $templates = ContentManager::getAvailableArticleTemplates();

        //@TODO HtmlEditor config
        //$editor = Configure::read('HtmlEditor.content');
        //$editor['body_class'] = $article->cssclass;
        //$editor['body_id'] = $article->cssid;
        $editor = [];

        $template = 'edit';
        /*
        if (!$article->parent_id) {
            $template .= '_parent';
        }
        if ($article->type) {
            $template .= '_' . $article->type;
        } else {
            $template = 'edit_type';
        }
        */

        $this->set(compact('article', 'teaserTemplates', 'templates', 'editor'));
        $this->set('_serialize', 'article');
        //$this->set('typeElement', 'Content.Admin/Articles/' . 'edit_' . $article->type);

        //$this->autoRender = false;
        //$this->render($template);
    }

    /**
     * @param null $id
     */
    public function view($id = null)
    {
        $article = $this->Articles->get($id, [
            //'contain' => ['ContentModules' => ['Modules']],
            'media' => true,
        ]);

        $this->set('article', $article);
        $this->set('_serialize', $article);
    }
}
