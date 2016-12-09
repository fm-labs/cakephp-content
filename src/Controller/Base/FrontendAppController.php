<?php

namespace Content\Controller\Base;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Class FrontendAppController
 *
 * The applications AppController should extend this base class.
 *
 * @package Content\Controller\Base
 */
class FrontendAppController extends Controller
{
    public function initialize()
    {
        $this->loadComponent('Banana.Site');
        $this->loadComponent('Content.Frontend');
        $this->loadComponent('User.Auth', [
            'logoutRedirect' => '/'
        ]);
    }

    /*
    public function beforeFilter(Event $event)
    {
        //$this->viewBuilder()->plugin('Content');
    }
    */
}
