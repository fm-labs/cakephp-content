<?php

namespace Content\Controller\Admin;


class PagesController extends PostsController
{
    public $modelClass = "Content.Posts";


    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

        $scope = ['Posts.type' => 'page', 'Posts.parent_id IS' => null];
        $order = ['Posts.title' => 'ASC'];

        $q = $this->request->query('q');
        if ($q) {
            $scope['Posts.title LIKE'] = '%' . $q . '%';
        }

        $this->paginate = [
            'contain' => [],
            'order' => $order,
            'limit' => 200,
            'maxLimit' => 200,
            'conditions' => $scope,
            //'media' => true,
        ];
        $posts = $this->paginate($this->Posts);

        // if in search mode and there is only a single result
        // go straight to the result item edit
        if ($q && count($posts) == 1) {
            $this->Flash->info('Redirected from search for \'' . $q . '\'');
            $this->redirect(['action' => 'edit', $posts->first()->id ]);
        }

        $this->set('postsList', $this->Posts->find('list')->where($scope)->order($order));

        $this->set('posts', $posts);
        $this->set('_serialize', ['posts']);
    }

}