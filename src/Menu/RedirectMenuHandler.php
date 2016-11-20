<?php

namespace Content\Menu;

use Content\Model\Entity\Post;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;

class RedirectMenuHandler extends BaseMenuHandler implements MenuHandlerInterface
{
    public function getViewUrl()
    {
        return $this->item->get('url');
    }

    public function getAdminUrl()
    {
        return ['admin' => true, 'plugin' => 'Content', 'controller' => 'MenuItems', 'action' => 'view', $this->item->id];
    }
}