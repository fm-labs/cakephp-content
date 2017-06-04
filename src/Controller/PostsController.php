<?php
namespace Content\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Routing\Router;

/**
 * Posts Controller
 *
 * @property \Content\Model\Table\PostsTable $Posts
 */
class PostsController extends ContentController
{
    /**
     * @var string
     */
    public $viewClass = 'Content.Post';

    /**
     * @var string
     */
    public $modelClass = "Content.Posts";

    /**
     * @param Event $event
     * @return \Cake\Network\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['index', 'view', 'teaser', 'sitemap']);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $homePost = $this->Posts->findHome($this->Site->getSiteId());
        if (!$homePost) {
            throw new NotFoundException(__d('content',"Start page not found for site ID " . $this->Site->getSiteId()));
        }
        $this->setAction('view', $homePost->id);
    }

    /**
     * @param null $id
     * @throws \Exception
     */
    public function view($id = null)
    {
        if ($id === null) {
            switch (true) {
                case $this->request->query('post_id'):
                    $id = $this->request->query('post_id');
                    break;
                case $this->request->param('post_id'):
                    $id = $this->request->param('post_id');
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

        try {

            $post = $this->Posts->get($id, [
                'media' => true,
            ]);

            if (!$post->isPublished()) {
                throw new NotFoundException("Post not published");
            }
        } catch (\Exception $ex) {
            //throw new NotFoundException();
            throw $ex;
        }

        if (!$this->request->is('requested')) {
            // force canonical url (except root pages)
            if (Configure::read('Content.Router.forceCanonical') && !$this->_root) {
                $here = Router::normalize($this->request->here);
                $canonical = Router::normalize($post->getViewUrl());

                if ($here != $canonical) {
                    $this->redirect($canonical, 301);
                    return;
                }
            }

            $this->Frontend->setRefScope('Content.Posts');
            $this->Frontend->setRefId($id);
        }

        $this->set('post', $post);
        $this->set('_serialize', ['post']);


        $this->viewBuilder()->className('Content.Post');

        //$template = ($post->template) ?: ((!$post->parent_id) ? $post->type . '_parent' : $post->type);
        $template = ($post->template) ?: $post->type;
        $template = ($this->request->query('template')) ?: $template;
        $template = ($template) ?: null;

        $this->render($template);
    }

    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     * @deprecated
     */
    public function teaser($id = null)
    {
        $this->viewBuilder()->className('Content.Post');

        //if ($id === null && $this->request->query('post_id')) {
        //    $id = $this->request->query('post_id');
        //}

        $post = $this->Posts->get($id, [
            'contain' => [],
            'media' => true
        ]);

        $this->set('post', $post);
        $this->set('_serialize', ['post']);

        $template = ($post->teaser_template) ?: $post->type;
        $template = ($this->request->query('template')) ?: $template;
        $template = ($template) ?: null;

        $this->render($template);
    }

    /**
     * @deprecated Use EventListener instead
     */
    public function sitemap()
    {
        $this->loadComponent('Sitemap.Sitemap');
        $this->Sitemap->createSitemap();
        foreach ($this->Posts->find('list') as $id => $row) {
            $this->Sitemap->addUrl(['action' => 'view', $id]);
        }
        $this->Sitemap->render();
    }
}
