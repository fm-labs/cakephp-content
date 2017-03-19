<?php

namespace Content\Model\Entity\Post;

use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use Content\Model\Entity\Post;

class GalleryItemPostType extends DefaultPostType implements  PostTypeInterface
{
    /**
     * @var Post
     */
    protected $post;

    public static function describe()
    {
        return [
            'title' => 'Gallery Item',
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
            'controller' => 'Galleries',
            'action' => 'edit_post',
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