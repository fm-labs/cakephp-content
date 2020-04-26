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
        $Articles = TableRegistry::getTableLocator()->get('Content.Articles');
        foreach ($Articles->find()->where(['Articles.type' => 'page'])->find('published') as $article) {
            yield new SitemapUrl($article->url, 0.5, $article->modified);
        }

        foreach ($Articles->find()->where(['Articles.type' => 'post'])->find('published') as $article) {
            yield new SitemapUrl($article->url, 0.5, $article->modified);
        }
    }
}
