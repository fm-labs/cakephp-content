<?php

namespace Content\Controller;

use Banana\Controller\Component\SiteComponent;
use Cake\Controller\Component\RequestHandlerComponent;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Content\Controller\Component\FrontendComponent;

/**
 * Class FrontendController
 * @package Content\Controller
 *
 * @property RequestHandlerComponent $RequestHandler
 * @property SiteComponent $Site
 * @property FrontendComponent $Frontend
 */
class FrontendController extends AppController
{

    /**
     * Indicates root page
     * @var bool
     */
    //protected $_root = false;

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Banana.Site');
        $this->loadComponent('Content.Frontend');
        $this->loadComponent('RequestHandler');
        //$this->loadComponent('Paginator');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->viewBuilder()->plugin('Content');
    }

    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
    }


} 