<?php
namespace Content\Page;

use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * Class RedirectPageType
 * @package Content\Page
 */
class RedirectPageType extends AbstractPageType
{
    /**
     * @param EntityInterface $entity
     * @return string
     */
    public function toUrl(EntityInterface $entity)
    {
        $url = $entity->redirect_location;

        return Router::url($url, true);
    }

    /**
     * @param Controller $controller
     * @param EntityInterface $entity
     * @return bool
     */
    public function execute(Controller &$controller, EntityInterface $entity)
    {
        if ($entity->redirect_page_id) {
            $page = TableRegistry::get('Content.Pages')->get($entity->redirect_page_id, ['contain' => []]);
            $redirectUrl = $page->url;
        } else {
            $redirectUrl = $entity->redirect_location;
        }

        return $controller->redirect($redirectUrl, $entity->redirect_status);
    }
}
