<?php

namespace Content;


use Banana\Plugin\PluginInterface;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;

class ContentPlugin implements PluginInterface, EventListenerInterface
{

    /**
     * @param EventManager $eventManager
     * @return $this
     */
    public function registerEvents(EventManager $eventManager)
    {
        $eventManager->on(new \Content\Sitemap\PagesSitemapProvider());
        $eventManager->on(new \Content\Sitemap\PostsSitemapProvider());
    }

    /**
     * Returns a list of events this object is implementing. When the class is registered
     * in an event manager, each individual method will be associated with the respective event.
     *
     * @see EventListenerInterface::implementedEvents()
     * @return array associative array or event key names pointing to the function
     * that should be called in the object when the respective event is fired
     */
    public function implementedEvents()
    {
        return [
            'Backend.Menu.get' => 'getBackendMenu'
        ];
    }

    public function getBackendMenu(Event $event)
    {
        $event->subject()->addItem([
            'title' => 'Content',
            'url' => ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index'],
            'data-icon' => 'book',
            'children' => [

                'categories' => [
                    'title' => 'Categories',
                    'url' => ['plugin' => 'Content', 'controller' => 'Categories', 'action' => 'index'],
                    'data-icon' => 'folder-o',
                ],

                'posts' => [
                    'title' => 'Posts',
                    'url' => ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'index'],
                    'data-icon' => 'file-o',
                ],

                'pages' => [
                    'title' => 'Pages',
                    'url' => ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index'],
                    'data-icon' => 'sitemap',
                ],
                'galleries' => [
                    'title' => 'Galleries',
                    'url' => ['plugin' => 'Content', 'controller' => 'Galleries', 'action' => 'index'],
                    'data-icon' => 'image'
                ],

                'page_layouts' => [
                    'title' => 'Layouts',
                    'url' => ['plugin' => 'Content', 'controller' => 'PageLayouts', 'action' => 'index'],
                    'data-icon' => 'columns'
                ],
                'module_builder' => [
                    'title' => 'Module Builder',
                    'url' => ['plugin' => 'Content', 'controller' => 'ModuleBuilder', 'action' => 'index'],
                    'data-icon' => 'magic'
                ],
                'modules' => [
                    'title' => 'Modules',
                    'url' => ['plugin' => 'Content', 'controller' => 'Modules', 'action' => 'index'],
                    'data-icon' => 'puzzle-piece'
                ],
                'content_modules' => [
                    'title' => 'Content Modules',
                    'url' => ['plugin' => 'Content', 'controller' => 'ContentModules', 'action' => 'index'],
                    'data-icon' => 'object-group'
                ],

                /*
                'pages_legacy' => [
                    'title' => 'Pages (Legacy)',
                    'url' => ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index'],
                    'data-icon' => 'sitemap'
                ],
                */
            ],
        ]);
    }

    /**
     * @param array $config
     * @return void
     */
    public function __invoke(array $config = [])
    {
        // TODO: Implement __invoke() method.
    }
}