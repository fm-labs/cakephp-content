<?php
use Banana\Lib\ClassRegistry;
use Banana\Plugin\PluginLoader;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\EventManager;
use Cake\ORM\TableRegistry;

/**
 * Load default content config
 */
Configure::load('Content.content'); //@TODO remove

/**
 * Load dependencies
 */
// @todo Let the application know, that we support the Eav plugin  -> Remove hard dependency -> Recommend plugin usage
//Plugin::load('Eav', ['bootstrap' => false, 'routes' => true]);
// @todo Let the application know, that we support the Media plugin  -> Remove hard dependency -> Recommend plugin usage
//PluginLoader::load('Media', ['enabled' => true, 'configs' => true, 'bootstrap' => true, 'routes' => true]);
Plugin::load('Bootstrap');

Configure::write('Content.PageTypes.content', [
    'title' => 'Content Page',
    'className' => 'Content.Content'
]);

Configure::write('Content.PageTypes.static',[
    'title' => 'Static Page',
    'className' => 'Content.Static'
]);
Configure::write('Content.PageTypes.controller',[
    'title' => 'Controller',
    'className' => 'Content.Controller'
]);
Configure::write('Content.PageTypes.redirect',[
    'title' => 'Redirect',
    'className' => 'Content.Redirect'
]);
Configure::write('Content.PageTypes.root',[
    'title' => 'Root Page',
    'className' => 'Content.Root'
]);


if (!Cache::config('content_menu')) {
    Cache::config('content_menu', [
        'className' => 'File',
        'duration' => '+1 day',
        'path' => CACHE,
        'prefix' => 'content_menu_'
    ]);
}

TableRegistry::config('PageTypes', ['className' => 'Content.PageTypes']);

/**
 * Register classes
 * @TODO Move to ContentPlugin
 */
ClassRegistry::register('PostType', [
    'default' => '\Content\Model\Entity\Post\DefaultPostType',
    'gallerypost' => '\Content\Model\Entity\Post\GalleryItemPostType',
    'post' => '\Content\Model\Entity\Post\DefaultPostType',
    'page' => '\Content\Model\Entity\Post\PagePostType',
    'teaser' => '\Content\Model\Entity\Post\TeaserPostType',
    'inline' => '\Content\Model\Entity\Post\DefaultPostType',
    'multipage' => '\Content\Model\Entity\Post\DefaultPostType',
]);

// @deprecated
ClassRegistry::register('PageType', [
    'root' =>  'Content\Page\RootPageType',
    'content' => 'Content\Page\ContentPageType',
    'static' => 'Content\Page\StaticPageType',
    'redirect' => 'Content\Page\RedirectPageType',
    'controller' => 'Content\Page\ControllerPageType',
]);

//ClassRegistry::register('ContentModule', [
//    'flexslider' => 'Content.Flexslider',
//    'pages_menu' => 'Content.PagesMenu',
//    'pages_submenu' => 'Content.PagesMenu',
//    'html' => 'Content.Html'
//]);
