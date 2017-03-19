<?php

namespace Content\Sitemap;

use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Query;
use Sitemap\Sitemap\AbstractTableSitemapProvider;
use Sitemap\Sitemap\SitemapLocation;

class PagesSitemapProvider extends AbstractTableSitemapProvider
{
    public $modelClass = 'Content.Pages';

    public $name = 'pages';

    public function find(Query $query)
    {
        $query->find('published');
        //$query->where(['Page.type' => 'content']);
        return $query;
    }

    public function compile(ResultSetInterface $result)
    {
        foreach ($result as $page) {
           $this->_addLocation(new SitemapLocation($page->url, 0.8, $page->modified));
        }
    }

}