<?php
use Cake\Core\Configure;
use Cake\Core\Plugin;

if (!Configure::read('Content')) {
    die("Content Plugin not configured");
}

/**
 * Default Content setup
 */
use Content\Lib\ContentManager;
ContentManager::register('PostType', [
    'gallerypost' => 'Content\Post\GalleryItemPostHandler',
    'post' => 'Content\Post\DefaultPostHandler',
    'page' => 'Content\Post\PagePostHandler',
    'inline' => 'Content\Post\DefaultPostHandler',
    'multipage' => 'Content\Post\DefaultPostHandler',
    //'shop_category' => 'Shop\Post\ShopCategoryPostHandler',
]);
ContentManager::register('MenuItemType', [
    'page' => 'Content\Menu\PostMenuHandler',
    'post' => 'Content\Menu\PostMenuHandler',
    'redirect' => 'Content\Menu\RedirectMenuHandler',
    'controller' => 'Content\Menu\ControllerMenuHandler',
    //'shop_category' => 'Shop\Menu\ShopCategoryMenuHandler',
]);

// @deprecated
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
Plugin::load('Banana', ['bootstrap' => true, 'routes' => true]);
//Plugin::load('Backend', ['bootstrap' => true, 'routes' => true]);
//Plugin::load('User', ['bootstrap' => true, 'routes' => true]);
//Plugin::load('Tree', ['bootstrap' => true, 'routes' => false]);
//Plugin::load('Media', ['bootstrap' => true, 'routes' => true]);
//Plugin::load('Settings', ['bootstrap' => true, 'routes' => true]);

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
use Backend\Lib\Backend;
Backend::hookPlugin('Content');