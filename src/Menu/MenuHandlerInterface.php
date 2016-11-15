<?php

namespace Content\Menu;


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
     * @return ResultSet
     */
    public function getChildren();

    /**
     * @return boolean
     */
    public function isHiddenInNav();
}