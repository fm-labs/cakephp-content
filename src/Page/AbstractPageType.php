<?php

namespace Content\Page;

use Cake\Datasource\EntityInterface;
use Content\Model\Entity\Page;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

abstract class AbstractPageType implements PageTypeInterface
{
    /**
     * @var Page
     */
    protected $page;
    
    public function setEntity(EntityInterface $page)
    {
        $this->page =& $page;
    }
    
    public function getUrl()
    {
        if (Configure::read('Content.Router.enablePrettyUrls')) {

            $pageUrl = [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Pages',
                'action' => 'view',
                'page_id' => $this->page->id,
                'slug' => $this->page->slug,
            ];
        } else {

            $pageUrl = [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Pages',
                'action' => 'view',
                $this->page->id,
                'slug' => $this->page->slug,
            ];
        }

        return $pageUrl;
    }

    public function getAdminUrl()
    {
        return [
            'prefix' => 'admin',
            'plugin' => 'Content',
            'controller' => 'Pages',
            'action' => 'manage',
            $this->page->id,
        ];
    }

    public function getChildren()
    {
        return TableRegistry::get('Content.Pages')
            ->find()
            ->where(['parent_id' => $this->page->id])
            ->orderAsc('lft')
            ->all()
            ->toArray();
    }

    public function isPublished()
    {
        return $this->page->is_published;
    }

    public function isHiddenInNav()
    {
        return $this->page->hide_in_nav;
    }
}