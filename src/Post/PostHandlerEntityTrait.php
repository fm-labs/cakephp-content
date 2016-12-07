<?php
namespace Content\Post;

use Content\Lib\ContentManager;

/**
 * Class PostHandlerEntityTrait
 * @package Content\Post
 *
 * @TODO Cache handler results in entity _properties
 */
trait PostHandlerEntityTrait
{

    protected $_postHandler;
    protected $_postHandlerTypeField = 'type';
    
    /**
     * @return PostHandlerInterface
     * @throws \Exception
     */
    public function handler()
    {
        if ($this->_postHandler === null) {

            $type = $this->get($this->_postHandlerTypeField);
            if (!$type) {
                throw new \Exception(sprintf('Post Handler can not be attached without type for post with id ' . $this->id));
            }

            $this->_postHandler = ContentManager::getPostHandlerInstance($this);
            if (!$this->_postHandler) {
                throw new \Exception(sprintf('Post Handler not found for type %s', $type));
            }
        }
        return $this->_postHandler;
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
        return $this->handler()->getViewUrl();
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
        return $this->handler()->getAdminUrl();
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
     */
    public function getChildren()
    {
        return $this->handler()->getChildren();
    }

    protected function _getChildren()
    {
        return $this->getChildren();
    }


}