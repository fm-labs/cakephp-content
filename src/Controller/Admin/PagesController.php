<?php
namespace Content\Controller\Admin;

class PagesController extends ArticlesController
{
    protected $articleType = 'page';

    public $modelClass = "Content.Articles";

    public function initialize(): void
    {
        parent::initialize();

        $this->viewBuilder()->setTemplatePath('Admin/Articles');
    }
}
