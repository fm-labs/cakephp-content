<?php

namespace Content\Model\Entity\Node;


use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use Content\Model\Entity\Node;

/**
 * Class DefaultNodeType
 * @package Content\Model\Entity\Node
 *
 */
class DefaultNodeType implements NodeTypeInterface
{
    /**
     * @var Node
     */
    protected $item;


    public function setEntity(EntityInterface $entity)
    {
        $this->item = $entity;
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
            return TableRegistry::get('Content.Nodes')
                ->find('children', ['for' => $this->item->id, 'direct' => true]);
        }

        return [];
    }

    /**
     * @return mixed
     */
    public function getViewUrl()
    {
        return false;
    }

    /**
     * @return mixed
     */
    public function getAdminUrl()
    {
        return ['plugin' => 'Content', 'controller' => 'Nodes', 'action' => 'edit', $this->item->id];
    }
}