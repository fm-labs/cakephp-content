<?php
declare(strict_types=1);

namespace Content\Controller;

use App\Controller\AppController as BaseAppController;

/**
 * Class AppController
 *
 * @package Content\Controller
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 */
abstract class AppController extends BaseAppController
{
    /**
     * @throws \Exception
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadComponent('Content.Frontend');
        $this->loadComponent('Content.Locale');
    }
}
