<?php
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Content\ArticleManager;
use Content\MenuManager;

/**
 * Load default content config
 */
Configure::load('Content.content');


if (!Cache::getConfig('content_menu')) {
    Cache::setConfig('content_menu', [
        'className' => 'File',
        'duration' => '+1 day',
        'path' => CACHE,
        'prefix' => 'content_menu_',
    ]);
}

ArticleManager::registerType('post', [
    'label' => 'Post',
    'className' => 'Content.Post',
]);

ArticleManager::registerType('page', [
    'label' => 'Page',
    'className' => 'Content.Page',
]);


MenuManager::registerType([
    'root' => [
        'label' => __('Root'),
        'className' => '\\Content\\Model\\Entity\\Menu\\RootType',
        'content' => false,
        'menu' => true,
    ],
//    'home' => [
//        'label' => __('Home Page'),
//        'className' => '\\Content\\Model\\Entity\\Menu\\HomeType',
//        'content' => false,
//        'menu' => true,
//    ],
    'page' => [
        'label' => __('Page'),
        'className' => '\\Content\\Model\\Entity\\Menu\\PageType',
        'content' => ['page'],
        'menu' => true,
    ],
//    'static' => [
//        'label' => __('Static Page'),
//        'className' => '\\Content\\Model\\Entity\\Menu\\StaticType',
//        'content' => false,
//        'menu' => true,
//    ],
    'controller' => [
        'label' => __('Custom Controller'),
        'className' => '\\Content\\Model\\Entity\\Menu\\ControllerType',
        'content' => false,
        'menu' => true,
    ],
//    'redirect' => [
//        'label' => __('Redirect'),
//        'className' => '\\Content\\Model\\Entity\\Menu\\LinkType',
//        'content' => false,
//        'menu' => true,
//    ],
    'link' => [
        'label' => __('Custom Link'),
        'className' => '\\Content\\Model\\Entity\\Menu\\LinkType',
        'content' => false,
        'menu' => true,
    ],
//    'shop_category' => [
//        'label' => __('Shop Category'),
//        'className' => '\\Content\\Model\\Entity\\Menu\\ShopCategoryType',
//        'content' => false,
//        'menu' => true,
//    ],
]);


/**
 * Register classes
 */
//ClassRegistry::register('ArticleType', [
//    'default' => '\Content\Model\Entity\Article\DefaultArticleType',
//    'gallerypost' => '\Content\Model\Entity\Article\GalleryItemArticleType',
//    'post' => '\Content\Model\Entity\Article\DefaultArticleType',
//    'page' => '\Content\Model\Entity\Article\PageArticleType',
//    'teaser' => '\Content\Model\Entity\Article\TeaserArticleType',
//    'inline' => '\Content\Model\Entity\Article\DefaultArticleType',
//    'multipage' => '\Content\Model\Entity\Article\DefaultArticleType',
//]);

// @deprecated
//ClassRegistry::register('PageType', [
//    'root' =>  'Content\Page\RootPageType',
//    'content' => 'Content\Page\ContentPageType',
//    'static' => 'Content\Page\StaticPageType',
//    'redirect' => 'Content\Page\RedirectPageType',
//    'controller' => 'Content\Page\ControllerPageType',
//]);

//ClassRegistry::register('ContentModule', [
//    'flexslider' => 'Content.Flexslider',
//    'pages_menu' => 'Content.PagesMenu',
//    'pages_submenu' => 'Content.PagesMenu',
//    'html' => 'Content.Html'
//]);
