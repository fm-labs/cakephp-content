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
     * @var string[]
     */
    public $allowedActions = ['index', 'view'];

    /**
     * {@inheritDoc}
     * @throws \Exception
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadComponent('Content.Frontend');
        $this->loadComponent('Content.Locale');

        if ($this->Authentication && !empty($this->allowedActions)) {
            $this->Authentication->allowUnauthenticated($this->allowedActions);
        }
    }
}
