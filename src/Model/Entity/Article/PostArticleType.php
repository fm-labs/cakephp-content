<?php

namespace Content\Model\Entity\Article;

use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use Content\Model\Entity\Article;

class PostArticleType extends BaseArticleType
{
    public function getViewUrl()
    {
        if (Configure::read('Content.Router.enablePrettyUrls')) {
            $articleUrl = [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Posts',
                'action' => 'view',
                'id' => $this->article->get('id'),
                'slug' => $this->article->get('slug'),
            ];
        } else {
            $articleUrl = [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Posts',
                'action' => 'view',
                $this->article->get('id'),
                'slug' => $this->article->get('slug'),
            ];
        }

        return $articleUrl;
    }

    public function getPermaUrl()
    {
        return '/?article=' . $this->article->get('id');
    }

    public function getAdminUrl()
    {
        return [
            'prefix' => 'admin',
            'plugin' => 'Content',
            'controller' => 'Articles',
            'action' => 'manage',
            $this->article->get('id'),
        ];
    }

    public function getChildren()
    {
        return TableRegistry::getTableLocator()->get('Content.Articles')
            ->find()
            ->where(['parent_id' => $this->article->get('id')])
            ->order(['pos' => 'ASC']);
    }

    public function isPublished()
    {
        return $this->article->get('is_published');
    }
}
