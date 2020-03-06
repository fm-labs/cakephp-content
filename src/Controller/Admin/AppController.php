<?php

namespace Content\Controller\Admin;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Content\Lib\ContentManager;
use Media\Lib\Media\MediaManager;

/**
 * Class AppController
 *
 * @package Content\Controller\Admin
 */
class AppController extends \Backend\Controller\Controller
{
    /**
     * @var array
     */
    public $actions = [
        'index' => 'Backend.Index',
        'view' => 'Backend.View',
        'add' => 'Backend.Add',
        'edit' => 'Backend.Edit',
        'delete' => 'Backend.Delete',
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
     * @param Event $event The controller event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        //@TODO Move shop language selection to a component
        $locale = $this->request->getQuery('locale');
        $this->locale = ($locale) ? $locale : Configure::read('Shop.defaultLocale');
    }

    /**
     * @param Event $event The controller event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        $this->set('locale', $this->locale);
    }

    /**
     * @return array
     * @deprecated
     */
    protected function _getGalleryList()
    {
        $list = [];

        if (Plugin::isLoaded('Media')) {
            $mm = MediaManager::get('shop');
            $list = $mm->getSelectListRecursive();
        }

        return $list;
    }

    /**
     * @return array
     * @deprecated
     */
    protected function getModulesAvailable()
    {
        return ContentManager::getModuleCellsAvailable();
    }

    /**
     * @return array
     * @deprecated
     */
    protected function getModuleTemplatesAvailable()
    {
        return ContentManager::getModuleCellTemplatesAvailable();
    }

    /**
     * @return array
     * @deprecated
     */
    protected function getLayoutsAvailable()
    {
        return ContentManager::getLayoutsAvailable();
    }

    /**
     * @return array
     * @deprecated
     */
    protected function getThemesAvailable()
    {
        return ContentManager::getLayoutsAvailable();
    }
}
