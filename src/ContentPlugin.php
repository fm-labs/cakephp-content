<?php
declare(strict_types=1);

namespace Content;

use Cake\Cache\Cache;
use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\PluginApplicationInterface;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Content\Model\Entity\Menu\ControllerMenuType;
use Content\Model\Entity\Menu\LinkMenuType;
use Content\Model\Entity\Menu\PageMenuType;
use Content\Model\Entity\Menu\RootMenuType;
use Cupcake\Cupcake;
use Cupcake\Model\EntityTypeRegistry;

/**
 * Class Plugin
 *
 * @package Content
 */
class ContentPlugin extends BasePlugin implements EventListenerInterface
{
    /**
     * @inheritDoc
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        parent::bootstrap($app);

        $app->addOptionalPlugin('Seo');
        $app->addOptionalPlugin('Settings');

        /**
         * Setup cache
         */
        if (!Cache::getConfig('content_menu')) {
            Cache::setConfig('content_menu', [
                'className' => 'File',
                'duration' => '+1 day',
                'path' => CACHE,
                'prefix' => 'content_menu_',
            ]);
        }

        /**
         * Register entity types
         */
        //EntityTypeRegistry::registerNs('Content.Model.Entity.Page');
        EntityTypeRegistry::register('Content.Page', 'post', [
            'label' => 'Post',
            'className' => 'Content.Post',
        ]);

        EntityTypeRegistry::register('Content.Page', 'page', [
            'label' => 'Page',
            'className' => 'Content.Page',
        ]);

        EntityTypeRegistry::register('Content.Page', 'default', [
            'label' => 'Page',
            'className' => 'Content.Page',
        ]);

        //EntityTypeRegistry::registerNs('Content.Menu');
        EntityTypeRegistry::registerMultiple('Content.Menu', [
            'root' => [
                'label' => __d('content', 'Root'),
                'className' => RootMenuType::class,
            ],
            'page' => [
                'label' => __d('content', 'Page'),
                'className' => PageMenuType::class,
            ],
            'controller' => [
                'label' => __d('content', 'Custom Controller'),
                'className' => ControllerMenuType::class,
            ],
            'link' => [
                'label' => __d('content', 'Custom Link'),
                'className' => LinkMenuType::class,
            ],
        ]);

        /**
         * Menus
         */
        //MenuManager::setConfig('__main__', ['className' => '']);

        /**
         * Shortcodes
         */
        \Cupcake\Cupcake::addFilter('content_shortcodes_init', function ($shortcodes) {
            $shortcodes['echo'] = [
                'name' => 'Echo',
                'className' => 'Content.Echo',
            ];
            $shortcodes['test'] = [
                'name' => 'Test',
                'className' => 'Content.Test',
            ];
            $shortcodes['mathjax'] = [
                'name' => 'MathJax',
                'className' => 'Content.Mathjax',
            ];
            $shortcodes['mathjax_block'] = [
                'name' => 'MathJax Block',
                'className' => 'Content.Mathjax',
            ];

            return $shortcodes;
        });

        /**
         * Load default content config
         */
        Configure::load('Content.content');

        if (\Cake\Core\Plugin::isLoaded('Settings')) {
            Configure::load('Content', 'settings');
        }

        /**
         * Seo plugin
         */
        if (\Cake\Core\Plugin::isLoaded('Seo')) {
            \Seo\Sitemap\Sitemap::setConfig('content', [
                'className' => 'Content.Sitemap',
            ]);
        }
//        Cupcake::addFilter('seo_sitemap_init', function ($name, $data, $options) {
//            $data['content'] = [
//                'name' => 'Content Sitemap',
//                'className' => 'Content.Sitemap',
//            ];
//
//            return $data;
//        });

        /**
         * Admin plugin
         */
        if (\Cake\Core\Plugin::isLoaded('Admin')) {
            \Admin\Admin::addPlugin(new \Content\ContentAdmin());
        }
        Cupcake::addFilter('admin_init', function ($name, $data) {
            $data['content'] = [
                'name' => 'Content Plugin Administration',
                'className' => \Content\ContentAdmin::class,
            ];

            return $data;
        });

        $eventManager = EventManager::instance();
        $eventManager->on($this);
    }

    /**
     * @inheritDoc
     */
    public function routes(\Cake\Routing\RouteBuilder $routes): void
    {
        $routes->plugin('Content', [], function ($routes) {
            $routes->connect('/', ['controller' => 'Content', 'action' => 'index']);
            $routes->fallbacks('DashedRoute');
        });

        // Page by slug and pageId
        /*
        if (Configure::read('Content.Router.enablePrettyUrls')) {
            $routes->connect(
                '/{slug}/{page_id}/*',
                ['plugin' => 'Content',  'controller' => 'Pages', 'action' => 'view'],
                ['page_id' => '\d+', 'pass' => ['page_id'], '_name' => 'page']
            );

            // Page by pageId
            $routes->connect(
                '/{page_id}',
                ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
                ['page_id' => '\d+', 'pass' => ['page_id']]
            );
        }
        */

        // Pages with '/page' prefix
        $routes->connect(
            '/page/{slug}/{id}/*',
            ['plugin' => 'Content',  'controller' => 'Pages', 'action' => 'view'],
            ['id' => '\d+', 'pass' => ['id']]
        );

        $routes->connect(
            '/page/{id}',
            ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
            ['id' => '\d+', 'pass' => ['id']]
        );

        $routes->connect(
            '/page/{slug}',
            ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
            ['pass' => []]
        );

        // Posts with '/post' prefix
        /*
        $routes->connect(
            '/post/{slug}/{post_id}/*',
            ['plugin' => 'Content',  'controller' => 'Posts', 'action' => 'view'],
            ['post_id' => '\d+', 'pass' => ['post_id'], '_name' => 'post']
        );

        $routes->connect(
            '/post/{post_id}',
            ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'view'],
            ['post_id' => '\d+', 'pass' => ['post_id']]
        );

        $routes->connect(
            '/post/{slug}',
            ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'view'],
            ['pass' => [], '_name' => 'postslug']
        );
        */

        // Page by slug
        /*
        $routes->connect('/{slug}',
            ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
            ['pass' => []]
        );
        */

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//        $routes->connect('/', ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index']);
//
//        // Page by slug and pageId
//        if (Configure::read('Content.Router.enablePrettyUrls')) {
//            $routes->connect('/{slug}/{page_id}/*',
//                ['plugin' => 'Content',  'controller' => 'Pages', 'action' => 'view'],
//                ['page_id' => '\d+', 'pass' => ['page_id'], '_name' => 'page']
//            );
//
//            // Page by pageId
//            $routes->connect('/{page_id}',
//                ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
//                ['page_id' => '\d+', 'pass' => ['page_id']]
//            );
//        }
//
//        // Pages with '/page' prefix (@deprecated)
//        $routes->connect('/page/{slug}/{page_id}/*',
//            ['plugin' => 'Content',  'controller' => 'Pages', 'action' => 'view'],
//            ['page_id' => '\d+', 'pass' => ['page_id']]
//        );
//
//        $routes->connect('/page/{page_id}',
//            ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
//            ['page_id' => '\d+', 'pass' => ['page_id']]
//        );
//
//        $routes->connect('/page/{slug}',
//            ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
//            ['pass' => []]
//        );
//
//        // Pages with '/post' prefix
//        $routes->connect('/post/{slug}/{post_id}/*',
//            ['plugin' => 'Content',  'controller' => 'Pages', 'action' => 'view'],
//            ['post_id' => '\d+', 'pass' => ['post_id'], '_name' => 'post']
//        );
//
//        $routes->connect('/post/{post_id}',
//            ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
//            ['post_id' => '\d+', 'pass' => ['post_id']]
//        );
//
//        $routes->connect('/post/{slug}',
//            ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
//            ['pass' => [], '_name' => 'postslug']
//        );
//
//
//        // Page by slug
//        $routes->connect('/{slug}',
//            ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
//            ['pass' => []]
//        );
//
//        $routes->fallbacks('DashedRoute');
    }

    /**
     * @inheritDoc
     */
    public function implementedEvents(): array
    {
        return [
//            'Controller.initialize' => function (Event $event) {
//                if ($event->getSubject() instanceof \App\Controller\AppController) {
//                    $event->getSubject()->loadComponent('Content.Frontend');
//                }
//            },
        ];
    }
}
