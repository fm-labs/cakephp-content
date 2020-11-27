<?php
declare(strict_types=1);

namespace Content\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Text;
use Cupcake\Model\EntityTypeHandlerTrait;

/**
 * Page Entity.
 */
class Page extends Entity implements Page\TypeInterface
{
    use EntityTypeHandlerTrait;

    protected static $_typeField = 'type';
    protected static $_typeNamespace = "Content.Page";
    protected static $_typeInterface = Page\TypeInterface::class;

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
        'excerpt_text' => true, // @deprecated
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
        //'view_url',
        'children',
        'excerpt_text',
    ];

    /**
     * Alias for 'getViewUrl'
     *
     * @return array|string
     * @throws \Exception
     */
    public function getUrl()
    {
        return $this->getViewUrl();
    }

    /**
     * @return array|string
     * @throws \Exception
     */
    public function getViewUrl()
    {
        return $this->handler()->getViewUrl();
    }

    /**
     * @return array|string
     * @throws \Exception
     */
    public function getPermaUrl()
    {
        return $this->handler()->getPermaUrl();
    }

    /**
     * @return array|string
     * @throws \Exception
     */
    public function getAdminUrl()
    {
        return $this->handler()->getAdminUrl();
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

    /**
     * @return bool
     * @throws \Exception
     */
    public function isPublished()
    {
        return $this->handler()->isPublished();
    }

    public function isProtected()
    {
        return false;
    }

    /**
     * @param string $val Title value
     * @return string
     */
    protected function _setTitle($val)
    {
        return trim($val);
    }

    /**
     * @return array|string
     * @throws \Exception
     */
    protected function _getViewUrl()
    {
        deprecationWarning(sprintf("%s::%s is deprecated. Use %s instead", get_class($this), __METHOD__, substr(__METHOD__, 1)));
        return $this->getViewUrl();
    }

    /**
     * @return array|string
     * @throws \Exception
     */
    protected function _getAdminUrl()
    {
        deprecationWarning(sprintf("%s::%s is deprecated. Use %s instead", get_class($this), __METHOD__, substr(__METHOD__, 1)));
        return $this->getAdminUrl();
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function _getChildren()
    {
        deprecationWarning(sprintf("%s::%s is deprecated. Use %s instead", get_class($this), __METHOD__, substr(__METHOD__, 1)));
        $children = $this->getChildren();

        return $children ? $children->all()->toArray() : [];
    }

    /**
     * Virtual Field 'url'
     *
     * @throws \Exception
     * @deprecated Use _getViewUrl() instead
     */
    protected function _getUrl()
    {
        deprecationWarning(sprintf("%s::%s is deprecated. Use %s instead", get_class($this), __METHOD__, "getViewUrl"));
        return $this->getViewUrl();
    }

    /**
     * Virtual Field 'perma_url'
     *
     * @return string
     * @throws \Exception
     */
    protected function _getPermaUrl()
    {
        deprecationWarning(sprintf("%s::%s is deprecated. Use %s instead", get_class($this), __METHOD__, substr(__METHOD__, 1)));
        return $this->getPermaUrl();
    }

    /**
     * Get page excepert.
     *
     * @return string
     */
    protected function _getExcerpt(): string
    {
        $excerpt = $this->excerpt_text;
        if (!$excerpt) {
            $excerpt = strip_tags($this->body_html);
            $excerpt = Text::truncate($excerpt, 500);
        }

        return $excerpt;
    }

    /**
     * Alias for property 'image_file'.
     *
     * @return mixed|null
     */
    protected function _getImage()
    {
        return $this->get('image_file');
    }
}
