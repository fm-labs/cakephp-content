<?php
use Cake\Core\Configure;
use Cake\Routing\Router;

// root scope routes
Router::scope('/', function(\Cake\Routing\RouteBuilder $routes) {

    // map root page to content pages controller
    if (Configure::read('Content.Router.disableRootUrl') !== true) {
        $routes->connect('/', ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index']);
    }

    // map pretty urls in the root scope
    if (Configure::read('Content.Router.enablePrettyUrls')) {
        $routes->connect('/:slug/:page_id/*',
            ['plugin' => 'Content',  'controller' => 'Pages', 'action' => 'view'],
            ['page_id' => '\d+', 'pass' => ['page_id'], '_name' => 'page']
        );

        // Page by pageId
        $routes->connect('/:page_id',
            ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
            ['page_id' => '\d+', 'pass' => ['page_id']]
        );
    }
});

// content plugin routes
Router::scope('/content', ['plugin' => 'Content', '_namePrefix' => 'content:'], function($routes) {

    $routes->connect('/', ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index']);

    // Page by slug and pageId
    if (Configure::read('Content.Router.enablePrettyUrls')) {
        $routes->connect('/:slug/:page_id/*',
            ['plugin' => 'Content',  'controller' => 'Pages', 'action' => 'view'],
            ['page_id' => '\d+', 'pass' => ['page_id'], '_name' => 'page']
        );

        // Page by pageId
        $routes->connect('/:page_id',
            ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
            ['page_id' => '\d+', 'pass' => ['page_id']]
        );
    }

    // Pages with '/page' prefix (@deprecated)
    $routes->connect('/page/:slug/:page_id/*',
        ['plugin' => 'Content',  'controller' => 'Pages', 'action' => 'view'],
        ['page_id' => '\d+', 'pass' => ['page_id']]
    );

    $routes->connect('/page/:page_id',
        ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
        ['page_id' => '\d+', 'pass' => ['page_id']]
    );

    $routes->connect('/page/:slug',
        ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
        ['pass' => []]
    );

    // Posts with '/post' prefix
    $routes->connect('/post/:slug/:post_id/*',
        ['plugin' => 'Content',  'controller' => 'Posts', 'action' => 'view'],
        ['post_id' => '\d+', 'pass' => ['post_id'], '_name' => 'post']
    );

    $routes->connect('/post/:post_id',
        ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'view'],
        ['post_id' => '\d+', 'pass' => ['post_id']]
    );

    $routes->connect('/post/:slug',
        ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'view'],
        ['pass' => [], '_name' => 'postslug']
    );


    // Page by slug
    /*
    $routes->connect('/:slug',
        ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
        ['pass' => []]
    );
    */

    $routes->fallbacks('DashedRoute');
});
