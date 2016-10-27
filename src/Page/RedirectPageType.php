<?php
namespace Content\Page;

use Cake\Routing\Router;

class RedirectPageType extends AbstractPageType
{
    public function getUrl()
    {
        $url = $this->page->redirect_location;
        return Router::url($url, true);
    }
}