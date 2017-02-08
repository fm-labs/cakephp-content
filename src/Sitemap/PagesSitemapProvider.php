<?php

namespace Content\Sitemap;

use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Query;
use Sitemap\Sitemap\AbstractTableSitemapProvider;
use Sitemap\Sitemap\SitemapLocation;

class PagesSitemapProvider extends AbstractTableSitemapProvider
{
    public $modelClass = 'Content.Posts';

    public function find(Query $query)
    {
        $query->find('published');
        $query->where(['Posts.type' => 'page']);
        return $query;
    }

    public function compile(ResultSetInterface $result)
    {
        foreach ($result as $page) {
           $this->_addLocation(new SitemapLocation($page->getViewUrl(), 0.8));
        }
    }
}