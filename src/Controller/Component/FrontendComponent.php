<?php

namespace Content\Controller\Component;

use Cake\Controller\Controller;
use Cake\Controller\Component;
use Cake\Core\Configure;
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

        if (is_null($this->_config['theme'])) {
            $this->_config['theme'] = Configure::read('Site.theme');
        }

        if (is_null($this->_config['layout'])) {
            $this->_config['layout'] = 'frontend';
        }

        $this->controller->loadComponent('Flash');
        $this->controller->viewBuilder()->className($this->_config['viewClass']);
        $this->controller->viewBuilder()->theme($this->_config['theme']);
        $this->controller->viewBuilder()->layout($this->_config['layout']);

        $this->setRefScope($this->_config['refscope']);
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
