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
            'logoutRedirect' => '/',
        ]);
        $this->loadComponent('Content.Frontend');
        $this->loadComponent('Content.Locale');
    }

    /**
     * @param Event $event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        $this->Auth->setConfig('authorize', 'Controller');
        parent::beforeFilter($event);
    }

    /**
     * @param null $user
     * @return bool
     */
    public function isAuthorized($user = null)
    {
        // Any registered user can access public functions
        if (empty($this->request->getParam('prefix'))) {
            return true;
        }

        // Default deny
        return false;
    }
}
