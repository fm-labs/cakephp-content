<?php

namespace Content\Model\Entity\Node;

use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use Content\Lib\ContentManager;
use Content\Model\Entity\Category;
use Content\Model\Entity\Node;
use Content\Model\Entity\Post;
use Cake\Core\Configure;

class CategoryNodeType extends DefaultNodeType
{
    /**
     * @var Category
     */
    protected $category;

    public function setEntity(EntityInterface $entity)
    {
        parent::setEntity($entity);

        $Categories = TableRegistry::get('Content.Categories');
        $this->category = $Categories->get($entity->typeid);
    }

    public function getViewUrl()
    {
        return $this->category->getViewUrl();
    }

    public function getAdminUrl()
    {
        return $this->category->getAdminUrl();
    }

    public function isHiddenInNav()
    {
        if ($this->category && !$this->category->isPublished()) {
            return true;
        }

        return parent::isHiddenInNav();
    }
}