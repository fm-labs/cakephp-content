<?php
declare(strict_types=1);

namespace Content\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Content\Model\Entity\Menu\MenuTypeInterface;

/**
 * Menu Entity.
 */
class Menu extends Entity implements MenuTypeInterface
{
    //use TranslateTrait;

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
    ];

    /**
     * @var array
     */
    protected $_virtual = [];

    /**
     * @return \Content\Model\Entity\Menu\MenuTypeInterface
     */
    protected function handler(): MenuTypeInterface
    {
        $types = TableRegistry::getTableLocator()->get('Content.Menus')->getTypes();

        $handlerBuilder = function (Menu $entity) use ($types) {
            $type = $entity->get('type');
            $params = (array)$entity->get('type_params');

            if (!isset($types[$type])) {
                throw new \Exception('Unknown type: ' . $type);
            }

            $className = $types[$type]['className'];
            if (!class_exists($className)) {
                throw new \Exception('Class not found: ' . $className);
            }

            $handler = new $className($entity);
            if (!($handler instanceof MenuTypeInterface)) {
                throw new \Exception('Invalid type handler: MUST implement MenuTypeInterface');
            }

            return $handler;
        };

        return $handlerBuilder($this);
    }

    public function getUrl()
    {
        return $this->handler()->getUrl();
    }

    public function getPermaUrl()
    {
        return $this->handler()->getPermaUrl();
    }

    public function isVisibleInMenu()
    {
        return $this->handler()->isVisibleInMenu();
    }

    public function isVisibleInSitemap()
    {
        return $this->handler()->isVisibleInSitemap();
    }

    public function toMenuItem($maxDepth = 0)
    {
        return $this->handler()->toMenuItem($maxDepth);
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->handler()->getLabel();
    }
}
