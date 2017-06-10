<?php

namespace Content\Model\Entity\Post;

use Banana\Model\EntityTypeInterface;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;

interface PostTypeInterface extends EntityTypeInterface
{
    public static function describe();

    /**
     * @return string|array
     */
    public function getViewUrl();

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
