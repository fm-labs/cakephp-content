<?php

namespace Content\Model\Entity\Post;

use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use Content\Model\Entity\Post;

class PagePostType extends DefaultPostType
{
    public static function describe()
    {
        return [
            'title' => 'Page',
            'modelClass' => 'Content.Posts'
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getViewUrl()
    {
        if ($this->post->get('slug')) {
            return [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Pages',
                'action' => 'view',
                'slug' => $this->post->get('slug')
            ];
        }

        return [
            'prefix' => false,
            'plugin' => 'Content',
            'controller' => 'Pages',
            'action' => 'view',
            'id' => $this->post->get('id')
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getPermaUrl()
    {
        return "/?page=" . $this->post->get('id');
    }

    /*
    public function getViewUrl()
    {
        if (Configure::read('Content.Router.enablePrettyUrls')) {
            $pageUrl = [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Pages',
                'action' => 'view',
                //'page_id' => $this->post->get('id'),
                'slug' => $this->post->get('slug'),
            ];
        } else {
            $pageUrl = [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Pages',
                'action' => 'view',
                $this->post->get('id'),
                'slug' => $this->post->get('slug'),
            ];
        }

        return $pageUrl;
    }
    */

    public function getAdminUrl()
    {
        return [
            'prefix' => 'admin',
            'plugin' => 'Content',
            'controller' => 'Pages',
            'action' => 'manage',
            $this->post->get('id'),
        ];
    }

    public function getChildren()
    {
        return TableRegistry::getTableLocator()->get('Content.Posts')
            ->find()
            ->where(['parent_id' => $this->post->get('id')])
            ->order(['pos' => 'ASC']);
    }

    public function isPublished()
    {
        return $this->post->get('is_published');
    }
}
