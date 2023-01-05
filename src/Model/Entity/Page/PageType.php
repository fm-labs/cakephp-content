<?php
declare(strict_types=1);

namespace Content\Model\Entity\Page;

use Cake\ORM\TableRegistry;

class PageType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function getViewUrl()
    {
        if ($this->page->get('slug')) {
            return [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Pages',
                'action' => 'view',
                'id' => $this->page->get('id'),
                'slug' => $this->page->get('slug'),
            ];
        }

        return [
            'prefix' => false,
            'plugin' => 'Content',
            'controller' => 'Pages',
            'action' => 'view',
            'id' => $this->page->get('id'),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getPermaUrl()
    {
        return "/?page=" . $this->page->get('id');
    }

    /*
    public function getViewUrl()
    {
        if (Configure::read('Content.Router.enablePrettyUrls')) {
            $pageUrl = [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Pages',
                'action' => 'view',
                //'page_id' => $this->page->get('id'),
                'slug' => $this->page->get('slug'),
            ];
        } else {
            $pageUrl = [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Pages',
                'action' => 'view',
                $this->page->get('id'),
                'slug' => $this->page->get('slug'),
            ];
        }

        return $pageUrl;
    }
    */

    public function getAdminUrl()
    {
        return [
            'prefix' => 'Admin',
            'plugin' => 'Content',
            'controller' => 'Pages',
            'action' => 'edit',
            $this->page->get('id'),
        ];
    }

    public function getChildren()
    {
        if ($this->page->get('id')) {
            return TableRegistry::getTableLocator()->get('Content.Pages')
                ->find()
                ->where(['parent_id' => $this->page->get('id')])
                ->order(['pos' => 'ASC'])
                ->all();
        }
        return [];
    }

    public function isPublished()
    {
        return $this->page->get('is_published');
    }
}
