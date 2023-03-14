<?php
declare(strict_types=1);

namespace Content\Controller\Admin;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Content\ContentManager;
use Media\MediaManager;

/**
 * Class AppController
 *
 * @package Content\Controller\Admin
 */
class AppController extends \Admin\Controller\Controller
{
    /**
     * @var array
     */
    public $actions = [
        'index' => 'Admin.Index',
        'view' => 'Admin.View',
        'add' => 'Admin.Add',
        'edit' => 'Admin.Edit',
        'delete' => 'Admin.Delete',
        //'publish'   => 'Admin.Publish',
        //'unpublish' => 'Admin.Unpublish'
    ];

    /**
     * @var array
     */
    public $paginate = [
        'limit' => 100,
    ];

    /**
     * @param \Cake\Event\Event $event The controller event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        //@TODO Move shop language selection to a component
        $locale = $this->request->getQuery('locale');
        $this->locale = $locale ? $locale : Configure::read('Shop.defaultLocale');
    }

    /**
     * @param \Cake\Event\Event $event The controller event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(\Cake\Event\EventInterface $event)
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
