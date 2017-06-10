<?php

namespace Content\Sitemap;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;

class SitemapListener implements EventListenerInterface
{
    /**
     * Implemented events
     */
    public function implementedEvents()
    {
        return [
            'Seo.Sitemap.get' => 'getSitemap',
            'Sitemap.get' => 'getSitemap'
        ];
    }

    public function getSitemap(Event $event)
    {
        // Pages
        $Pages = TableRegistry::get('Content.Pages');
        $Pages->addBehavior('Seo.Sitemap', ['fields' => ['loc' => 'url', 'lastmod' => 'modified']]);
        $event->subject()->add($Pages->find('published')->find('sitemap')->toArray(), 'pages');

        // Posts
        $Posts = TableRegistry::get('Content.Posts');
        $Posts->addBehavior('Seo.Sitemap', ['fields' => ['loc' => 'url', 'lastmod' => 'modified']]);
        $event->subject()->add($Posts->find('published')->find('sitemap')->toArray(), 'posts');
    }
}
