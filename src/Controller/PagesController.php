<?php

namespace Content\Controller;

use Cake\Core\Exception\Exception;
use Cake\Event\Event;
use Cake\Network\Exception\BadRequestException;
use Cake\Network\Exception\NotFoundException;
use Content\Controller\Traits\PagesDisplayActionTrait;
use Content\Model\Table\PagesTable;
use Cake\Core\Configure;
use Cake\Network\Response;
use Cake\Routing\Router;
use Cake\View\Exception\MissingTemplateException;
use Content\Controller\Component\FrontendComponent;

/**
 * Class FrontendController
 * @package App\Controller
 *
 * @property FrontendComponent $Frontend
 * @property PagesTable $Pages
 * @deprecated Use FrontendController instead
 */
class PagesController extends ContentController
{
    use PagesDisplayActionTrait;

    public $modelClass = 'Content.Pages';

    /**
     * @var string
     * @deprecated
     */
    public $viewClass = 'Content.Page';

    /**
     * Indicates root page
     * @var bool
     */
    protected $_root = false;

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('RequestHandler');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow();
    }

    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
    }

    public function index()
    {
        $rootPage = $this->Pages->findHostRoot();
        if (!$rootPage) {
            throw new NotFoundException(__d('content',"Root page not found"));
        }

        $this->setAction('view', $rootPage->id);
    }

    public function viewSlug($slug = null)
    {
        $page = $this->Pages->findBySlug($slug);
        $this->setAction('view', $page->id);
    }

    /**
     * @param null $id
     * @return \Cake\Network\Response|void
     *
     * @deprecated Use 'display' method instead
     */
    public function view($id = null)
    {
        Configure::write('debug', false);
        if ($id === null) {
            switch (true) {
                case $this->request->query('page_id'):
                    $id = $this->request->query('page_id');
                    break;
                case $this->request->param('page_id'):
                    $id = $this->request->param('page_id');
                    break;
                case $this->request->query('slug'):
                    $id = $this->Pages->findIdBySlug($this->request->query('slug'));
                    break;
                case $this->request->param('slug'):
                    $id = $this->Pages->findIdBySlug($this->request->param('slug'));
                    break;
                default:
                    //throw new NotFoundException();
            }
        }

        $page = $this->Pages
            ->find('published')
            ->where(['Pages.id' => $id])
            ->contain(['PageLayouts'])
            ->first();


        if (!$page) {
            throw new NotFoundException(__d('content',"Page not found"));
        }


        // force canonical url (except root pages)
        if (Configure::read('Content.Router.forceCanonical') && !$this->_root) {
            $here = Router::normalize($this->request->here);
            $canonical = Router::normalize($page->url);

            if ($here != $canonical) {
                $this->redirect($canonical, 301);
                return;
            }
        }


        //$this->request->params['page_id'] = $page->id;
        //$this->Frontend->setPageId($page->id);
        $this->Frontend->setRefId($page->id);

        //@todo Dispatch Page.beforeExecute()

        // Execute page
        if ($page->execute($this) === false) {
            return;
        }
        //@todo Dispatch Page.afterExecute();

        $this->viewBuilder()->className('Content.Page');

        $view = ($page->page_template) ?: $page->type;
        $view = ($this->request->query('view')) ?: $view;
        $this->viewBuilder()->template($view);

        $layout = ($page->page_layout) ? $page->page_layout->template : null;
        $this->viewBuilder()->layout($layout);

        $this->set('page', $page);
    }


}
