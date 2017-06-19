<?php
namespace Content\Page;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;

/**
 * Class StaticPageType
 *
 * @package Content\Page
 */
class StaticPageType extends AbstractPageType
{
    /**
     * @param Controller $controller
     * @param EntityInterface $entity
     * @return bool
     */
    public function execute(Controller &$controller, EntityInterface $entity)
    {
        $action = ($entity->get('page_template')) ?: null;
        if ($action !== 'view' && $action && method_exists($this, $action)) {
            $controller->setAction($action);
        }

        $controller->render($action);
    }
}
