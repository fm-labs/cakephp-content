<?php

namespace Content\Model\Entity\Node;

use Content\Model\Entity\Post;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;

class RedirectNodeType extends DefaultNodeType
{
    public function getViewUrl()
    {
        return $this->item->get('url');
    }

    public function getAdminUrl()
    {
        return ['admin' => true, 'plugin' => 'Content', 'controller' => 'Nodes', 'action' => 'view', $this->item->id];
    }
}