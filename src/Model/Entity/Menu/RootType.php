<?php
declare(strict_types=1);

namespace Content\Model\Entity\Menu;

use Banana\Menu\MenuItem;
use Cake\Datasource\EntityInterface;

class RootType extends BaseType
{
    /**
     * {@inheritDoc}
     */
    public function __construct(EntityInterface $entity)
    {
        $this->_defaultConfig = [
            'label' => __('Root'),
        ];
        parent::__construct($entity);
    }

    /**
     * {@inheritDoc}
     */
    public function getLabel()
    {
        return $this->getConfig('label');
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl()
    {
        return "/";
    }

    /**
     * @return mixed
     */
    public function getPermaUrl()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isVisibleInMenu()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isVisibleInSitemap()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function toMenuItem($maxDepth = 0)
    {
        $item = new MenuItem(
            $this->getLabel(),
            $this->getUrl()
        );

        return $item;
    }
}
