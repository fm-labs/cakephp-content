<?php
use Cake\Core\Configure;
use Cake\Core\Plugin;

//if (!Configure::read('Content')) {
//    die("Content Plugin not configured");
//}

use Banana\Lib\ClassRegistry;
ClassRegistry::add('PostType', [
    'gallerypost' => 'Content\Post\GalleryItemPostHandler',
    'post' => 'Content\Post\DefaultPostHandler',
    'page' => 'Content\Post\PagePostHandler',
    'inline' => 'Content\Post\DefaultPostHandler',
    'multipage' => 'Content\Post\DefaultPostHandler',
]);
ClassRegistry::add('MenuItemType', [
    'page' => 'Content\Menu\PostMenuHandler',
    'post' => 'Content\Menu\PostMenuHandler',
    'redirect' => 'Content\Menu\RedirectMenuHandler',
    'controller' => 'Content\Menu\ControllerMenuHandler',
]);

// @deprecated
ClassRegistry::add('PageType', [
    'root' =>  'Content\Page\RootPageType',
    'content' => 'Content\Page\ContentPageType',
    'static' => 'Content\Page\StaticPageType',
    'redirect' => 'Content\Page\RedirectPageType',
    'controller' => 'Content\Page\ControllerPageType',
]);

ClassRegistry::add('ContentModule', [
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
    'MenuMenu' => [
        'class' => 'Content.Menu'
    ],
    'MenuSubmenu' => [
        'class' => 'Content.MenuSubmenu'
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