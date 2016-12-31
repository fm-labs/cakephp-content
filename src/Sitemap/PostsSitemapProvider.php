<?php

namespace Content\Sitemap;

use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Query;
use Cake\ORM\ResultSet;
use Sitemap\Lib\ModelSitemapProvider;
use Sitemap\Lib\SitemapProviderInterface;

class PostsSitemapProvider extends ModelSitemapProvider
{
    public $modelClass = 'Content.Posts';

    public function find(Query $query)
    {
        $query->find('published');
        $query->where(['Posts.type' => 'post']);
        return $query;
    }

    public function compile(ResultSetInterface $result)
    {
        $locations = [];
        foreach ($result as $post) {
            $locations[] = [ 'url' => $post->getViewUrl()];
        }

        return $locations;
    }
}