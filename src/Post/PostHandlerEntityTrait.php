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
     * @return array
     */
    public function getViewUrl()
    {
        return $this->handler()->getViewUrl();
    }


    /**
     * @return array
     */
    public function getAdminUrl()
    {
        return $this->handler()->getAdminUrl();
    }

    /**
     * @return array
     */
    public function isPublished()
    {
        return $this->handler()->isPublished();
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        return $this->handler()->getChildren()->toArray();
    }

    /**
     * @return array
     */
    protected function _getViewUrl()
    {
        return $this->handler()->getViewUrl();
    }


    /**
     * @return array
     */
    protected function _getAdminUrl()
    {
        return $this->handler()->getAdminUrl();
    }

}