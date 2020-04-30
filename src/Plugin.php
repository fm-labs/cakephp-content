<?php
declare(strict_types=1);

namespace Content;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Seo\Sitemap\Sitemap;
use Settings\SettingsManager;

/**
 * Class Plugin
 * @package Content
 */
class Plugin extends BasePlugin implements EventListenerInterface
{
    /**
     * {@inheritDoc}
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        parent::bootstrap($app);

        $eventManager = EventManager::instance();
        $eventManager->on($this);

        if (\Cake\Core\Plugin::isLoaded('Seo')) {
            Sitemap::setConfig('content', [
                'className' => 'Content.Sitemap',
            ]);
        }

        //if (\Cake\Core\Plugin::isLoaded('Cupcake')) {
        //    \Cupcake\Cupcake::register($this);
        //}
    }

    /**
     * {@inheritDoc}
     */
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

    /**
     * @param RouteBuilder $routes
     * @return RouteBuilder
     */
    public function adminRoutes(RouteBuilder $routes): RouteBuilder
    {
        $routes->connect('/', ['controller' => 'Pages', 'action' => 'index'], ['_name' => 'index']);

        $routeClass = DashedRoute::class;
        $routes->connect('/{controller}', ['action' => 'index'], compact('routeClass'));
        $routes->connect('/{controller}/{action}/*', [], compact('routeClass'));
        $routes->connect('/{controller}/{action}', [], compact('routeClass'));

        return $routes;
    }

    /**
     * {@inheritDoc}
     */
    public function implementedEvents(): array
    {
        return [
            'Settings.build' => 'buildSettings',
            'Admin.Menu.build.admin_primary' => ['callable' => 'buildAdminMenu', 'priority' => 5 ],
            'Admin.Menu.build.admin_system' => ['callable' => 'buildAdminSystemMenu', 'priority' => 5 ],
            'Controller.initialize' => function (Event $event) {
                if ($event->getSubject() instanceof \App\Controller\AppController) {
                    $event->getSubject()->loadComponent('Content.Frontend');
                }
            },
        ];
    }

    /**
     * @return array|array[]
     */
    protected function _getDesignMenuItems(): array
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

    /**
     * @return array|array[]
     */
    protected function _getMenuItems(): array
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
     * @param \Cake\Event\Event $event
     * @param \Settings\SettingsManager $settings
     * @return void
     */
    public function buildSettings(Event $event, SettingsManager $settings): void
    {
        $settings->add('Content', [
            'Content.Router.enablePrettyUrls' => [
                'type' => 'boolean',
                'help' => 'Enables SEO-friendly URIs',
            ],
            'Content.Router.forceCanonical' => [
                'type' => 'boolean',
                'help' => 'Force redirect to canonical URI',
            ],
        ]);
    }

    /**
     * @param Event $event
     * @param \Cupcake\Menu\Menu $menu
     * @return void
     */
    public function buildAdminMenu(Event $event, \Cupcake\Menu\Menu $menu): void
    {
        $menu->addItem([
            'title' => 'Content',
            'url' => ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index'],
            'data-icon' => 'book',
            'children' => $this->_getMenuItems(),
        ]);
    }

    /**
     * @param Event $event
     * @param \Cupcake\Menu\Menu $menu
     * @return void
     */
    public function buildAdminSystemMenu(Event $event, \Cupcake\Menu\Menu $menu): void
    {
        $menu->addItem([
            'title' => 'Content',
            'url' => ['plugin' => 'Content', 'controller' => 'Info', 'action' => 'index'],
            'data-icon' => 'info',
            'children' => [],
        ]);
    }
}
