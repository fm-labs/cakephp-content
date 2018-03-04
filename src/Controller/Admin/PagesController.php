<?php

namespace Content\Controller\Admin;

use Backend\Controller\EntityInfoActionTrait;
use Backend\Controller\JsTreeAwareTrait;
use Banana\Controller\PrimaryModelAwareTrait;
use Cake\Event\Event;
use Cake\Network\Exception\BadRequestException;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Content\Lib\ContentManager;
use Content\Model\Table\PagesTable;
use Content\Page\PageInterface;
use Tree\Controller\TreeSortControllerTrait;

/**
 * Class PagesController
 * @package App\Controller\Admin
 *
 * @property PagesTable $Pages
 */
class PagesController extends ContentController
{
    use EntityInfoActionTrait;
    use JsTreeAwareTrait;
    use PrimaryModelAwareTrait;
    use TreeSortControllerTrait;

    /**
     * @var string
     */
    public $modelClass = "Content.Pages";

    /**
     * @var array
     */
    public $actions = [
        //'index'     => 'Backend.Index',
        'index'     => 'Backend.TreeIndex',
        'view'      => 'Backend.View',
        'add'       => 'Backend.Add',
        'edit'      => 'Backend.Edit',
        'delete'    => 'Backend.Delete',
        'publish'   => 'Backend.Publish',
        'sort'      => 'Backend.TreeSort',
        'repair'    => 'Backend.TreeRepair',
        /*
        'moveUp'    => 'Backend.TreeMoveUp',
        'moveDown'  => 'Backend.TreeMoveDown',
        */
    ];

    /**
     * @param Event $event
     * @return \Cake\Network\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->components()->unload('RequestHandler');

        $this->Action->registerInline('relatedPageMeta', ['form' => true, 'label' => 'Meta']);
        $this->Action->registerInline('relatedContentModules', ['form' => true, 'label' => __('Related Modules')]);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentPages'],
            'order' => ['Pages.lft ASC'],
            'limit' => 200,
            'maxLimit' => 200,
        ];

        $this->set([
           //'ajax' => true
        ]);
        $this->set('fields', [
            'title', 'type',
            'is_published' => [
               'type' => 'boolean'
            ]
        ]);
        $this->set('fields.whitelist', ['title', 'type', 'is_published']);
        $this->Action->execute();
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index2()
    {
        $this->paginate = [
            'contain' => ['ParentPages'],
            'order' => ['Pages.lft ASC'],
            'limit' => 200,
            'maxLimit' => 200,
        ];

        $this->set('fields.whitelist', ['title', 'type', 'is_published']);
        $this->set('fields', [
            //'title' => ['formatter' => function($val, $row, $args, $view) {
            //    return $view->Html->link($val, ['action' => 'edit', $row->id]);
            //}]
        ]);

        /*
        $this->set('actions', [
            [
                __d('content', 'Add {0}', __d('content', 'page')),
                ['action' => 'add']
            ],
            [
                __d('content', 'Sort'),
                ['plugin' => 'Backend', 'controller' => 'Tree', 'action' => 'index', 'model' => 'Shop.ShopCategories'],
                ['class' => 'link-modal-frame', 'data-modal-reload' => true, 'data-icon' => 'sitemap']
            ]
        ]);
        */

        $this->Action->execute();
    }

    /**
     * @param null $id
     */
    public function view($id = null)
    {
        $content = $this->Pages->get($id, [
            'contain' => ['ParentPages', 'Posts']
        ]);

        $this->set('related', [
            'Posts' => [
                'fields' => [
                    'id', 'title', 'slug', 'pos', 'is_published'
                ],
                'rowActions' => [
                    'edit' => [__('Edit'), ['controller' => 'Posts', 'action' => 'edit', ':id'], []]
                ]
            ]
        ]);
        $this->set('entity', $content);

        $this->Action->execute();
    }

    /**
     * @param null $id
     */
    public function relatedPosts($id = null)
    {
        $content = $this->Pages->get($id, [
            'contain' => []
        ]);

        $posts = $this->Pages->Posts
            ->find('sorted')
            ->where(['refid' => $id])
            //->order(['Posts.pos' => 'DESC'])
            ->all();

        $this->set('content', $content);
        $this->set('posts', $posts);
        $this->set('_serialize', ['content', 'posts']);
    }

    /**
     * @param null $id
     * @deprecated Use MetaBehavior instead
     */
    public function relatedPageMeta($id = null)
    {
        $PageMetas = TableRegistry::get('Content.PageMetas');

        $content = $this->Pages->get($id, [
            'contain' => []
        ]);

        $pageMeta = $content->meta;
        if (!$pageMeta) {
            $pageMeta = $PageMetas->newEntity(
                ['model' => 'Content.Pages', 'foreignKey' => $content->id],
                ['validate' => false]
            );
        }

        if ($this->request->is(['put', 'post'])) {
            $pageMeta = $PageMetas->patchEntity($pageMeta, $this->request->data);
            if ($PageMetas->save($pageMeta)) {
                $this->Flash->success('Successful');
            } else {
                $this->Flash->error('Failed');
            }
        }

        $this->set('content', $content);
        $this->set('pageMeta', $pageMeta);
        $this->set('_serialize', ['content', 'pageMeta']);
    }

    /**
     * @param null $id
     * @deprecated Use ContentModulesController->related() instead
     */
    public function relatedContentModules($id = null)
    {
        $content = $this->Pages->get($id, [
            'contain' => ['ContentModules' => ['Modules']]
        ]);

        //@TODO Read custom sections from page layout
        $sections = ['main', 'top', 'bottom', 'before', 'after', 'left', 'right'];
        $sections = array_combine($sections, $sections);

        //$sectionsModules = $this->Pages->ContentModules->find()->where(['refscope' => 'Content.Pages', 'refid' => $id]);
        //debug($sectionsModules);

        $availableModules = $this->Pages->ContentModules->Modules->find('list');

        $this->set('content', $content);
        $this->set('sections', $sections);
        $this->set('availableModules', $availableModules);

        $this->set('_serialize', ['content', 'sections', 'availableModules']);
    }

    /**
     * @return \Cake\Network\Response|null
     */
    public function add()
    {
//        $content = $this->Pages->newEntity();
//        if ($this->request->is('post')) {
//            $content = $this->Pages->patchEntity($content, $this->request->data);
//            if ($this->Pages->save($content)) {
//                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'content')));
//
//                return $this->redirect(['action' => 'edit', $content->id]);
//            } else {
//                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'content')));
//                debug($content->errors());
//            }
//        }

        $this->set('fields', [
            'parent_id' => ['input' => ['data-placeholder' => 'No parent']],
            'type' => ['input' => ['default' => 'content', 'empty' => false]]
        ]);

        $this->set('fields.whitelist', [
            'parent_id', 'type', 'title'
        ]);

        $pagesTree = $this->Pages->find('treeList')->toArray();
        $this->set('parents', $pagesTree);
        $this->set('types', $this->_getPageTypes());
//        $this->set(compact('content'));
//        $this->set('_serialize', ['content']);

        $this->Action->execute();
    }

    /**
     * @param null $id
     * @return \Cake\Network\Response|null
     * @deprecated Use ContentModulesController->linkModule() instead
     */
    public function linkModule($id = null)
    {
        $contentModule = $this->Pages->ContentModules->newEntity(
            ['refscope' => 'Content.Pages', 'refid' => $id],
            ['validate' => false]
        );
        if ($this->request->is(['post', 'put'])) {
            $this->Pages->ContentModules->patchEntity($contentModule, $this->request->data);
            if ($this->Pages->ContentModules->save($contentModule)) {
                $this->Flash->success(__d('content', 'The content module has been saved for Page {0}.', $id));
            } else {
                $this->Flash->error(__d('content', 'The content module could not be saved for Page {0}.', $id));
            }

            return $this->redirect(['action' => 'edit', $id]);
        }
    }

    /**
     * @param null $id
     * @return \Cake\Network\Response|null
     */
    public function edit($id = null)
    {
        $page = $this->Pages->get($id, [
            'contain' => ['PageLayouts', 'Posts']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $content = $this->Pages->patchEntity($page, $this->request->data);
            if ($this->Pages->save($content)) {
                $this->Flash->success(__d('content', 'The {0} has been saved.', __d('content', 'content')));

                return $this->redirect(['action' => 'edit', $page->id]);
            } else {
                $this->Flash->error(__d('content', 'The {0} could not be saved. Please, try again.', __d('content', 'content')));
            }
        }
        $pagesTree = $this->Pages->find('treeList')->toArray();
        $this->set('pagesTree', $pagesTree);

        $this->set('types', $this->_getPageTypes());
        $this->set('pageLayouts', ContentManager::getAvailablePageLayouts());
        $this->set('pageTemplates', ContentManager::getAvailablePageTemplates());

        $this->set('page', $page);
        $this->set('_serialize', 'page');
        $this->set('_entity', 'page');


        /*
        $this->Tabs->add(__d('content', 'Meta'), [
            'url' => ['action' => 'relatedPageMeta', $page->id]
        ]);

        $this->Tabs->add(__d('content', 'Related Modules'), [
            'url' => ['action' => 'relatedContentModules', $page->id]
        ]);

        $this->Tabs->add(__d('content', 'Debug'), ['debugOnly' => true]);
        debug($page);
        */

        /*
        $this->set('tabs', [
            'meta' => ['title' => __d('content', 'Meta'), 'url' => ['action' => 'relatedPageMeta', $page->id]],
            'related_content_modules' => ['title' => __d('content', 'Related Modules'), 'url' => ['action' => 'relatedContentModules', $page->id]],
        ]);
        */

        $this->Action->execute();
    }

    /**
     * @param null $id
     */
    public function preview($id = null)
    {
        $page = $this->Pages->get($id);
        $this->redirect($page->url);
    }

    /**
     * @deprecated Use ContentManager::getPageTypes() instead
     */
    protected function _getPageTypes()
    {
        $types = ContentManager::getAvailablePageTypes();
        $list = [];
        foreach ($types as $type => $config) {
            $list[$type] = $config['title'];
        }

        return $list;
    }
}
