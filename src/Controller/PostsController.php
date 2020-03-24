<?php
namespace Content\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Exception\NotFoundException;

/**
 * Posts Controller
 *
 * @property \Content\Model\Table\ArticlesTable $Articles
 * @property \Content\Controller\Component\FrontendComponent $Frontend
 */
class PostsController extends AppController
{
    /**
     * @var string
     */
    public $modelClass = "Content.Articles";

    /**
     * @param Event $event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['index', 'view']);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $articles = $this->Articles->find()
            ->find('published')
            ->where(['Articles.type' => 'post'])
            ->orderDesc('id');

        $articles = $this->paginate($articles);

        $this->set('articles', $articles);
    }

    /**
     * @param null $id
     * @throws \Exception
     */
    public function view($id = null)
    {
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

        try {
            /** @var \Content\Model\Entity\Article $article */
            $article = $this->Articles->get($id, [
                'media' => true,
                'attributes' => true
            ]);

            if (!$article->isPublished()) {
                if ($this->Frontend->isPreviewMode()) {
                    $this->Flash->success("Preview mode");
                } else {
                    throw new NotFoundException();
                }
            }
        } catch (\Exception $ex) {
            //throw new NotFoundException();
            throw $ex;
        }

        if (!$this->request->is('requested')) {
            // force canonical url (except root pages)
            /*
            if (Configure::read('Content.Router.forceCanonical') && !$this->_root) {
                $here = Router::normalize($this->request->here);
                $canonical = Router::normalize($article->getViewUrl());

                if ($here != $canonical) {
                    $this->redirect($canonical, 301);

                    return;
                }
            }
            */

            $this->Frontend->setRefScope('Content.Articles');
            $this->Frontend->setRefId($id);
        }

        $this->set('article', $article);
        $this->set('_serialize', ['article']);

        //$template = ($article->template) ?: ((!$article->parent_id) ? $article->type . '_parent' : $article->type);
        $template = ($article->template) ?: $article->type;
        $template = ($this->request->getQuery('template')) ?: $template;
        $template = ($template) ?: null;

        $this->viewBuilder()
            ->setClassName('Content.Article')
            //->setTemplatePath(ucfirst(Inflector::camelize($this->getName())) . '/' . ucfirst(Inflector::camelize($article->type)))
            ->setTemplate($template);

        //$this->render($template);
    }

}
