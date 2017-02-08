<?php

namespace Content\Sitemap;

use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Query;
use Sitemap\Sitemap\AbstractTableSitemapProvider;
use Sitemap\Sitemap\SitemapLocation;

class PostsSitemapProvider extends AbstractTableSitemapProvider
{
    public $modelClass = 'Content.Posts';

    public function find(Query $query)
    {
        $query->find('published');
        $query->where(['Posts.type' => 'post', 'Posts.refscope' => 'Content.Posts']);
        return $query;
    }

    public function compile(ResultSetInterface $result)
    {
        foreach ($result as $post) {
            $this->_addLocation(new SitemapLocation($post->getViewUrl()));
        }
    }
}