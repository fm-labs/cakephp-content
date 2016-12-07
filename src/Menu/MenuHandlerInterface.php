<?php

namespace Content\Menu;


use Cake\ORM\Query;
use Cake\ORM\ResultSet;
use Content\Model\Entity\MenuItem;

interface MenuHandlerInterface
{
    public function __construct(MenuItem $item);

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
     * @return Query
     */
    public function getChildren();

    /**
     * @return boolean
     */
    public function isHiddenInNav();
}