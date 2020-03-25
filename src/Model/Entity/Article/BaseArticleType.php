<?php
declare(strict_types=1);

namespace Content\Model\Entity\Article;

use Cake\Datasource\EntityInterface;

abstract class BaseArticleType implements ArticleTypeInterface
{
    /**
     * @var \Content\Model\Entity\Article
     */
    protected $article;

    public function __construct(EntityInterface $entity)
    {
        $this->article = $entity;
    }

    /**
     * @param \Cake\Datasource\EntityInterface $entity
     * @return mixed
     * @deprcated Use constructor instead
     */
    public function setEntity(EntityInterface $entity)
    {
        $this->article = $entity;
    }
}
