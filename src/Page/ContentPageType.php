<?php
namespace Content\Page;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\Network\Response;

class ContentPageType extends AbstractPageType
{
    /**
     * @param Controller $controller
     * @return null|Response
     */
    public function execute(Controller &$controller, EntityInterface $entity)
    {
    }
}
