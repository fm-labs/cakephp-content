<?php

namespace Content\Model\Entity\Node;


use Banana\Model\EntityTypeInterface;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\ResultSet;
use Content\Model\Entity\Node;

interface NodeTypeInterface extends EntityTypeInterface
{
    public function setEntity(EntityInterface $entity);

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @return mixed
     */
    public function getViewUrl();

    /**
     * @return mixed
     */
    public function getAdminUrl();

    /**
     * @return array
     */
    public function getChildNodes();

    /**
     * @return boolean
     */
    public function isHiddenInNav();
}