<?php
namespace Content\Page;

use Cake\Controller\Controller;
use Cake\Routing\Router;

class RedirectPageType extends AbstractPageType
{
    public function getUrl()
    {
        $url = $this->page->redirect_location;
        return Router::url($url, true);
    }

    public function execute(Controller &$controller)
    {
        if ($this->page->redirect_page_id) {
            $page = $this->Pages->get($this->page->redirect_page_id, ['contain' => []]);
            $redirectUrl = $page->url;
        } else {
            $redirectUrl = $this->page->redirect_location;
        }

        $controller->redirect($redirectUrl, $this->page->redirect_status);
        return false;
    }
}