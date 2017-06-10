<?php
namespace Content\Page;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;

class RootPageType extends AbstractPageType
{
    public function getUrl()
    {
        return '/';
    }

    public function execute(Controller &$controller)
    {
        $controller->setAction('view', $this->page->redirect_page_id);

        return false;
    }
}
