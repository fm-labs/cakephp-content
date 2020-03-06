<?php
namespace Content\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Exception\NotFoundException;
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
class OldPagesController extends ContentController
{
    use PagesDisplayActionTrait;

    /**
     * @var string
     */
    public $modelClass = 'Content.OldPages';

    /**
     * @var string
     * @deprecated
     */
    public $viewClass = 'Content.OldPage';

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
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow();
    }

    /**
     * Index method
     */
    public function index()
    {
        $rootPage = $this->OldPages->findHostRoot();
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
        $page = $this->OldPages->findBySlug($slug);
        $this->setAction('view', $page->id);
    }

    /**
     * @param null $id
     * @return \Cake\Http\Response|void
     * @throws \Exception
     * @deprecated Use 'display' method instead
     */
    public function view($id = null)
    {
        try {
            if ($id === null) {
                switch (true) {
                    case $this->request->getQuery('page_id'):
                        $id = $this->request->getQuery('page_id');
                        break;
                    case $this->request->param('page_id'):
                        $id = $this->request->param('page_id');
                        break;
                    case $this->request->getQuery('slug'):
                        $id = $this->OldPages->findIdBySlug($this->request->getQuery('slug'));
                        break;
                    case $this->request->param('slug'):
                        $id = $this->OldPages->findIdBySlug($this->request->param('slug'));
                        break;
                    default:
                        //throw new NotFoundException();
                }
            }

            $page = $this->OldPages
                ->find('published')
                ->where(['Pages.id' => $id])
                ->contain(['PageLayouts'])
                ->first();

            if (!$page) {
                throw new NotFoundException(__d('content', "Page not found"));
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

            $this->Frontend->setRefId($page->id);

            $this->viewBuilder()->setClassName('Content.Page');

            //@todo Dispatch Page.beforeExecute()
            // Execute page
            $handler = $this->OldPages->getTypeHandler($page);
            $response = $handler->execute($this, $page);
            if ($response) {
                return $response;
            }
            //@todo Dispatch Page.afterExecute();
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
