<?php

namespace Content\Event;


use Cake\Event\Event;
use Cake\Event\EventListenerInterface;

class SitemapListener implements EventListenerInterface
{
    public function implementedEvents()
    {
        return [
            'Sitemap.get' => 'getSitemaps',
        ];
    }

    public function getSitemaps(Event $event)
    {
        $providers = [
            'pages' => 'Content.Pages',
            'posts' => 'Content.Posts',
            //'shop_products' => 'Shop.ShopProducts',
            //'shop_categories' => 'Shop.ShopCategories',
        ];
        foreach ($providers as $provider => $className) {
            $event->result['provider'][$provider] = $className;
        }
    }
}