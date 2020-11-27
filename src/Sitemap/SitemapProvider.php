<?php
declare(strict_types=1);

namespace Content\Sitemap;

use Cake\ORM\TableRegistry;
use Seo\Sitemap\SitemapUrl;

class SitemapProvider implements \IteratorAggregate
{
    /**
     * @return \Generator|\Traversable
     */
    public function getIterator()
    {
        $Pages = TableRegistry::getTableLocator()->get('Content.Pages');
        foreach ($Pages->find()->where(['Pages.type' => 'page'])->find('published') as $page) {
            yield new SitemapUrl($page->url, 0.5, $page->modified);
        }

        foreach ($Pages->find()->where(['Pages.type' => 'post'])->find('published') as $page) {
            yield new SitemapUrl($page->url, 0.5, $page->modified);
        }
    }
}
