<?php
/**
 * Created by PhpStorm.
 * User: flow
 * Date: 11/12/16
 * Time: 7:29 PM
 */

namespace Content\Menu;


use Cake\ORM\TableRegistry;
use Content\Model\Entity\MenuItem;

abstract class BaseMenuHandler
{
    /**
     * @var MenuItem
     */
    protected $item;


    public function __construct(MenuItem $item)
    {
        $this->item = $item;
    }

    public function isHiddenInNav()
    {
        return $this->item->hide_in_nav;
    }

    public function getLabel()
    {
        return $this->item->title;
    }

    public function getChildren()
    {
        if ($this->item->id) {
            return TableRegistry::get('Content.MenuItems')->find('children', ['for' => $this->item->id, 'direct' => true])->toArray();
        }

        return [];
    }
}