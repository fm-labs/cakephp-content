<?php
namespace Content\Page;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\Http\Response;

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
        $view = ($controller->request->getQuery('view')) ?: $view; //@todo Remove statement. Debug only
        $controller->viewBuilder()->setTemplate($view);

        $layout = ($entity->get('page_layout')) ? $entity->get('page_layout')->get('template') : null;
        $controller->viewBuilder()->setLayout($layout);

        $controller->set('page', $entity);
    }
}
