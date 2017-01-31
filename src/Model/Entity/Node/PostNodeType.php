<?php

namespace Content\Model\Entity\Node;

use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use Content\Lib\ContentManager;
use Content\Model\Entity\Node;
use Content\Model\Entity\Post;
use Cake\Core\Configure;

class PostNodeType extends DefaultNodeType
{
    /**
     * @var Post
     */
    protected $post;

    public function setEntity(EntityInterface $entity)
    {
        parent::setEntity($entity);
        $this->post = ContentManager::getPostByType($entity->type, $entity->typeid);
    }

    public function getViewUrl()
    {
        return $this->post->getViewUrl();
    }

    public function getAdminUrl()
    {
        return $this->post->getAdminUrl();
    }

    public function isHiddenInNav()
    {
        if ($this->post && !$this->post->isPublished()) {
            return true;
        }

        return parent::isHiddenInNav();
    }
}