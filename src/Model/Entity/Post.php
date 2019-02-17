<?php
namespace Content\Model\Entity;

use Banana\Model\EntityTypeHandlerInterface;
use Cake\Core\Configure;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Content\Model\EntityPostTypeHandlerTrait;

//use Eav\Model\EntityAttributesInterface;
//use Eav\Model\EntityAttributesTrait;

/**
 * Post Entity.
 */
class Post extends Entity implements EntityTypeHandlerInterface //, EntityAttributesInterface
{
    //use EntityAttributesTrait;
    use EntityPostTypeHandlerTrait;

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true, //@todo Define accessible fields
        'site_id' => true,
        'title' => true,
        'slug' => true,
        'subheading' => true,
        'teaser_html' => true, // @deprecated
        'body_html' => true,
        'image_file' => true,
        //'image_file_upload' => true,
        'image_files' => true,
        //'image_files_upload' => true,
        'priority' => true,
        'is_published' => true,
        'publish_start_datetime' => true,
        'publish_end_datetime' => true,
        'is_home' => true,
    ];

    /**
     * @var array
     */
    protected $_virtual = [
        'url',
        'view_url',
        'children'
    ];

    /**
     * @param $val
     * @return string
     */
    protected function _setTitle($val)
    {
        return trim($val);
    }

    /**
     * Virtual Field 'url'
     * @deprecated Use _getViewUrl() instead
     */
    protected function _getUrl()
    {
        return $this->_getViewUrl();
    }

    /**
     * Virtual Field 'perma_url'
     * @return string
     */
    protected function _getPermaUrl()
    {
        return '/?postid=' . $this->id;
    }

    /**
     * Virtual field 'image'. Wrapper for 'image_file'
     * @return mixed
     */
    protected function _getImage()
    {
        return $this->image_file;
    }

    /**
     * Virtual field 'images'. Wrapper for 'image_files'
     * @return mixed
     */
    protected function _getImages()
    {
        return $this->image_files;
    }

    /**
     * Virtual field 'teaser_image'. Wrapper for 'teaser_image_file'
     * Fallback to 'image_file'
     * @return mixed
     * @deprecated
     */
    protected function _getTeaserImage()
    {
        if (!empty($this->_properties['teaser_image_file'])) {
            return $this->_properties['teaser_image_file'];
        }

        return $this->image_file;
    }

    /**
     * @return null|string
     * @deprecated
     */
    protected function _getReftitle()
    {
        if (!$this->refscope) {
            return null;
        }

        $ref = pluginSplit($this->refscope);

        //$refmodel = TableRegistry::get($this->refscope);
        //$ref = $refmodel->get($this->refid);

        return __d('content', "{0} with ID {1}", Inflector::singularize($ref[1]), $this->refid);
    }

    /**
     * @return array|void
     * @deprecated
     */
    protected function _getRefurl()
    {
        if (!$this->refscope) {
            return;
        }

        $ref = pluginSplit($this->refscope);

        return ['plugin' => $ref[0], 'controller' => $ref[1], 'action' => 'view', $this->refid];
    }

    /**
     * @return \Cake\Datasource\EntityInterface|mixed|null
     * @deprecated
     */
    protected function _getRef()
    {
        if (!$this->refscope || !$this->refid) {
            return null;
        }

        if (isset($this->_properties['ref'])) {
            return $this->_properties['ref'];
        }

        $Model = TableRegistry::get($this->refscope);

        return $this->_properties['ref'] = $Model->get($this->refid);
    }

    /**
     * Get Teaser Link Url.
     * Fallback to view url, if body is set.
     *
     * @return array|null
     * @deprecated
     */
    protected function _getTeaserLinkUrl()
    {
        // customer teaser link
        if (!empty($this->_properties['teaser_link_href'])) {
            return $this->_properties['teaser_link_href'];
        }

        if (!empty($this->_properties['body_html'])) {
            return $this->_getViewUrl();
        }

        return null;
    }

    /**
     * @return mixed
     * @deprecated
     */
    protected function _getTeaserLinkTitle()
    {
        if (!empty($this->_properties['teaser_link_caption'])) {
            return $this->_properties['teaser_link_caption'];
        }

        return __d('content', 'Read more');
    }
}
