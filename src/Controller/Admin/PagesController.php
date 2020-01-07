<?php
namespace Content\Controller\Admin;

class PagesController extends PostsController
{
    protected $postType = 'page';

    public $modelClass = "Content.Posts";

    public function initialize()
    {
        parent::initialize();

        $this->viewBuilder()->templatePath('Admin/Posts');
    }
}
