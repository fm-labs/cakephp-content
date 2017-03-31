<?php

namespace Content\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Class AppController
 *
 * @package Content\Controller
 */
class ContentController extends AppController
{
    public function initialize()
    {
        $this->loadComponent('User.Auth', [
            'logoutRedirect' => '/'
        ]);
        $this->loadComponent('Banana.Site');
        $this->loadComponent('Content.Frontend');
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->config('authorize', 'Controller');
        parent::beforeFilter($event);
    }

    public function isAuthorized($user = null)
    {
        // Any registered user can access public functions
        if (empty($this->request->params['prefix'])) {
            return true;
        }

        // Default deny
        return false;
    }
}
