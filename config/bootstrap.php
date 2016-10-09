<?php
use Backend\Lib\Backend;
use Content\Lib\ContentManager;
use Cake\Core\Configure;
use Cake\Core\Plugin;

if (!Configure::read('Content')) {
    die("Content Plugin not configured");
}

/**
 * Default Content setup
 */
ContentManager::register('PageType', [
    'root' =>  [
        'name' => 'Website Root',
        'class' => 'Content\Page\RootPageType'
    ],
    'content' => [
        'name' => 'Content Page',
        'class' => 'Content\Page\ContentPageType'
    ],
    'static' => [
        'name' => 'Static Page',
        'class' => 'Content\Page\StaticPageType'
    ],
    'redirect' => [
        'name' => 'Redirect',
        'class' => 'Content\Page\RedirectPageType'
    ],
    'controller' => [
        'name' => 'Controller',
        'class' => 'Content\Page\ControllerPageType'
    ],
]);

ContentManager::register('ContentModule', [
    'Flexslider' => [
        'class' => 'Content.Flexslider'
    ],
    'HtmlElement' => [
        'class' => 'Content.HtmlElement'
    ],
    'PostsList' => [
        'class' => 'Content.PostsList'
    ],
    'PostsView' => [
        'class' => 'Content.PostsView'
    ],
    'TextHtml' => [
        'class' => 'Content.TextHtml'
    ],
    'PagesMenu' => [
        'class' => 'Content.PagesMenu'
    ],
    'PagesSubmenu' => [
        'class' => 'Content.PagesSubmenu'
    ],
    'Image' => [
        'class' => 'Content.Image'
    ]
]);

/**
 * Core Content plugins (required)
 */
Plugin::load('Backend', ['bootstrap' => true, 'routes' => true]);
Plugin::load('User', ['bootstrap' => true, 'routes' => true]);
Plugin::load('Tree', ['bootstrap' => true, 'routes' => false]);
Plugin::load('Media', ['bootstrap' => true, 'routes' => true]);
Plugin::load('Settings', ['bootstrap' => true, 'routes' => true]);

/**
 * Theme plugins
 */
if (Configure::check('Content.Frontend.theme')) {
    try {
        Plugin::load(Configure::read('Content.Frontend.theme'), ['bootstrap' => true, 'routes' => true]);
    } catch (\Cake\Core\Exception\Exception $ex) {
        die ($ex->getMessage());
    }
}

/**
 * Backend hook
 */
Backend::hookPlugin('Content');