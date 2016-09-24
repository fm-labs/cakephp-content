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
     */
    public function view($id = null)
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

    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
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
