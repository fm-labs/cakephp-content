<?php

namespace Content\Controller\Component;

use Cake\Controller\Controller;
use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Content\Model\Entity\Page;
use Content\Model\Table\PagesTable;

/**
 * Class FrontendComponent
 *
 * @package Content\Controller\Component
 */
class FrontendComponent extends Component
{
    /**
     * @var Controller
     */
    public $controller;

    /**
     * @var PagesTable
     */
    public $Pages;

    /**
     * @var array
     */
    protected $_defaultConfig = [
        'viewClass' => 'Content.Content',
        'refscope' => 'Content.Pages',
        'theme' => null,
        'layout' => null
    ];

    /**
     * @param array $config
     */
    public function initialize(array $config)
    {
        $this->controller = $this->_registry->getController();

        $layout = ($this->_config['layout']) ?: 'frontend';
        $theme = ($this->_config['theme']) ?: Configure::read('Site.theme');
        $viewClass = $this->_config['viewClass'];

        // check if theme plugin is loaded
        if ($theme && !Plugin::isLoaded($theme)) {
            debug("Warning: Configured site theme '$theme' is not loaded. Is the plugin loaded?");
            $theme = null;
        }

        $this->controller->loadComponent('Flash');
        $this->controller->viewBuilder()->setClassName($viewClass);
        $this->controller->viewBuilder()->setLayout($layout);
        $this->controller->viewBuilder()->setTheme($theme);

        $this->setRefScope($this->_config['refscope']);
    }

    public function beforeRender(Event $event)
    {
    }

    /**
     * @param $scope
     */
    public function setRefScope($scope)
    {
        $this->controller->set('refscope', $scope);
    }

    /**
     * @param $id
     */
    public function setRefId($id)
    {
        $this->controller->set('refid', $id);
    }

    /**
     * @param $pageId
     * @deprecated
     */
    public function setPageId($pageId)
    {
        $this->controller->set('page_id', $pageId);
        $this->setRefScope('Content.Pages');
        $this->setRefId($pageId);
    }

    /**
     * @return mixed
     */
    public function getTheme()
    {
        return $this->_config['theme'];
    }
}
