<?php
declare(strict_types=1);

namespace Content\Model\Entity\Menu;

use Cupcake\Menu\MenuItem;
use Cake\Datasource\EntityInterface;

class RootMenuType extends AbstractMenuType
{
    /**
     * {@inheritDoc}
     */
    public function __construct(EntityInterface $entity)
    {
        $this->_defaultConfig = [
            'label' => __d('content', 'Root'),
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
