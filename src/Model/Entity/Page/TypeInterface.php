<?php
declare(strict_types=1);

namespace Content\Model\Entity\Page;

use Cupcake\Model\EntityTypeInterface;

interface TypeInterface extends EntityTypeInterface
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
     * @return bool
     */
    public function isPublished();

    /**
     * @return \Cake\ORM\Query
     * @TODO This method should return an resultset instead of an query
     */
    public function getChildren();
}
