<?php
namespace Content\Model\Entity;

use Banana\Model\EntityTypeHandlerTrait;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\ORM\Behavior\Translate\TranslateTrait;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Content\Lib\ContentManager;
use Content\Model\Behavior\PageMeta\PageMetaTrait;
use Content\Page\AbstractPageType;
use Content\Page\PageInterface;
use Content\Page\PageTypeInterface;

/**
 * Page Entity.
 */
class OldPage extends Entity
{
    use TranslateTrait;
    use PageMetaTrait;

    /**
     * @var
     */
    private $__parentTheme;

    /**
     * @var string PageMetaTrait model definition
     */
    protected $_pageMetaModel = 'Content.Pages';

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true, //@TODO define accessible fields
        'lft' => true,
        'rght' => true,
        'parent_id' => true,
        'title' => true,
        'slug' => true,
        'type' => true,
        'redirect_status' => true,
        'redirect_location' => true,
        'redirect_controller' => true,
        'redirect_page_id' => true,
        'page_layout_id' => true,
        'page_template' => true,
        'is_published' => true,
        'publish_start_date' => true,
        'publish_end_date' => true,
        'parent_page' => true,
        'child_pages' => true,
    ];

    /**
     * @var array
     */
    protected $_virtual = [
        'meta_title',
        'meta_desc',
        'meta_keywords',
        'meta_robots',
        'meta_lang'
    ];

    /**
     * @return \Cake\ORM\Query
     */
    public function getPath()
    {
        return TableRegistry::get('Content.OldPages')
            ->find('path', ['for' => $this->id]);
    }

    /**
     * @return array
     */
    public function _getPosts()
    {
        if (isset($this->_properties['posts'])) {
            return $this->_properties['posts'];
        }

        return TableRegistry::get('Content.OldPages')->Posts
            ->find('sorted')
            ->where([ 'Posts.refscope' => 'Content.Pages', 'Posts.refid' => $this->id])
            ->order(['Posts.pos' => 'DESC'])
            ->all()
            ->toArray();
    }

    /**
     * @return mixed
     * @todo Replace with ParentTrait
     */
    protected function _getParentTheme()
    {
        if ($this->get('theme')) {
            return $this->get('theme');
        }

        if ($this->__parentTheme) {
            return $this->__parentTheme;
        }

        if ($this->get('parent_id')) {
            $Parent = TableRegistry::get('Content.OldPages');
            $parent = $Parent->get($this->get('parent_id'));

            return $this->__parentTheme = $parent->parent_theme;
        }

        return Configure::read('Site.theme');
    }

    /**
     * @return \Cake\Datasource\ResultSetInterface
     * @todo Cache results
     */
    protected function _getPublishedPosts()
    {
        return TableRegistry::get('Content.Posts')
            ->find('published')
            ->where(['Posts.refscope' => 'Content.Pages', 'Posts.refid' => $this->id])
            ->order(['Posts.pos' => 'ASC', 'Posts.id' => 'ASC'])
            ->all();
    }
}
