<?php
namespace Content\Page;

use Cake\Controller\Controller;

class StaticPageType extends AbstractPageType
{
    public function execute(Controller &$controller)
    {
        $action = ($this->page->page_template) ?: null;
        if ($action !== 'view' && $action && method_exists($this, $action)) {
            $controller->setAction($action);
            return false;
        }
    }
}