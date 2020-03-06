<?php

namespace Content\Page;

use Banana\Menu\Menu;
use Banana\Menu\MenuItem;
use Cake\Collection\Collection;
use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\Http\Response;

/**
 * Interface PageTypeInterface
 *
 * @package Content\Page
 */
interface PageTypeInterface
{

    /**
     * @param EntityInterface $entity
     * @return string
     */
    public function getLabel(EntityInterface $entity);

    /**
     * @return MenuItem
     */
    public function toMenuItem(EntityInterface $entity, $maxDepth = 1);

    /**
     * @return mixed
     */
    public function toUrl(EntityInterface $entity);

    /**
     * @param EntityInterface $entity
     * @return Menu|Collection
     */
    public function findChildren(EntityInterface $entity);

    /**
     * @param EntityInterface $entity
     * @return bool
     */
    public function isEnabled(EntityInterface $entity);

    /**
     * @param Controller $controller
     * @return null|Response
     */
    public function execute(Controller &$controller, EntityInterface $entity);
}
