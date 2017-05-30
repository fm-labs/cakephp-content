<?php

namespace Content\Controller\Admin;

use Backend\Controller\EntityInfoActionTrait;
use Banana\Controller\Shared\JsTreeAwareTrait;
use Banana\Controller\Shared\PrimaryModelAwareTrait;
use Cake\Network\Exception\NotFoundException;
use Content\Lib\ContentManager;
use Content\Model\Table\PagesTable;
use Cake\Event\Event;
use Cake\Network\Exception\BadRequestException;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
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

    use TreeSortControllerTrait;
    use PrimaryModelAwareTrait;
    use JsTreeAwareTrait;
    use EntityInfoActionTrait;

    public $modelClass = "Content.Pages";

    public $actions = [
        'index'     => 'Backend.TreeIndex',
        'view'      => 'Backend.View',
        'add'       => 'Backend.Add',
        'edit'      => 'Backend.Edit',
        'delete'    => 'Backend.Delete',
        'publish'   => 'Backend.Publish',
        'unpublish' => 'Backend.Unpublish',
        'moveUp'    => 'Backend.TreeMoveUp',
        'moveDown'  => 'Backend.TreeMoveDown',
    ];

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->components()->unload('RequestHandler');
    }

    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);


        $this->response->header("Access-Control-Allow-Headers", "Content-Type");
        $this->response->header("Access-Control-Allow-Origin", "*");
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

        $this->set('fields.whitelist', ['title', 'is_published']);
        $this->set('fields', [
            //'title' => ['formatter' => function($val, $row, $args, $view) {
            //    return $view->Html->link($val, ['action' => 'edit', $row->id]);
            //}]
        ]);

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

        $this->Backend->executeAction();
    }

    public function quick()
    {
        if ($this->request->is(['post','put'])) {
            $id = $this->request->data('page_id');
            if ($id) {
                $this->redirect(['action' => 'view', $id]);
                return;
            }
        }

        $this->Flash->error('Bad Request');
        $this->redirect($this->referer(['action' => 'index']));
    }

    public function indexJstree()
    {
    }

    public function view ($id = null)
    {
        $content = $this->Pages->get($id, [
            'contain' => ['ParentPages']
        ]);

        $this->set('content', $content);
        $this->set('_serialize', ['content']);
    }

    public function treeView()
    {
        $id = $this->request->query('id');
        $this->setAction('manage', $id);
    }

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

    public function add()
    {
        $content = $this->Pages->newEntity();
        if ($this->request->is('post')) {
            $content = $this->Pages->patchEntity($content, $this->request->data);
            if ($this->Pages->save($content)) {
                $this->Flash->success(__d('content','The {0} has been saved.', __d('content','content')));
                return $this->redirect(['action' => 'edit', $content->id]);
            } else {
                $this->Flash->error(__d('content','The {0} could not be saved. Please, try again.', __d('content','content')));
                debug($content->errors());
            }
        }

        $pagesTree = $this->Pages->find('treeList')->toArray();
        $this->set('pagesTree', $pagesTree);

        $this->set('types', $this->_getPageTypes());
        $this->set(compact('content'));
        $this->set('_serialize', ['content']);

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
                $this->Flash->success(__d('content','The content module has been saved for Page {0}.', $id));
            } else {
                $this->Flash->error(__d('content','The content module could not be saved for Page {0}.', $id));
            }
            return $this->redirect(['action' => 'edit', $id]);
        }
    }

    public function edit($id = null)
    {
        $page = $this->Pages->get($id, [
            'contain' => ['PageLayouts', 'Posts']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $content = $this->Pages->patchEntity($page, $this->request->data);
            if ($this->Pages->save($content)) {
                $this->Flash->success(__d('content','The {0} has been saved.', __d('content','content')));
                return $this->redirect(['action' => 'edit', $page->id]);
            } else {
                $this->Flash->error(__d('content','The {0} could not be saved. Please, try again.', __d('content','content')));
            }
        }
        $pagesTree = $this->Pages->find('treeList')->toArray();
        $this->set('pagesTree', $pagesTree);

        $this->set('types', ContentManager::getAvailablePageTypes());
        $this->set('pageLayouts', ContentManager::getAvailablePageLayouts());
        $this->set('pageTemplates', ContentManager::getAvailablePageTemplates());

        $this->set('page', $page);
        $this->set('_serialize', ['content']);
    }


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
        return ContentManager::getAvailablePageTypes();
    }

    public function moveUp($id = null) {
        $page = $this->Pages->get($id, ['contain' => []]);

        if ($this->Pages->moveUp($page)) {
            $this->Flash->success(__d('content','The {0} has been moved up.', __d('content','page')));
        } else {
            $this->Flash->error(__d('content','The {0} could not be moved. Please, try again.', __d('content','page')));
        }
        $this->redirect($this->referer(['action' => 'index']));
    }

    public function moveDown($id = null) {
        $page = $this->Pages->get($id, ['contain' => []]);

        if ($this->Pages->moveDown($page)) {
            $this->Flash->success(__d('content','The {0} has been moved down.', __d('content','page')));
        } else {
            $this->Flash->error(__d('content','The {0} could not be moved. Please, try again.', __d('content','page')));
        }
        $this->redirect($this->referer(['action' => 'index']));
    }

    public function repair()
    {
        $this->Pages->recover();
        $this->Flash->success(__d('content','Shop Category tree recovery has been executed'));
        $this->redirect($this->referer(['action' => 'index']));
    }


    /**
     * @legacy
     * @deprecated
     */
    public function treeDataOld()
    {
        //$this->autoRender = false;
        $this->viewBuilder()->className('Json');

        //$treeList = $this->Pages->find('treeList')->toArray();
        //debug($treeList);


        $nodes = $this->Pages
            ->find('threaded')
            //->select(['id', 'parent_id', 'lft', 'rght', 'level', 'title'])
            //->orderAsc('lft')
            //->hydrate(false)
            ->all()
            ->toArray();

        /*
         * // Expected format of the node (there are no required fields)
{
  id          : "string" // will be autogenerated if omitted
  text        : "string" // node text
  icon        : "string" // string for custom
  state       : {
    opened    : boolean  // is the node open
    disabled  : boolean  // is the node disabled
    selected  : boolean  // is the node selected
  },
  children    : []  // array of strings or objects
  li_attr     : {}  // attributes for the generated LI node
  a_attr      : {}  // attributes for the generated A node
}
         */

        $id = 1;


        $nodeFormatter = function(PageInterface $node) use (&$id) {

            $publishedClass = ($node->isPagePublished()) ? 'published' : 'unpublished';
            $class = $node->getPageType();
            $class.= " " . $publishedClass;

            return [
                'id' => $id++,
                'text' => $node->getPageTitle(),
                'icon' => $class,
                'state' => [
                    'opened' => false,
                    'disabled' => false,
                    'selected' => false,
                ],
                'children' => [],
                'li_attr' => ['class' => $class],
                'a_attr' => [],
                'data' => [
                    'type' => $node->getPageType(),
                    'viewUrl' => Router::url($node->getPageAdminUrl()),
                ]
            ];
        };

        $nodesFormatter = function($nodes) use ($nodeFormatter, &$nodesFormatter) {
            $formatted = [];
            foreach ($nodes as $node) {
                $_node = $nodeFormatter($node);
                if ($node->getPageChildren()) {
                    $_node['children'] = $nodesFormatter($node->getPageChildren());
                }
                $formatted[] = $_node;
            }
            return $formatted;
        };

        /*
        $jsTree = [
            'id' => null,
            'text' => 'All Sites',
            'icon' => 'super',
            'state' => [
                'opened' => true,
                'disabled' => false,
                'selected' => true,
            ],
            'children' => $nodesFormatter($nodes),
            'li_attr' => [],
            'a_attr' => []
        ];
        */

        $jsTree = $nodesFormatter($nodes);

        //debug($jsTree);
        //debug($nodes);

        $this->set('jsTree', $jsTree);
        $this->set('_serialize', 'jsTree');

    }




    /**
     * @legacy
     * @deprecated
     */
    public function treeDataVeryOld()
    {
        $this->viewBuilder()->className('Json');

        $id = $this->request->query('id');
        if ($id) {

            $id = explode(':', $id);
            switch (count($id)) {
                case 1:
                    $type = 'content';
                    $id = $id[0];
                    break;
                case 2:
                    $type = $id[0];
                    $id = $id[1];
                    break;
                default:
                    throw new BadRequestException('Invalid tree data request');
            }


        }
        //$conditions = ($id == '#') ? ['parent_id IS NULL'] : ['parent_id' => $id];

        if (!$id || $id == '#') {
            $nodes = $this->Pages
                ->find()
                ->where(['parent_id IS NULL'])
                ->orderAsc('lft')
                ->all()
                ->toArray();
        } else {

            $page = $this->Pages->get($id);
            $nodes = $page->getChildren()->all()->toArray();
            //$nodes = $this->Pages->find('children', ['for' => $id]);
            /*
            $nodes = $this->Pages
                ->find()
                ->where(['parent_id' => $id])
                ->orderAsc('lft')
                ->all()
                ->toArray();
            */
            //debug($nodes);
        }

        //debug($pages);
        $treeData = [];
        array_walk($nodes, function ($node) use (&$treeData, &$id) {
            $publishedClass = ($node->is_published) ? 'published' : 'unpublished';
            $treeData[] = [
                'id' => $node->type . ':' . $node->id,
                'text' => $node->getPageTitle(),
                'children' => true,
                'icon' => $node->type . " " . $publishedClass,
                'parent' => ($node->parent_id) ?: '#',
                'data' => [
                    'type' => $node->type,
                    'adminUrl' => Router::url($node->getPageAdminUrl()),
                    'treeUrl' => null
                ]
            ];
        });

        $this->set('treeData', $treeData);
        $this->set('_serialize', 'treeData');
    }


}
