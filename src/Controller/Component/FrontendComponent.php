<?php

namespace Content\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
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
        'layout' => null,
    ];

    /**
     * @param array $config
     */
    public function initialize(array $config): void
    {
        $layout = ($this->_config['layout']) ?: Configure::read('Site.layout');
        $theme = ($this->_config['theme']) ?: Configure::read('Site.theme');
        $viewClass = $this->_config['viewClass'];

        // check if theme plugin is loaded
        if ($theme && !Plugin::isLoaded($theme)) {
            debug("Warning: Configured site theme '$theme' is not loaded. Is the plugin loaded?");
            $theme = null;
        }

        $this->getController()->loadComponent('Flash');
        $this->getController()->viewBuilder()->setClassName($viewClass);
        $this->getController()->viewBuilder()->setLayout($layout);
        $this->getController()->viewBuilder()->setTheme($theme);

        $this->setRefScope($this->_config['refscope']);
    }

    public function beforeRender(\Cake\Event\EventInterface $event)
    {
    }

    /**
     * @param $scope
     */
    public function setRefScope($scope)
    {
        $this->getController()->set('refscope', $scope);
    }

    /**
     * @param $id
     */
    public function setRefId($id)
    {
        $this->getController()->set('refid', $id);
    }

    /**
     * @param $pageId
     * @deprecated
     */
    public function setPageId($pageId)
    {
        $this->getController()->set('page_id', $pageId);
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

    /**
     * Checks if the request has a valid preview key
     *
     * @return bool
     */
    public function isPreviewMode()
    {
        $previewKeyInSession = $this->getController()->getRequest()->getSession()->read('Content.previewKey');
        $previewKeyInRequest = $this->getController()->getRequest()->getQuery('preview');

        if (!$previewKeyInRequest || !$previewKeyInSession) {
            return false;
        }

        return ($previewKeyInRequest === $previewKeyInSession);
    }
}
