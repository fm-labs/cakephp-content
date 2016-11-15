<?php

namespace Content\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;

/**
 * Class FrontendController
 * @package Content\Controller
 * @deprecated Use FrontendComponent instead
 */
abstract class FrontendController extends Controller
{
    public function initialize()
    {
        $this->loadComponent('Content.Frontend');
    }
} 