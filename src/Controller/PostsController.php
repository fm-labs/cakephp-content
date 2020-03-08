<?php
namespace Content\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Exception\NotFoundException;
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
     * @return \Cake\Http\Response|null|void
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
        $posts = $this->Posts->find()
            ->find('published')
            ->where(['Posts.type' => 'post'])
            ->orderDesc('id');

        $posts = $this->paginate($posts);

        $this->set('posts', $posts);
    }

    /**
     * @param null $id
     * @throws \Exception
     */
    public function view($id = null)
    {
        if ($id === null) {
            switch (true) {
                case $this->request->getQuery('post_id'):
                    $id = $this->request->getQuery('post_id');
                    break;
                case $this->request->getParam('post_id'):
                    $id = $this->request->getParam('post_id');
                    break;
                case $this->request->getQuery('slug'):
                    $id = $this->Posts->findIdBySlug($this->request->getQuery('slug'));
                    break;
                case $this->request->getParam('slug'):
                    $id = $this->Posts->findIdBySlug($this->request->getParam('slug'));
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

        $this->viewBuilder()->setClassName('Content.Post');

        //$template = ($post->template) ?: ((!$post->parent_id) ? $post->type . '_parent' : $post->type);
        $template = ($post->template) ?: $post->type;
        $template = ($this->request->getQuery('template')) ?: $template;
        $template = ($template) ?: null;

        $this->render($template);
    }

    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return void
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     * @deprecated
     */
    public function teaser($id = null)
    {
        $this->viewBuilder()->setClassName('Content.Post');

        //if ($id === null && $this->request->getQuery('post_id')) {
        //    $id = $this->request->getQuery('post_id');
        //}

        $post = $this->Posts->get($id, [
            'contain' => [],
            'media' => true,
        ]);

        $this->set('post', $post);
        $this->set('_serialize', ['post']);

        $template = ($post->teaser_template) ?: $post->type;
        $template = ($this->request->getQuery('template')) ?: $template;
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
