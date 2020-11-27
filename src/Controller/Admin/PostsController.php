<?php
declare(strict_types=1);

namespace Content\Controller\Admin;

class PostsController extends PagesController
{
    protected $pageType = 'post';

    public $modelClass = "Content.Pages";

    public function initialize(): void
    {
        parent::initialize();

        $this->viewBuilder()->setTemplatePath('Admin/Pages');
    }
}
