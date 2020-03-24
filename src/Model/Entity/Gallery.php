<?php
namespace Content\Model\Entity;

use Cake\Core\Plugin;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Media\Lib\Media\MediaManager;

/**
 * Gallery Entity.
 *
 * @property int $id
 * @property string $title
 * @property string $desc_html
 */
class Gallery extends Entity
{
    /**
     * @var Gallery
     */
    protected $_parent;

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    /**
     * @return \Cake\Datasource\EntityInterface|Gallery|mixed|null
     */
    protected function _getParent()
    {
        if ($this->_parent === null && isset($this->_properties['parent_id'])) {
            $this->_parent = TableRegistry::getTableLocator()->get('Content.Galleries')->get($this->_properties['parent_id']);
        }

        return $this->_parent;
    }

    /**
     * @return null
     */
    protected function _getDescHtml()
    {
        if ($this->inherit_desc && $this->parent) {
            return $this->parent->desc_html;
        }

        return (isset($this->_properties['desc_html'])) ? $this->_properties['desc_html'] : null;
    }

    /**
     * @return array
     */
    protected function _getImages()
    {
        switch ($this->_properties['source']) {
            case "folder":
                return $this->_loadImagesFromFolder();

            default:
                throw new \InvalidArgumentException("Gallery: Unknown source: " . $this->_properties['source']);
        }
    }

    /**
     * @return mixed
     */
    protected function _getPublishedArticles()
    {
        return TableRegistry::getTableLocator()->get('Content.Articles')
            ->find('all', ['media' => true])
            ->find('sorted')
            ->find('published')
            ->where([
            'refscope' => 'Content.Galleries',
            'refid' => $this->id,
            ])->all();
    }

    /**
     * @return array
     */
    protected function _loadImagesFromFolder()
    {
        $images = [];

        if (Plugin::isLoaded('Media')) {
            $folder = $this->_properties['source_folder'];
            $mm = MediaManager::get('default');
            $files = $mm->listFiles($folder);
            array_walk($files, function ($val) use (&$images, &$mm) {
                if (preg_match('/^_/', basename($val))) {
                    return;
                }
                $images[] = $mm->getFileUrl($val);
            });
        }

        return $images;
    }
}
