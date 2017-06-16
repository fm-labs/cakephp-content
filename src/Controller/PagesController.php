<?php
namespace Content\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Routing\Router;
use Content\Controller\Component\FrontendComponent;
use Content\Controller\Traits\PagesDisplayActionTrait;
use Content\Model\Table\PagesTable;

/**
 * Class FrontendController
 * @package App\Controller
 *
 * @property FrontendComponent $Frontend
 * @property PagesTable $Pages
 * @todo Use FrontendController instead
 */
class PagesController extends ContentController
{
    use PagesDisplayActionTrait;

    /**
     * @var string
     */
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

    /**
     * Initialize method
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('RequestHandler');
    }

    /**
     * @param Event $event
     * @return \Cake\Network\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow();
    }

    /**
     * @param Event $event
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
    }

    /**
     * Index method
     */
    public function index()
    {
        $rootPage = $this->Pages->findHostRoot();
        if (!$rootPage) {
            throw new NotFoundException(__d('content', "Root page not found"));
        }

        $this->setAction('view', $rootPage->id);
    }

    /**
     * @param null $slug
     */
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
            throw new NotFoundException(__d('content', "Page not found"));
        }

        // force canonical url (except root pages)
        if (Configure::read('Content.Router.forceCanonical') && !$this->_root) {
            debug("blaa");
            $here = Router::normalize($this->request->here);
            $canonical = Router::normalize($page->url);

            if ($here != $canonical) {
                $this->redirect($canonical, 301);

                return;
            }
        }

        $this->Frontend->setRefId($page->id);

        $this->viewBuilder()->className('Content.Page');

        //@todo Dispatch Page.beforeExecute()
        // Execute page
        $handler = $this->Pages->getTypeHandler($page);
        $response = $handler->execute($this, $page);
        if ($response) {
            return $response;
        }
        //@todo Dispatch Page.afterExecute();
    }
}
