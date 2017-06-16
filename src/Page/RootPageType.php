<?php
namespace Content\Page;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;

/**
 * Class RootPageType
 * @package Content\Page
 */
class RootPageType extends AbstractPageType
{
    /**
     * @param EntityInterface $entity
     * @return string
     */
    public function toUrl(EntityInterface $entity)
    {
        return '/';
    }

    /**
     * @param Controller $controller
     * @param EntityInterface $entity
     * @return \Cake\Network\Response|null|void
     */
    public function execute(Controller &$controller, EntityInterface $entity)
    {
        $controller->setAction('view', $entity->redirect_page_id);
        //return $controller->render('view');
    }
}
