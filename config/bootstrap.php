<?php
use Banana\Plugin\PluginLoader;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Banana\Lib\ClassRegistry;


//Configure::load('Content.content');

/**
 * Load dependencies
 */
//Plugin::load('Eav', ['bootstrap' => false, 'routes' => true]);
PluginLoader::load('Media', ['enabled' => true, 'configs' => true, 'bootstrap' => true, 'routes' => true]);


/**
 * Register classes
 * @TODO Move to ContentPlugin
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
    'flexslider' => 'Content.Flexslider',
    'pages_menu' => 'Content.PagesMenu',
    'pages_submenu' => 'Content.PagesMenu',
    'nodes_menu' => 'Content.NodesMenu'
]);


Cache::config('content_menu', [
    'className' => 'File',
    'duration' => '+1 day',
    'path' => CACHE,
    'prefix' => 'content_menu_'
]);