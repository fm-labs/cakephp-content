<?php
namespace Content\Model\Entity\Menu;

use Banana\Menu\MenuItem;
use Cake\Core\InstanceConfigTrait;
use Cake\Datasource\EntityInterface;

abstract class BaseType implements MenuTypeInterface
{
    use InstanceConfigTrait;

    protected $_defaultConfig = ['title' => null];

    protected $_extractVars = ['type', 'title', 'hide_in_nav', 'hide_in_sitemap', 'cssid', 'cssclass'];

    protected $entity;

    /**
     * {@inheritDoc}
     */
    public function __construct(EntityInterface $entity)
    {
        $this->entity = $entity;
        $this->config($entity->get('type_params'));
        $this->config($entity->extract($this->_extractVars));
    }

    /**
     * @deprecated
     */
    public function setEntity(EntityInterface $entity)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function getLabel()
    {
        return get_class($this);
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl()
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function getPermaUrl()
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function isVisibleInMenu()
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function isVisibleInSitemap()
    {
        return false;
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

    /***** Model functions *****/

    /**
     * @return bool
     */
    public function validate()
    {
        return true;
    }
}
