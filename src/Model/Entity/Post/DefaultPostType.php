<?php

namespace Content\Model\Entity\Post;

use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use Content\Model\Entity\Post;

class DefaultPostType implements PostTypeInterface
{
    /**
     * @var Post
     */
    protected $post;

    public static function describe()
    {
        return [
            'title' => 'Standard Post',
            'modelClass' => 'Content.Posts'
        ];
    }

    public function setEntity(EntityInterface $entity)
    {
        $this->post = $entity;
    }
    
    public function getViewUrl()
    {
        if (Configure::read('Content.Router.enablePrettyUrls')) {

            $postUrl = [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Posts',
                'action' => 'view',
                //'post_id' => $this->post->get('id'),
                'slug' => $this->post->get('slug'),
            ];
        } else {

            $postUrl = [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Posts',
                'action' => 'view',
                $this->post->get('id'),
                'slug' => $this->post->get('slug'),
            ];
        }

        return $postUrl;
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
        return TableRegistry::get('Content.Posts')
            ->find()
            ->where(['parent_id' => $this->post->get('id')])
            ->order(['pos' => 'ASC']);
    }

    public function isPublished()
    {
        return $this->post->get('is_published');
    }

}