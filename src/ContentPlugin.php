<?php

namespace Content;

use Backend\Backend;
use Backend\BackendPluginInterface;
use Backend\Event\RouteBuilderEvent;
use Backend\View\BackendView;
use Banana\Application;
use Banana\Menu\Menu;
use Banana\Plugin\PluginInterface;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Content\Lib\ContentManager;
use Settings\SettingsInterface;
use Settings\SettingsManager;

class ContentPlugin implements PluginInterface, BackendPluginInterface, SettingsInterface, EventListenerInterface
{
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
            //'Content.Model.PageTypes.get' => 'getContentPageTypes', //@deprecated
            'Backend.Menu.build' => ['callable' => 'buildBackendMenu', 'priority' => 5 ],
            'Backend.Sidebar.build' => ['callable' => 'buildBackendMenu', 'priority' => 5 ],
            //'Backend.SysMenu.build' => ['callable' => 'buildBackendSidebarMenu', 'priority' => 50 ],
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

    protected function _getDesignMenuItems()
    {
        return [
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
        ];
    }

    protected function _getMenuItems()
    {
        return [

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

        ];
    }

    /**
     * @param Event $event
     */
    public function buildSettings(SettingsManager $settings)
    {
        $settings->add('Content', [
            'Router.enablePrettyUrls' => [
                'type' => 'boolean',
            ],
            'Router.forceCanonical' => [
                'type' => 'boolean',
            ],
        ]);
    }

    public function buildBackendRoutes(RouteBuilderEvent $event)
    {
        $event->subject()->scope(
            '/content',
            ['plugin' => 'Content', '_namePrefix' => 'content:admin:', 'prefix' => 'admin'],
            function (RouteBuilder $routes) {
                $routes->connect('/', ['controller' => 'Pages', 'action' => 'index'], ['_name' => 'index']);
                $routes->fallbacks('DashedRoute');
            }
        );
    }

    public function buildBackendMenu(Event $event)
    {
        $event->subject()->addItem([
            'title' => 'Content',
            'url' => ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index'],
            'data-icon' => 'book',
            'children' => $this->_getMenuItems()
        ]);
    }

    public function buildBackendSidebarMenu(Event $event)
    {
//        $event->subject()->addItem([
//            'title' => 'Design',
//            'url' => ['plugin' => 'Content', 'controller' => 'Themes', 'action' => 'index'],
//            'data-icon' => 'paint-brush',
//            'children' => [
//            ],
//        ]);
    }

    public function bootstrap(Application $app)
    {
        $eventManager = EventManager::instance();

        $eventManager->on(new \Content\Sitemap\SitemapListener());
        $eventManager->on($this);
    }

    public function routes(RouteBuilder $routes)
    {
//        $routes->connect('/', ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index']);
//
//        // Page by slug and pageId
//        if (Configure::read('Content.Router.enablePrettyUrls')) {
//            $routes->connect('/:slug/:page_id/*',
//                ['plugin' => 'Content',  'controller' => 'Pages', 'action' => 'view'],
//                ['page_id' => '\d+', 'pass' => ['page_id'], '_name' => 'page']
//            );
//
//            // Page by pageId
//            $routes->connect('/:page_id',
//                ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
//                ['page_id' => '\d+', 'pass' => ['page_id']]
//            );
//        }
//
//        // Pages with '/page' prefix (@deprecated)
//        $routes->connect('/page/:slug/:page_id/*',
//            ['plugin' => 'Content',  'controller' => 'Pages', 'action' => 'view'],
//            ['page_id' => '\d+', 'pass' => ['page_id']]
//        );
//
//        $routes->connect('/page/:page_id',
//            ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
//            ['page_id' => '\d+', 'pass' => ['page_id']]
//        );
//
//        $routes->connect('/page/:slug',
//            ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
//            ['pass' => []]
//        );
//
//        // Posts with '/post' prefix
//        $routes->connect('/post/:slug/:post_id/*',
//            ['plugin' => 'Content',  'controller' => 'Posts', 'action' => 'view'],
//            ['post_id' => '\d+', 'pass' => ['post_id'], '_name' => 'post']
//        );
//
//        $routes->connect('/post/:post_id',
//            ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'view'],
//            ['post_id' => '\d+', 'pass' => ['post_id']]
//        );
//
//        $routes->connect('/post/:slug',
//            ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'view'],
//            ['pass' => [], '_name' => 'postslug']
//        );
//
//
//        // Page by slug
//        $routes->connect('/:slug',
//            ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
//            ['pass' => []]
//        );
//
//        $routes->fallbacks('DashedRoute');
    }

    public function middleware(MiddlewareQueue $middleware)
    {
    }

    public function backendBootstrap(Backend $backend)
    {
    }

    public function backendRoutes(RouteBuilder $routes)
    {
        $routes->connect('/', ['controller' => 'Pages', 'action' => 'index'], ['_name' => 'index']);
        $routes->fallbacks('DashedRoute');
    }

    /**
     * @param array $config
     * @return void
     */
    public function __invoke(array $config = [])
    {
    }
}
