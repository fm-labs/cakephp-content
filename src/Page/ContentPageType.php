<?php
namespace Content\Page;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\Network\Response;

/**
 * Class ContentPageType
 *
 * @package Content\Page
 */
class ContentPageType extends AbstractPageType
{
    /**
     * @param Controller $controller
     * @return null|Response
     */
    public function execute(Controller &$controller, EntityInterface $entity)
    {
        $view = ($entity->get('page_template')) ?: $entity->get('type');
        $view = ($controller->request->query('view')) ?: $view; //@todo Remove statement. Debug only
        $controller->viewBuilder()->template($view);

        $layout = ($entity->get('page_layout')) ? $entity->get('page_layout')->get('template') : null;
        $controller->viewBuilder()->layout($layout);

        $controller->set('page', $entity);
    }
}
