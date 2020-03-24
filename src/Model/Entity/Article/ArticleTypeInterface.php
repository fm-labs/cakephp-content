<?php

namespace Content\Model\Entity\Article;

use Banana\Model\EntityTypeInterface;
use Cake\ORM\Query;

interface ArticleTypeInterface extends EntityTypeInterface
{
    /**
     * @return string|array
     */
    public function getViewUrl();

    /**
     * @return string|array
     */
    public function getPermaUrl();

    /**
     * @return string|array
     */
    public function getAdminUrl();

    /**
     * @return boolean
     */
    public function isPublished();

    /**
     * @return Query
     * @TODO This method should return an resultset instead of an query
     */
    public function getChildren();
}
