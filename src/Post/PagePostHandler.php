<?php

namespace Content\Post;

use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use Content\Model\Entity\Post;

class PagePostHandler extends DefaultPostHandler implements  PostHandlerInterface
{
    /**
     * @var Post
     */
    protected $page;

    public static function describe()
    {
        return [
            'title' => 'Page',
            'modelClass' => 'Content.Posts'
        ];
    }
    
    public function __construct(EntityInterface $entity)
    {
        $this->page = $entity;
    }
    
    public function getViewUrl()
    {
        if (Configure::read('Content.Router.enablePrettyUrls')) {

            $pageUrl = [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Posts',
                'action' => 'view',
                //'page_id' => $this->page->get('id'),
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

    public function getAdminUrl()
    {
        return [
            'prefix' => 'admin',
            'plugin' => 'Content',
            'controller' => 'Posts',
            'action' => 'manage',
            $this->page->get('id'),
        ];
    }

    public function getChildren()
    {
        return TableRegistry::get('Content.Posts')
            ->find('published')
            ->where(['parent_id' => $this->page->get('id')])
            ->order(['pos' => 'ASC'])
            ->all();
    }

    public function isPublished()
    {
        return $this->page->get('is_published');
    }

}