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
 */
class PagesController extends ContentController
{
    use PagesDisplayActionTrait;

    /**
     * @var string
     */
    public $modelClass = 'Content.Posts';

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
        $this->loadComponent('Content.Frontend');

        $this->Frontend->setRefScope('Content.Pages');

        //$this->viewBuilder()->className('Content.Page');
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
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $rootPage = null;
        if (!$rootPage) {
            throw new NotFoundException(__d('content', "Root page not found"));
        }

        $this->setAction('view', $rootPage->id);
    }

    /**
     * @param null $id
     * @return \Cake\Network\Response|void
     * @throws \Exception
     * @deprecated Use 'display' method instead
     */
    public function view($id = null)
    {
        try {
            if ($id === null) {
                switch (true) {
                    case $this->request->query('page_id'):
                        $id = $this->request->query('page_id');
                        break;
                    case $this->request->param('page_id'):
                        $id = $this->request->param('page_id');
                        break;
                    case $this->request->query('slug'):
                        $id = $this->Posts->findIdBySlug($this->request->query('slug'));
                        break;
                    case $this->request->param('slug'):
                        $id = $this->Posts->findIdBySlug($this->request->param('slug'));
                        break;
                    default:
                        //throw new NotFoundException();
                }
            }

            $page = $this->Posts
                ->find('published')
                ->where(['Posts.id' => $id, 'Posts.type' => 'page'])
                ->contain([])
                ->first();

            if (!$page) {
                throw new NotFoundException(__d('content', "Page not found"));
            }

            /*
            // force canonical url (except root pages)
            if (Configure::read('Content.Router.forceCanonical') && !$this->_root) {
                $here = Router::normalize($this->request->here);
                $canonical = Router::normalize($page->getUrl());

                if ($here != $canonical) {
                    $this->redirect($canonical, 301);

                    return;
                }
            }

            $this->Frontend->setRefId($page->id);

            //@todo Dispatch Page.beforeExecute()
            // Execute page
            $handler = $this->Pages->getTypeHandler($page);
            $response = $handler->execute($this, $page);
            if ($response) {
                return $response;
            }
            */

            $this->set('page', $page);
            //@todo Dispatch Page.afterExecute();
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
