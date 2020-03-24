<?php

namespace Content\Model\Entity\Article;

use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use Content\Model\Entity\Article;

abstract class BaseArticleType implements ArticleTypeInterface
{
    /**
     * @var Article
     */
    protected $article;

    public function __construct(EntityInterface $entity)
    {
        $this->article = $entity;
    }

    /**
     * @param EntityInterface $entity
     * @return mixed
     * @deprcated Use constructor instead
     */
    public function setEntity(EntityInterface $entity)
    {
        $this->article = $entity;
    }
}
