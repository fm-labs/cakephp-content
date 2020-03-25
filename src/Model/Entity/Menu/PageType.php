<?php
declare(strict_types=1);

namespace Content\Model\Entity\Menu;

use Banana\Menu\MenuItem;
use Cake\Core\InstanceConfigTrait;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;

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
        'article_id' => null,
        'hide_in_nav' => false,
        'hide_in_sitemap' => false,
    ];

    /**
     * @var \Content\Model\Entity\Article
     */
    protected $_article;

    public function __construct(EntityInterface $entity)
    {
        parent::__construct($entity);
        $this->_article = $this->_getArticle($this->getConfig('article_id'));
    }

    /**
     * {@inheritDoc}
     */
    public function getLabel()
    {
        $label = $this->getConfig('title');
        if (!$label) {
            $label = static::class;
        }

        return $label;
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl()
    {
        /*
        if ($this->_article->get('slug')) {
            return [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Pages',
                'action' => 'view',
                'slug' => $this->_article->get('slug')
            ];
        }

        return [
            'prefix' => false,
            'plugin' => 'Content',
            'controller' => 'Pages',
            'action' => 'view',
            'id' => $this->getConfig('article_id')
        ];
        */
        return $this->_article->getUrl();
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
            'query' => ['p' => $this->getConfig('article_id')]
        ];
        */
        return $this->_article->getPermaUrl();
    }

    /**
     * {@inheritDoc}
     */
    public function isVisibleInMenu()
    {
        return $this->_article->is_published;
    }

    /**
     * {@inheritDoc}
     */
    public function isVisibleInSitemap()
    {
        return $this->_article->is_published;
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
     * @param int $id Article ID
     * @return \Content\Model\Entity\Article
     */
    protected function _getArticle($id)
    {
        return TableRegistry::getTableLocator()->get('Content.Articles')->get($id);
    }
}
