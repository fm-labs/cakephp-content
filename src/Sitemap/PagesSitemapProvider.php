<?php

namespace Content\Sitemap;

use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Query;
use Cake\ORM\ResultSet;
use Sitemap\Lib\ModelSitemapProvider;
use Sitemap\Lib\SitemapProviderInterface;

class PagesSitemapProvider extends ModelSitemapProvider
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
        $locations = [];
        foreach ($result as $page) {
            $locations[] = [ 'url' => $page->getViewUrl()];
        }

        return $locations;
    }
}