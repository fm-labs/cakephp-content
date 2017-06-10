<?php

namespace Content\Model\Behavior\PageMeta;

use Cake\ORM\TableRegistry;

/**
 * Class PageMetaTrait
 *
 * @package Content\Model\Behavior\PageMeta
 */
trait PageMetaTrait
{
    /**
     * @return mixed
     */
    protected function _getMeta()
    {
        if (!array_key_exists('meta', $this->_properties)) {
            $this->_properties['meta'] = TableRegistry::get('Content.PageMetas')
                ->find()
                ->where(['PageMetas.model' => $this->_pageMetaModel, 'PageMetas.foreignKey' => $this->id])
                ->first();
        }

        return $this->_properties['meta'];
    }

    /**
     * @return mixed
     */
    protected function _getMetaTitle()
    {
        $meta = $this->_getMeta();
        if ($meta) {
            return $meta['title'];
        }
    }

    /**
     * @return mixed
     */
    protected function _getMetaDesc()
    {
        $meta = $this->_getMeta();
        if ($meta) {
            return $meta['description'];
        }
    }

    /**
     * @return mixed
     */
    protected function _getMetaKeywords()
    {
        $meta = $this->_getMeta();
        if ($meta) {
            return $meta['keywords'];
        }
    }

    /**
     * @return mixed
     */
    protected function _getMetaRobots()
    {
        $meta = $this->_getMeta();
        if ($meta) {
            return $meta['robots'];
        }
    }

    /**
     * @return mixed
     */
    protected function _getMetaLang()
    {
        $meta = $this->_getMeta();
        if ($meta) {
            return $meta['lang'];
        }
    }
}
