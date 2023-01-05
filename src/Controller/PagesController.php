<?php
declare(strict_types=1);

namespace Content\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cupcake\Cupcake;

/**
 * Class FrontendController
 *
 * @package App\Controller
 * @property \Content\Controller\Component\FrontendComponent $Frontend
 * @property \Content\Model\Table\PagesTable $Pages
 */
class PagesController extends AppController
{
    /**
     * @var string
     */
    public $modelClass = 'Content.Pages';

    /**
     * @var string[]
     */
    public $allowedActions = ['index', 'view'];

    /**
     * @inheritDoc
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->viewBuilder()->setClassName('Content.Page');
        $this->Frontend->setRefScope('Content.Pages');
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
    {
        throw new NotFoundException(__d('content', "Index page not found"));
    }

    /**
     * @param int|null $id Page ID
     * @return \Cake\Http\Response|void
     * @throws \Exception
     */
    public function view($id = null)
    {
        try {
            if ($id === null) {
                switch (true) {
                    case $this->request->getQuery('id'):
                        $id = $this->request->getQuery('id');
                        break;
                    case $this->request->getParam('id'):
                        $id = $this->request->getParam('id');
                        break;
                    case $this->request->getQuery('slug'):
                        $id = $this->Pages->findIdBySlug($this->request->getQuery('slug'));
                        break;
                    case $this->request->getParam('slug'):
                        $id = $this->Pages->findIdBySlug($this->request->getParam('slug'));
                        break;
                    default:
                        //throw new NotFoundException();
                }
            }

            $page = $this->Pages
                ->find()
                ->find('published')
                //->find('withAttributes')
                ->where(['Pages.id' => (int)$id, 'Pages.type' => 'page'])
                ->contain([])
                ->first();

            if (!$page) {
                throw new NotFoundException(__d('content', "Page not found"));
            }

            $filtered = Cupcake::doFilter('content_page_view_filter', ['page' => $page]);
            $page = $filtered['page'];

            if (!$page->isPublished()) {
                if ($this->Frontend->isPreviewMode()) {
                    $this->Flash->success("Preview mode");
                } else {
                    throw new ForbiddenException();
                }
            }

            if ($page->isProtected()) {
                if (!$this->Authentication->getIdentity()) {
                    throw new ForbiddenException();
                }
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
        } catch (\Cake\Http\Exception\NotFoundException $ex) {
            $this->render('404');
        } catch (\Exception $ex) {
            throw $ex;
        }
    }


    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function display()
    {
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }
}
