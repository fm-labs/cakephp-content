<?php
namespace Content\Controller;

use Content\Controller\AppController;

/**
 * Posts Controller
 *
 * @property \Content\Model\Table\PostsTable $Posts
 */
class PostsController extends FrontendController
{

    public $modelClass = "Content.Posts";

    public function initialize()
    {
        $this->loadComponent('Content.Frontend');
        $this->loadComponent('Paginator');
        $this->loadComponent('RequestHandler');
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate['contain'] = ['ContentModules' => ['Modules']];
        $this->paginate['order'] = ['Posts.id' => 'DESC'];
        $this->set('posts', $this->paginate($this->Posts));
        $this->set('_serialize', ['posts']);
    }

    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     * @deprecated
     */
    public function view1($id = null)
    {
        $this->viewBuilder()->className('Content.Post');

        if ($id === null && $this->request->query('post_id')) {
            $id = $this->request->query('post_id');
        }
        $post = $this->Posts->get($id, [
            'media' => true,
        ]);

        $this->set('post', $post);
        $this->set('_serialize', ['post']);

        $view = ($post->template) ?: null;

        $this->render($view);
    }

    public function view($id = null)
    {
        $this->viewBuilder()->className('Content.Post');

        if ($id === null && $this->request->query('post_id')) {
            $id = $this->request->query('post_id');
        }
        $post = $this->Posts->get($id, [
            'media' => true,
        ]);

        $template = ($post->template) ?: $post->type;
        if ($template == 'page') {
            $template = 'view';
        }

        if (!$this->request->is('requested')) {
            $this->Frontend->setRefScope('Content.Posts');
            $this->Frontend->setRefId($id);
        }

        $this->set('post', $post);
        $this->set('_serialize', ['post']);
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

        if ($id === null && $this->request->query('post_id')) {
            $id = $this->request->query('post_id');
        }
        $post = $this->Posts->get($id, [
            'contain' => [],
            'media' => true,
        ]);

        $this->set('post', $post);
        $this->set('_serialize', ['post']);

        $view = ($post->teaser_template) ?: null;

        $this->render($view);
    }

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
