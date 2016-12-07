<?php
/**
 * Created by PhpStorm.
 * User: flow
 * Date: 11/5/16
 * Time: 10:19 PM
 */

namespace Content\Post;


use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\ResultSet;

interface PostHandlerInterface
{
    public static function describe();

    public function __construct(EntityInterface $entity);

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
     */
    public function getChildren();
}