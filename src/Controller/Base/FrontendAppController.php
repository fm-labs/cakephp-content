<?php

namespace Content\Controller\Base;

use Banana\Controller\Component\SiteComponent;
use Cake\Controller\Controller;
use Content\Controller\Component\FrontendComponent;

/**
 * Class FrontendAppController
 *
 * The application's AppController should extend this base class.
 *
 * @package Content\Controller\Base
 * @property SiteComponent $Site
 * @property FrontendComponent $Frontend
 */
class FrontendAppController extends Controller
{
    public function initialize()
    {
        $this->loadComponent('User.Auth', [
            'logoutRedirect' => '/'
        ]);
        $this->loadComponent('Banana.Site');
        $this->loadComponent('Content.Frontend');
    }

    /*
    public function beforeFilter(Event $event)
    {
        //$this->viewBuilder()->plugin('Content');
    }
    */
}
