<?php
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Banana\Lib\ClassRegistry;


//Configure::load('Content.content');
//try { Configure::load('content'); } catch (\Exception $ex) {}
//try { Configure::load('local/content'); } catch (\Exception $ex) {}

/**
 * Load dependencies
 */
//Plugin::load('Eav', ['bootstrap' => false, 'routes' => true]);
//Plugin::load('Media', ['bootstrap' => true, 'routes' => true]);

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
    'flexslider' => 'Content.FlexsliderModule',
    'pages_menu' => 'Content.PagesMenuModule',
    'pages_submenu' => 'Content.PagesMenuModule',
    'nodes_menu' => 'Content.NodesMenuModule'
]);
