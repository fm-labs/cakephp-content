<?php
declare(strict_types=1);

namespace Content\Controller;

use Cake\Http\Exception\NotFoundException;

/**
 * Class FrontendController
 * @package App\Controller
 *
 * @property \Content\Controller\Component\FrontendComponent $Frontend
 * @property \Content\Model\Table\ArticlesTable $Pages
 */
class PagesController extends AppController
{
    /**
     * @var string
     */
    public $modelClass = 'Content.Articles';

    /**
     * @var string[]
     */
    public $allowedActions = ['index', 'view'];

    /**
     * {@inheritDoc}
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->viewBuilder()->setClassName('Content.Article');
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
     * @param int|null $id Article ID
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
                        $id = $this->Articles->findIdBySlug($this->request->getQuery('slug'));
                        break;
                    case $this->request->getParam('slug'):
                        $id = $this->Articles->findIdBySlug($this->request->getParam('slug'));
                        break;
                    default:
                        //throw new NotFoundException();
                }
            }

            $article = $this->Articles
                //->find('published')
                ->find()
                ->where(['Articles.id' => $id, 'Articles.type' => 'page'])
                ->contain([])
                ->first();

            if (!$article) {
                throw new NotFoundException(__d('content', "Page not found"));
            }

            if (!$article->isPublished()) {
                if ($this->Frontend->isPreviewMode()) {
                    $this->Flash->success("Preview mode");
                } else {
                    throw new NotFoundException();
                }
            }

            /*
            // force canonical url (except root articles)
            if (Configure::read('Content.Router.forceCanonical') && !$this->_root) {
                $here = Router::normalize($this->request->here);
                $canonical = Router::normalize($article->getUrl());

                if ($here != $canonical) {
                    $this->redirect($canonical, 301);

                    return;
                }
            }

            $this->Frontend->setRefId($article->id);

            //@todo Dispatch Page.beforeExecute()
            // Execute article
            $handler = $this->Pages->getTypeHandler($article);
            $response = $handler->execute($this, $article);
            if ($response) {
                return $response;
            }
            */

            $this->set('article', $article);
            //@todo Dispatch Page.afterExecute();
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
