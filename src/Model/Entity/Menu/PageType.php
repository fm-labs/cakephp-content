<?php
namespace Content\Model\Entity\Menu;

use Banana\Menu\MenuItem;
use Cake\Core\InstanceConfigTrait;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use Content\Model\Entity\Post;
use Content\Page\TypeInterface;

/**
 * Class PageType
 *
 * @package Content\Model\Entity\Menu
 */
class PageType extends BaseType
{
    use InstanceConfigTrait;

    protected $_defaultConfig = [
        'title' => null,
        'post_id' => null,
        'hide_in_nav' => false,
        'hide_in_sitemap' => false,
    ];

    /**
     * @var \Content\Model\Entity\Post
     */
    protected $_post;

    public function __construct(EntityInterface $entity)
    {
        parent::__construct($entity);
        $this->_post = $this->_getPost($this->getConfig('post_id'));
    }

    /**
     * {@inheritDoc}
     */
    public function getLabel()
    {
        $label = $this->getConfig('title');
        if (!$label) {
            $label = get_class($this);
        }

        return $label;
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl()
    {
        /*
        if ($this->_post->get('slug')) {
            return [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Pages',
                'action' => 'view',
                'slug' => $this->_post->get('slug')
            ];
        }

        return [
            'prefix' => false,
            'plugin' => 'Content',
            'controller' => 'Pages',
            'action' => 'view',
            'id' => $this->getConfig('post_id')
        ];
        */
        return $this->_post->getUrl();
    }

    /**
     * {@inheritDoc}
     */
    public function getPermaUrl()
    {
        /*
        return [
            'prefix' => false,
            'plugin' => 'Content',
            'controller' => 'Main',
            'action' => 'index',
            'query' => ['p' => $this->getConfig('post_id')]
        ];
        */
        return $this->_post->getPermaUrl();
    }

    /**
     * {@inheritDoc}
     */
    public function isVisibleInMenu()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function isVisibleInSitemap()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function toMenuItem($maxDepth = 0)
    {
        $item = new MenuItem(
            $this->getLabel(),
            $this->getUrl()
        );

        return $item;
    }

    /**
     * @param int $id Post ID
     * @return Post
     */
    protected function _getPost($id)
    {
        return TableRegistry::getTableLocator()->get('Content.Posts')->get($id);
    }
}
