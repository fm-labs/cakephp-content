<?php

namespace Content\Controller\Admin;

use Backend\Controller\BackendActionsTrait;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Content\Lib\ContentManager;
use Media\Lib\Media\MediaManager;

/**
 * Class AppController
 *
 * @package Content\Controller\Admin
 */
class AppController extends Controller
{
    use BackendActionsTrait;

    /**
     * @var array
     */
    public $actions = [
        'index'     => 'Backend.Index',
        'view'      => 'Backend.View',
        'add'       => 'Backend.Add',
        'edit'      => 'Backend.Edit',
        'delete'    => 'Backend.Delete',
        //'publish'   => 'Backend.Publish',
        //'unpublish' => 'Backend.Unpublish'
    ];

    /**
     * @var array
     */
    public $paginate = [
        'limit' => 100,
    ];

    /**
     * Initialize
     */
    public function initialize()
    {
        $this->loadComponent('Backend.Backend');
    }

    /**
     * @param Event $event
     * @return \Cake\Network\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        $locale = $this->request->query('locale');
        $this->locale = ($locale) ? $locale : Configure::read('Shop.defaultLocale');
    }

    /**
     * @param Event $event
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        $this->set('locale', $this->locale);

        //@TODO Move to a CORSComponent
        $this->response->header("Access-Control-Allow-Headers", "DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Authorization");
        $this->response->header("Access-Control-Allow-Origin", "*");
        $this->response->header("Access-Control-Allow-Credentials", "true");
    }

    /**
     * @deprecated
     */
    protected function _getGalleryList()
    {
        $list = [];
        $mm = MediaManager::get('shop');
        $list = $mm->getSelectListRecursive();
        return $list;
    }

    /**
     * @deprecated
     */
    protected function getModulesAvailable()
    {
        return ContentManager::getModuleCellsAvailable();
    }

    /**
     * @deprecated
     */
    protected function getModuleTemplatesAvailable()
    {
        return ContentManager::getModuleCellTemplatesAvailable();
    }

    /**
     * @deprecated
     */
    protected function getLayoutsAvailable()
    {
        return ContentManager::getLayoutsAvailable();
    }

    /**
     * @deprecated
     */
    protected function getThemesAvailable()
    {
        return ContentManager::getLayoutsAvailable();
    }
}
