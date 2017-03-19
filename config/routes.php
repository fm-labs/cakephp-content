<?php
use Cake\Core\Configure;
use Cake\Routing\Router;

Router::connect('/', ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index']);

$scope = '/' . trim(Configure::read('Content.Router.scope'), '/');
Router::scope($scope, ['plugin' => 'Content', '_namePrefix' => 'content:'], function($routes) {

    //$routes->connect('/', ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index']);

    // Page by slug and pageId
    $routes->connect('/:slug/:page_id/*',
        ['plugin' => 'Content',  'controller' => 'Pages', 'action' => 'view'],
        ['page_id' => '\d+', 'pass' => ['page_id'], '_name' => 'page']
    );

    // Page by pageId
    $routes->connect('/:page_id',
        ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
        ['page_id' => '\d+', 'pass' => ['page_id']]
    );

    // Page by slug
    $routes->connect('/:slug',
        ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'view'],
        ['pass' => []]
    );

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


    $routes->fallbacks('DashedRoute');
});
unset($scope);

// Admin routes
Router::scope('/content/admin', ['plugin' => 'Content', '_namePrefix' => 'content:admin:', 'prefix' => 'admin'], function ($routes) {
    $routes->extensions(['json']);
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'index'], ['_name' => 'index']);
    $routes->fallbacks('DashedRoute');
});