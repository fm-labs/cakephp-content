<?php
use Cake\Core\Configure;
use Cake\Routing\Router;

Router::extensions(['json']);


Router::plugin('Content', [], function($routes) {


    // Admin routes
    //if (!Configure::read('Content.Router.disableAdminRoutes')) {
        $routes->scope( '/admin', ['plugin' => 'Content', '_namePrefix' => 'content:admin:', 'prefix' => 'admin'],function ($routes) {

            $routes->extensions(['json']);

            $routes->connect('/', ['controller' => 'Pages', 'action' => 'index'], ['_name' => 'index']);
            //$routes->connect('/:controller');
            $routes->fallbacks('DashedRoute');
        });
    //}

});



return;






if (Configure::read('Content.Router.enableRootScope')) {

    Router::scope('/', function($routes) {

        $routes->connect('/', ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index']);

        // Pages
        $routes->connect('/:slug/:page_id/*',
            ['plugin' => 'Content',  'controller' => 'Pages', 'action' => 'view'],
            ['page_id' => '^[0-9]+', 'pass' => ['page_id'], '_name' => 'page']
        );

        $routes->connect('/:slug',
            ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
            ['pass' => []]
        );

        $routes->connect('/*',
            ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
            ['pass' => ['page_id'], 0 => '^[0-9]+']
        );

        // Posts
        $routes->connect('/post/:slug/:post_id/*',
            ['plugin' => 'Content',  'controller' => 'Posts', 'action' => 'view'],
            ['post_id' => '^[0-9]+', 'pass' => ['post_id'], ['_name' => 'post']]
        );

        $routes->connect('/post/:slug',
            ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'view'],
            ['pass' => [], ['_name' => 'postslug']]
        );

        $routes->connect('/post/*',
            ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'view'],
            ['pass' => ['post_id'], 0 => '^[0-9]+']
        );

    });
}

// Frontend routes

Router::scope('/content', ['plugin' => 'Content', '_namePrefix' => 'content:', ], function ($routes) {

    if (!Configure::read('Content.Router.disableFrontendRoutes') && Configure::read('Content.Router.enablePrettyUrls')) {

        $routes->connect('/page/:slug/:page_id/*',
            ['plugin' => 'Content',  'controller' => 'Pages', 'action' => 'view'],
            ['pass' => ['page_id'], '_name' => 'page']
        );

        $routes->connect('/page/:slug',
            ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
            ['pass' => []]
        );

        $routes->connect('/page/*',
            ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
            ['pass' => ['page_id'], 0 => '^[0-9]+']
        );

        // Posts
        $routes->connect('/post/:slug/:post_id/*',
            ['plugin' => 'Content',  'controller' => 'Posts', 'action' => 'view'],
            ['pass' => ['post_id'], ['_name' => 'post']]
        );

        $routes->connect('/post/:slug',
            ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'view'],
            ['pass' => []]
        );

        $routes->connect('/post/*',
            ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'view'],
            ['pass' => ['post_id'], 0 => '^[0-9]+']
        );

    }

    $routes->fallbacks('DashedRoute');

});




// Content SEO: robots.txt
//Router::connect('/robots.txt', ['plugin' => 'Content', 'controller' => 'Seo', 'action' => 'robots']);

// Content SEO: sitemap.xml
//Router::connect('/sitemap.posts.xml', ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'sitemap']);
//Router::connect('/sitemap.pages.xml', ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'sitemap']);

