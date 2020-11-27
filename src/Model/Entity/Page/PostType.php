<?php
declare(strict_types=1);

namespace Content\Model\Entity\Page;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class PostType extends AbstractType
{
    public function getViewUrl()
    {
        if (Configure::read('Content.Router.enablePrettyUrls')) {
            $pageUrl = [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Posts',
                'action' => 'view',
                'id' => $this->page->get('id'),
                'slug' => $this->page->get('slug'),
            ];
        } else {
            $pageUrl = [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Posts',
                'action' => 'view',
                $this->page->get('id'),
                'slug' => $this->page->get('slug'),
            ];
        }

        return $pageUrl;
    }

    public function getPermaUrl()
    {
        return '/?page=' . $this->page->get('id');
    }

    public function getAdminUrl()
    {
        return [
            'prefix' => 'Admin',
            'plugin' => 'Content',
            'controller' => 'Pages',
            'action' => 'manage',
            $this->page->get('id'),
        ];
    }

    public function getChildren()
    {
        return TableRegistry::getTableLocator()->get('Content.Pages')
            ->find()
            ->where(['parent_id' => $this->page->get('id')])
            ->order(['pos' => 'ASC']);
    }

    public function isPublished()
    {
        return $this->page->get('is_published');
    }
}
