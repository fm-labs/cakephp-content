<?php

namespace Content\Menu;

use Cake\ORM\TableRegistry;
use Content\Lib\ContentManager;
use Content\Model\Entity\MenuItem;
use Content\Model\Entity\Post;
use Cake\Core\Configure;

class PostMenuHandler extends BaseMenuHandler implements MenuHandlerInterface
{
    /**
     * @var Post
     */
    protected $post;

    public function __construct(MenuItem $item)
    {
        parent::__construct($item);
        $this->post = ContentManager::getPostByType($item->type, $item->typeid);
    }

    public function getViewUrl()
    {
        return $this->post->getViewUrl();
    }

    public function getAdminUrl()
    {
        return $this->post->getAdminUrl();
    }

    public function isHiddenInNav()
    {
        if ($this->post && !$this->post->isPublished()) {
            return true;
        }

        return parent::isHiddenInNav();
    }
}