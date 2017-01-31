<?php

namespace Content\Controller;

use App\Controller\AppController as BaseAppController;
use Cake\Event\Event;

/**
 * Class AppController
 * @package Content\Controller
 */
class AppController extends BaseAppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        if ($this->components()->has('Auth')) {
            $this->Auth->config('authorize', 'Controller');
        }
    }

    public function isAuthorized($user = null)
    {
        // Any registered user can access public functions
        if (empty($this->request->params['prefix'])) {
            return true;
        }

        // Only admins can access admin functions
        if ($this->request->params['prefix'] === 'admin') {
            return (bool)($user['superuser'] === true);
        }

        // Default deny
        return false;
    }
}
