<?php

namespace Content\Model\Entity\Post;

use Cake\Datasource\EntityInterface;
use Content\Model\Entity\Post;
use Content\Model\Entity\Post\PostTypeInterface;

class TeaserPostType implements PostTypeInterface
{
    /**
     * @var Post
     */
    protected $post;

    /**
     * @return array
     */
    public static function describe()
    {
        return [
            'title' => 'Teaser',
            'modelClass' => 'Content.Posts'
        ];
    }

    public function setEntity(EntityInterface $entity)
    {
        $this->post = $entity;
    }

    public function getViewUrl()
    {
        return false;
    }

    public function getAdminUrl()
    {
        return [
            'prefix' => 'admin',
            'plugin' => 'Content',
            'controller' => 'Posts',
            'action' => 'manage',
            $this->post->get('id'),
        ];
    }

    public function getChildren()
    {
        return null;
    }

    public function isPublished()
    {
        return $this->post->get('is_published');
    }
}
