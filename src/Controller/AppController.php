<?php
declare(strict_types=1);

namespace Content\Controller;

use App\Controller\AppController as BaseAppController;

/**
 * Class AppController
 *
 * @package Content\Controller
 */
abstract class AppController extends BaseAppController
{
    /**
     * Initialize method
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('User.Auth', [
            'logoutRedirect' => '/',
        ]);
        $this->loadComponent('Content.Frontend');
        $this->loadComponent('Content.Locale');
    }

    /**
     * @param \Cake\Event\Event $event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
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
