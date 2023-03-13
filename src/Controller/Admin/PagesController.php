<?php
declare(strict_types=1);

namespace Content\Controller\Admin;

use Cake\Routing\Router;
use Content\ContentManager;
//use Content\Model\Table\PagesTable;

/**
 * Pages Controller
 *
 * @property \Content\Model\Table\PagesTable $Pages
 * @property \Admin\Controller\Component\ActionComponent $Action
 */
class PagesController extends AppController
{
    protected $pageType = 'page';

    /**
     * @var string
     */
    public $modelClass = 'Content.Pages';

    /**
     * @var array
     */
    public $actions = [
        'index' => 'Admin.Index',
        'view' => 'Admin.View',
        'add' => 'Admin.Add',
        'edit' => 'Admin.Edit',
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
        $page = $this->Pages->get($id);
        $url = $page->getUrl();
        $url = Router::url($url);

        $url .= strpos('?', $url) >= 0 ? '?' : '&';
        $url .= 'preview=' . $previewKey;
        $this->redirect($url);
    }

    public function add()
    {
        $this->set('fields.whitelist', ['type', 'title', 'is_published']);
        $this->set('fields', [
            'type' => [
                'default' => 'page'
            ]
        ]);
        $this->set('redirectUrl', true);
        $this->Action->execute();
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
            'order' => ['Pages.title ASC'],
            'conditions' => ['Pages.type' => $this->pageType],
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
                //$out .= "<br />";
                //$out .= "Url: " . $view->Html->link($row->getViewUrl()) . "<br />";
                //$out .= "PermaUrl: " . $view->Html->link($row->getPermaUrl()) . "<br />";
                //$out .= "Admin Url: " . $view->Html->link($row->getAdminUrl()) . "<br />";

                return $out;
            }],
        ]);

        $this->Pages = $this->loadModel("Content.Pages");
        $queryObj = $this->Pages->find(); //->find('withUri');
//        if ($this->Pages->behaviors()->has('Attributes')) {
//            $queryObj = $queryObj->find('withAttributres');
//        }
        $this->set('queryObj', $queryObj);

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

        $scope = ['Pages.refscope' => 'Content.Pages', 'Pages.refid IS' => null];
        $order = ['Pages.title' => 'ASC'];

        $q = $this->request->getQuery('q');
        if ($q) {
            $scope['Pages.title LIKE'] = '%' . $q . '%';
        }
        $type = $this->request->getQuery('type');
        if ($type) {
            $scope['Pages.type'] = $type;
        }

        $this->paginate = [
            'contain' => [],
            'order' => $order,
            'limit' => 200,
            'maxLimit' => 200,
            'conditions' => $scope,
            //'media' => true,
        ];
        $pages = $this->paginate($this->Pages);

        // if in search mode and there is only a single result
        // go straight to the result item edit
        if ($q && count($pages) == 1) {
            $this->Flash->info('Redirected from search for \'' . $q . '\'');
            $this->redirect(['action' => 'edit', $pages->first()->id ]);
        }

        $this->set('pagesList', $this->Pages->find('list')->where($scope)->order($order));
        $this->set('pages', $pages);
        $this->set('_serialize', ['pages']);
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
    public function _add()
    {
        $this->Pages = $this->loadModel("Content.Pages");
        $page = $this->Pages->newEntity($this->request->getQuery(), ['validate' => false]);
        $page->type = $this->pageType;

        if ($this->request->is('post')) {
            //$page->setAccess('type', false);
            $page = $this->Pages->patchEntity($page, $this->request->getData());
            if ($this->Pages->save($page)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'content')));

                /*
                if ($link == true && $refid && $refscope) {
                    $this->loadModel('Content.Modules');
                    $module = $this->Modules->newEntity([
                        'name' => sprintf('Page_%s_%s', $content->id, uniqid()),
                        'path' => 'Content.PagesView',
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

                return $this->redirect(['action' => 'edit', $page->id]);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'content')));
            }
        } else {
            $this->Pages->patchEntity($page, $this->request->getQuery(), ['validate' => false]);
        }

        $this->set(compact('page'));
        $this->set('_serialize', ['content']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Page id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $page = $this->Pages
            ->find('all', [
                'contain' => ['Parent'/*, 'ContentModules' => ['Modules']*/],
                'media' => true,
            ])
            //->find('withAttributes')
            ->where(['Pages.id' => $id])
            ->firstOrFail();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $page = $this->Pages->patchEntity($page, $this->request->getData());
            if ($this->Pages->save($page)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'content')));

                return $this->redirect(['action' => 'edit', $page->id]);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'content')));
            }
        }

        $teaserTemplates = ContentManager::getAvailablePageTeaserTemplates();
        $templates = ContentManager::getAvailablePageTemplates();

        //@TODO HtmlEditor config
        //$editor = Configure::read('HtmlEditor.content');
        //$editor['body_class'] = $page->cssclass;
        //$editor['body_id'] = $page->cssid;
        $editor = [];

        $template = 'edit';
        /*
        if (!$page->parent_id) {
            $template .= '_parent';
        }
        if ($page->type) {
            $template .= '_' . $page->type;
        } else {
            $template = 'edit_type';
        }
        */

        $attributes = [];
        //$attributes = $this->Pages->getAttributesSchema();

        //$this->set(compact('page', 'teaserTemplates', 'templates', 'editor', 'attributes'));
        $this->set(compact('page', 'editor'));
        //$this->set('_serialize', 'page');
        //$this->set('typeElement', 'Content.Admin/Pages/' . 'edit_' . $page->type);

        //$this->autoRender = false;
        //$this->render($template);
    }

    /**
     * @param null $id
     */
    public function view($id = null)
    {
        $page = $this->Pages->get($id, [
            //'contain' => ['ContentModules' => ['Modules']],
            'media' => true,
        ]);

        $this->set('page', $page);
        $this->set('_serialize', $page);
    }
}
