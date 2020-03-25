<?php
declare(strict_types=1);

namespace Content\Sitemap;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;

class SitemapListener implements EventListenerInterface
{
    /**
     * Implemented events
     */
    public function implementedEvents(): array
    {
        return [
            'Seo.Sitemap.get' => 'getSitemap',
            'Sitemap.get' => 'getSitemap',
        ];
    }

    public function getSitemap(Event $event)
    {
        $Pages = TableRegistry::getTableLocator()->get('Content.Articles');
        $Pages->addBehavior('Seo.Sitemap', ['fields' => ['loc' => 'url', 'lastmod' => 'modified']]);

        $event->getSubject()->add($Pages->find()->where(['Articles.type' => 'page'])->find('published')->find('sitemap')->toArray(), 'pages');
        $event->getSubject()->add($Pages->find()->where(['Articles.type' => 'post'])->find('published')->find('sitemap')->toArray(), 'posts');
    }
}
