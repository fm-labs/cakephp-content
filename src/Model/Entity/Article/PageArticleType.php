<?php
declare(strict_types=1);

namespace Content\Model\Entity\Article;

use Cake\ORM\TableRegistry;

class PageArticleType extends BaseArticleType
{
    /**
     * {@inheritDoc}
     */
    public function getViewUrl()
    {
        if ($this->article->get('slug')) {
            return [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Pages',
                'action' => 'view',
                $this->article->get('id'),
                'slug' => $this->article->get('slug'),
            ];
        }

        return [
            'prefix' => false,
            'plugin' => 'Content',
            'controller' => 'Pages',
            'action' => 'view',
            'id' => $this->article->get('id'),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getPermaUrl()
    {
        return "/?page=" . $this->article->get('id');
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
                //'page_id' => $this->article->get('id'),
                'slug' => $this->article->get('slug'),
            ];
        } else {
            $pageUrl = [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Pages',
                'action' => 'view',
                $this->article->get('id'),
                'slug' => $this->article->get('slug'),
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
            $this->article->get('id'),
        ];
    }

    public function getChildren()
    {
        return TableRegistry::getTableLocator()->get('Content.Articles')
            ->find()
            ->where(['parent_id' => $this->article->get('id')])
            ->order(['pos' => 'ASC']);
    }

    public function isPublished()
    {
        return $this->article->get('is_published');
    }
}
