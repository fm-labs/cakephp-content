<?php
namespace Content\Model\Entity;

use Cake\Core\Configure;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Menu Entity.
 */
class Menu extends Entity
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
    protected function handler()
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
}
