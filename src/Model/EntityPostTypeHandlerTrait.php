<?php
namespace Content\Model;

use Banana\Model\EntityTypeHandlerTrait;
use Content\Model\Entity\Post\PostTypeInterface;

/**
 * Class EntityPostTypeTrait
 *
 * @package Content\Model
 *
 * @TODO Cache handler results in entity _properties
 */
trait EntityPostTypeHandlerTrait
{
    use EntityTypeHandlerTrait {
        EntityTypeHandlerTrait::handler as typeHandler;
    }

    /**
     * @return PostTypeInterface
     * @throws \Exception
     */
    public function handler()
    {
        return $this->typeHandler();
    }

    protected function _getHandlerNamespace()
    {
        return 'PostType';
    }

    /**
     * @return array|string
     * @throws \Exception
     */
    public function getViewUrl()
    {
        return $this->handler()->getViewUrl();
    }

    protected function _getViewUrl()
    {
        return $this->getViewUrl();
    }

    /**
     * @return array|string
     * @throws \Exception
     */
    public function getAdminUrl()
    {
        return $this->handler()->getAdminUrl();
    }

    protected function _getAdminUrl()
    {
        return $this->getAdminUrl();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isPublished()
    {
        return $this->handler()->isPublished();
    }

    protected function _isPublished()
    {
        return $this->isPublished();
    }

    /**
     * @return \Cake\ORM\Query
     * @throws \Exception
     * @TODO This method should return an resultset instead of an query
     */
    public function getChildren()
    {
        return $this->handler()->getChildren();
    }

    protected function _getChildren()
    {
        $children = $this->getChildren();
        return ($children) ? $children->all()->toArray() : [];
    }


}