<?php
namespace Content\Controller;

use App\Controller\AppController as BaseAppController;
use Cake\Event\Event;

/**
 * Class AppController
 *
 * @package Content\Controller
 */
abstract class ContentController extends BaseAppController
{
    /**
     * Initialize method
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('User.Auth', [
            'logoutRedirect' => '/'
        ]);
        $this->loadComponent('Content.Frontend');
    }

    /**
     * @param Event $event
     * @return \Cake\Network\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        $this->Auth->config('authorize', 'Controller');
        parent::beforeFilter($event);
    }

    /**
     * @param null $user
     * @return bool
     */
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
