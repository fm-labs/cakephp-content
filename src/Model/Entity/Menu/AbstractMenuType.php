<?php
declare(strict_types=1);

namespace Content\Model\Entity\Menu;

use Cake\Core\InstanceConfigTrait;
use Cake\Datasource\EntityInterface;
use Cupcake\Menu\MenuItem;

abstract class AbstractMenuType implements MenuTypeInterface
{
    use InstanceConfigTrait;

    protected $_defaultConfig = ['title' => null];

    protected $_extractVars = ['type', 'title', 'hide_in_nav', 'hide_in_sitemap', 'cssid', 'cssclass'];

    protected $entity;

    /**
     * @inheritDoc
     */
    public function __construct(EntityInterface $entity)
    {
        $this->entity = $entity;
        $this->setConfig($entity->get('type_params'));
        $this->setConfig($entity->extract($this->_extractVars));
    }

    /**
     * @inheritDoc
     */
    public function getLabel()
    {
        return static::class;
    }

    /**
     * @inheritDoc
     */
    public function getUrl()
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getPermaUrl()
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function isVisibleInMenu()
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function isVisibleInSitemap()
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function toMenuItem($maxDepth = 0)
    {
        $url = $this->getUrl();

        $item = new MenuItem(
            $this->getLabel(),
            $this->getUrl()
        );

        return $item;
    }
}
