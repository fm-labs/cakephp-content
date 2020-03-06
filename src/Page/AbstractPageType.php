<?php

namespace Content\Page;

use Banana\Menu\MenuItem;
use Cake\Datasource\EntityInterface;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * Class AbstractPageType
 *
 * @package Content\Page
 */
abstract class AbstractPageType implements PageTypeInterface
{
    /**
     * @param EntityInterface $entity
     * @return string
     */
    public function getLabel(EntityInterface $entity)
    {
        return $entity->title;
    }

    /**
     * @param EntityInterface $entity
     * @param int $maxDepth
     * @return MenuItem
     */
    public function toMenuItem(EntityInterface $entity, $maxDepth = 1)
    {
        $title = $entity->title;
        $url = $this->toUrl($entity);

        $item = new MenuItem($title, $url, ['class' => $entity->cssclass]);

        return $item;
    }

    /**
     * @param EntityInterface $entity
     * @return array
     */
    public function toUrl(EntityInterface $entity)
    {
        if (Configure::read('Content.Router.enablePrettyUrls')) {
            $pageUrl = [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Pages',
                'action' => 'view',
                'page_id' => $entity->id,
                'slug' => $entity->slug,
            ];
        } else {
            $pageUrl = [
                'prefix' => false,
                'plugin' => 'Content',
                'controller' => 'Pages',
                'action' => 'view',
                $entity->id,
                'slug' => $entity->slug,
            ];
        }

        return $pageUrl;
    }

    /**
     * @param EntityInterface $entity
     * @return array
     */
    public function findChildren(EntityInterface $entity)
    {
        return TableRegistry::getTableLocator()->get('Content.Pages')
            ->find()
            ->where(['parent_id' => $entity->id])
            ->orderAsc('lft')
            ->all()
            ->toArray();
    }

    /**
     * @param EntityInterface $entity
     * @return bool
     */
    public function isEnabled(EntityInterface $entity)
    {
        return ($entity->is_published && !$entity->hide_in_nav);
    }
}
