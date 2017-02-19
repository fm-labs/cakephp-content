<?php
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Banana\Lib\ClassRegistry;
use Backend\Lib\Backend;


/**
 * Load dependencies
 */
//Plugin::load('Eav', ['bootstrap' => false, 'routes' => true]);

/**
 * Load themes
 */
if (Configure::check('Content.Frontend.theme')) {
    try {
        Plugin::load(Configure::read('Content.Frontend.theme'), ['bootstrap' => true, 'routes' => true]);
    } catch (\Cake\Core\Exception\Exception $ex) {
        die ($ex->getMessage());
    }
}

/**
 * Register classes
 */
ClassRegistry::register('PostType', [
    'default' => 'Content\Model\Entity\Post\DefaultPostType',
    'gallerypost' => 'Content\Model\Entity\Post\GalleryItemPostType',
    'post' => 'Content\Model\Entity\Post\DefaultPostType',
    'page' => 'Content\Model\Entity\Post\PagePostType',
    'teaser' => 'Content\Model\Entity\Post\TeaserPostType',
    'inline' => 'Content\Model\Entity\Post\DefaultPostType',
    'multipage' => 'Content\Model\Entity\Post\DefaultPostType',
]);
ClassRegistry::register('NodeType', [
    'root' => 'Content\Model\Entity\Node\RootNodeType',
    'virtual' => 'Content\Model\Entity\Node\VirtualNodeType',
    'category' => 'Content\Model\Entity\Node\CategoryNodeType',
    'page' => 'Content\Model\Entity\Node\PostNodeType',
    'post' => 'Content\Model\Entity\Node\PostNodeType',
    'redirect' => 'Content\Model\Entity\Node\RedirectNodeType',
    'controller' => 'Content\Model\Entity\Node\ControllerNodeType',
]);

// @deprecated
ClassRegistry::register('PageType', [
    'root' =>  'Content\Page\RootPageType',
    'content' => 'Content\Page\ContentPageType',
    'static' => 'Content\Page\StaticPageType',
    'redirect' => 'Content\Page\RedirectPageType',
    'controller' => 'Content\Page\ControllerPageType',
]);

ClassRegistry::register('ContentModule', [
    'flexslider' => 'Content.FlexsliderModule',
    'pages_menu' => 'Content.PagesMenuModule',
    'pages_submenu' => 'Content.PagesMenuModule',
    'nodes_menu' => 'Content.NodesMenuModule'
]);

/**
 * Backend hook
 */
Backend::hookPlugin('Content');

