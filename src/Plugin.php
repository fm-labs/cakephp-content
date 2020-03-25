<?php

namespace Content;

use Banana\Plugin\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\PluginApplicationInterface;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Cake\Routing\RouteBuilder;
use Settings\SettingsManager;

class Plugin extends BasePlugin implements EventListenerInterface
{

    public function bootstrap(PluginApplicationInterface $app): void
    {
        parent::bootstrap($app);

        $eventManager = EventManager::instance();
        $eventManager->on($this);
        $eventManager->on(new \Content\Sitemap\SitemapListener());
    }

    public function routes(\Cake\Routing\RouteBuilder $routes): void
    {
        parent::routes($routes);
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
//        // Articles with '/post' prefix
//        $routes->connect('/post/:slug/:post_id/*',
//            ['plugin' => 'Content',  'controller' => 'Articles', 'action' => 'view'],
//            ['post_id' => '\d+', 'pass' => ['post_id'], '_name' => 'post']
//        );
//
//        $routes->connect('/post/:post_id',
//            ['plugin' => 'Content', 'controller' => 'Articles', 'action' => 'view'],
//            ['post_id' => '\d+', 'pass' => ['post_id']]
//        );
//
//        $routes->connect('/post/:slug',
//            ['plugin' => 'Content', 'controller' => 'Articles', 'action' => 'view'],
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

    public function backendRoutes(RouteBuilder $routes)
    {
        $routes->connect('/', ['controller' => 'Pages', 'action' => 'index'], ['_name' => 'index']);
        $routes->fallbacks('DashedRoute');

        return $routes;
    }

    /**
     * Returns a list of events this object is implementing. When the class is registered
     * in an event manager, each individual method will be associated with the respective event.
     *
     * @see EventListenerInterface::implementedEvents()
     * @return array associative array or event key names pointing to the function
     * that should be called in the object when the respective event is fired
     */
    public function implementedEvents(): array
    {
        return [
            'Settings.build' => 'buildSettings',
            'Backend.Menu.build.admin_primary' => ['callable' => 'buildBackendMenu', 'priority' => 5 ],
            'Backend.Menu.build.admin_system' => ['callable' => 'buildBackendSystemMenu', 'priority' => 5 ],
        ];
    }

    protected function _getDesignMenuItems()
    {
        return [
            'page_layouts' => [
                'title' => 'Layouts',
                'url' => ['plugin' => 'Content', 'controller' => 'PageLayouts', 'action' => 'index'],
                'data-icon' => 'columns',
            ],
            'modules' => [
                'title' => 'Modules',
                'url' => ['plugin' => 'Content', 'controller' => 'Modules', 'action' => 'index'],
                'data-icon' => 'puzzle-piece',
            ],
            'content_modules' => [
                'title' => 'Content Modules',
                'url' => ['plugin' => 'Content', 'controller' => 'ContentModules', 'action' => 'index'],
                'data-icon' => 'object-group',
            ],
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
                'data-icon' => 'file-o',
            ],

            'posts' => [
                'title' => 'Articles',
                'url' => ['plugin' => 'Content', 'controller' => 'Articles', 'action' => 'index'],
                'data-icon' => 'file-o',
            ],
            'menus' => [
                'title' => 'Menus',
                'url' => ['plugin' => 'Content', 'controller' => 'Menus', 'action' => 'index'],
                'data-icon' => 'sitemap',
            ],

            'galleries' => [
                'title' => 'Galleries',
                'url' => ['plugin' => 'Content', 'controller' => 'Galleries', 'action' => 'index'],
                'data-icon' => 'image',
            ],


        ];
    }

    /**
     * @param Event $event
     */
    public function buildSettings(Event $event, SettingsManager $settings)
    {
        $settings->add('Content', [
            'Content.Router.enablePrettyUrls' => [
                'type' => 'boolean',
                'help' => 'Enables SEO-friendly URIs'
            ],
            'Content.Router.forceCanonical' => [
                'type' => 'boolean',
                'help' => 'Force redirect to canonical URI'
            ],
        ]);
    }

    public function buildBackendMenu(Event $event, \Banana\Menu\Menu $menu)
    {
        $menu->addItem([
            'title' => 'Content',
            'url' => ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index'],
            'data-icon' => 'book',
            'children' => $this->_getMenuItems(),
        ]);
    }


    public function buildBackendSystemMenu(Event $event, \Banana\Menu\Menu $menu)
    {
        $menu->addItem([
            'title' => 'Content',
            'url' => ['plugin' => 'Content', 'controller' => 'Info', 'action' => 'index'],
            'data-icon' => 'info',
            'children' => [],
        ]);
    }
}
