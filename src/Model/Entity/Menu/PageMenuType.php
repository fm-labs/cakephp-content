<?php
declare(strict_types=1);

namespace Content\Model\Entity\Menu;

use Cupcake\Menu\MenuItem;
use Cake\Core\InstanceConfigTrait;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;

/**
 * Class PageType
 *
 * @package Content\Model\Entity\Menu
 */
class PageMenuType extends AbstractMenuType
{
    use InstanceConfigTrait;

    protected $_defaultConfig = [
        'title' => null,
        'page_id' => null,
        'hide_in_nav' => false,
        'hide_in_sitemap' => false,
    ];

    /**
     * @var \Content\Model\Entity\Page
     */
    protected $_page;

    public function __construct(EntityInterface $entity)
    {
        parent::__construct($entity);
        $this->_page = $this->_getPage($this->getConfig('page_id'));
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
        if ($this->_page->get('slug')) {
            return [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Pages',
                'action' => 'view',
                'slug' => $this->_page->get('slug')
            ];
        }

        return [
            'prefix' => false,
            'plugin' => 'Content',
            'controller' => 'Pages',
            'action' => 'view',
            'id' => $this->getConfig('page_id')
        ];
        */
        return $this->_page->getUrl();
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
            'query' => ['p' => $this->getConfig('page_id')]
        ];
        */
        return $this->_page->getPermaUrl();
    }

    /**
     * {@inheritDoc}
     */
    public function isVisibleInMenu()
    {
        return $this->_page->is_published;
    }

    /**
     * {@inheritDoc}
     */
    public function isVisibleInSitemap()
    {
        return $this->_page->is_published;
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
     * @param int $id Page ID
     * @return \Content\Model\Entity\Page
     */
    protected function _getPage($id)
    {
        return TableRegistry::getTableLocator()->get('Content.Pages')->get($id);
    }
}
