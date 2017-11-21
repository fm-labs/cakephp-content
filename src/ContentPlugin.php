<?php

namespace Content;

use Backend\Event\RouteBuilderEvent;
use Banana\Plugin\PluginInterface;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Cake\Routing\Router;
use Content\Lib\ContentManager;
use Settings\SettingsManager;

class ContentPlugin implements PluginInterface, EventListenerInterface
{

    /**
     * @param EventManager $eventManager
     * @return $this
     */
    public function registerEvents(EventManager $eventManager)
    {
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
            'Content.Model.PageTypes.get' => 'getContentPageTypes',
            'Settings.build' => 'buildSettings',
            'Backend.Menu.get' => ['callable' => 'getBackendMenu', 'priority' => 5 ],
            'Backend.Routes.build' => 'buildBackendRoutes'
        ];
    }

    public function getContentPageTypes(Event $event)
    {
        $event->result['content'] = [
            'title' => 'Content Page',
            'className' => 'Content.Content'
        ];
        $event->result['static'] = [
            'title' => 'Static Page',
            'className' => 'Content.Static'
        ];
        $event->result['controller'] = [
            'title' => 'Controller',
            'className' => 'Content.Controller'
        ];
        $event->result['redirect'] = [
            'title' => 'Redirect',
            'className' => 'Content.Redirect'
        ];
        $event->result['root'] = [
            'title' => 'Root Page',
            'className' => 'Content.Root'
        ];
    }

    /**
     * @param Event $event
     */
    public function buildSettings(Event $event)
    {
        if ($event->subject() instanceof SettingsManager) {
            $event->subject()->add('Content', [
                'Router.enablePrettyUrls' => [
                    'type' => 'boolean',
                ],
                'Router.forceCanonical' => [
                    'type' => 'boolean',
                ],
            ]);
        }
    }

    public function buildBackendRoutes(RouteBuilderEvent $event)
    {
        Router::scope('/content/admin', ['plugin' => 'Content', '_namePrefix' => 'content:admin:', 'prefix' => 'admin'], function ($routes) {
            $routes->extensions(['json']);
            $routes->connect('/', ['controller' => 'Pages', 'action' => 'index'], ['_name' => 'index']);
            $routes->fallbacks('DashedRoute');
        });
    }

    public function getBackendMenu(Event $event)
    {
        $event->subject()->addItem([
            'title' => 'Content',
            'url' => ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index'],
            'data-icon' => 'book',
            'children' => [

                /*
                'categories' => [
                    'title' => 'Categories',
                    'url' => ['plugin' => 'Content', 'controller' => 'Categories', 'action' => 'index'],
                    'data-icon' => 'folder-o',
                ],
                */

                'pages' => [
                    'title' => 'Pages',
                    'url' => ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index'],
                    'data-icon' => 'sitemap',
                ],

                'posts' => [
                    'title' => 'Posts',
                    'url' => ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'index'],
                    'data-icon' => 'file-o',
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
                'modules' => [
                    'title' => 'Modules',
                    'url' => ['plugin' => 'Content', 'controller' => 'Modules', 'action' => 'index'],
                    'data-icon' => 'puzzle-piece'
                ],
                'content_modules' => [
                    'title' => 'Content Modules',
                    'url' => ['plugin' => 'Content', 'controller' => 'ContentModules', 'action' => 'index'],
                    'data-icon' => 'object-group'
                ]
            ],
        ]);
    }

    /**
     * @param array $config
     * @return void
     */
    public function __invoke(array $config = [])
    {
        //@todo Let the application know that we support sitemaps via the Sitemap plugin
        \Cake\Event\EventManager::instance()->on(new \Content\Sitemap\SitemapListener());

        new ContentManager();
    }
}
