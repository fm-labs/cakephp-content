<?php
namespace Content\Page;

use Cake\Controller\Controller;
use Cake\Core\Plugin;
use Cake\Datasource\EntityInterface;
use Exception;

/**
 * Class ControllerPageType
 *
 * @package Content\Page
 */
class ControllerPageType extends AbstractPageType
{
    /**
     * @param EntityInterface $entity
     * @return array
     * @throws Exception
     */
    protected function _parseUrl(EntityInterface $entity)
    {
        $controller = explode('::', $entity->redirect_controller);
        $action = 'index';
        $params = [];
        if (count($controller) == 2) {
            list($controller, $action) = $controller;

            $action = explode(':', $action);
            if (count($action) == 2) {
                list($action, $args) = $action;

                $args = explode(',', $args);
                array_walk($args, function ($val, $idx) use (&$params, &$entity) {
                    $val = trim($val);
                    if (preg_match('/^[\{](.*)[\}]$/', $val, $matches)) {
                        $val = $entity->get($matches[1]);
                        $params[$matches[1]] = $val;
                    } else {
                        $params[] = $val;
                    }
                });

                //debug($params);
            } elseif (count($action) == 1) {
                $action = $action[0];
            } else {
                throw new Exception("Malformed controller params");
            }
        } elseif (count($controller) == 1) {
            $controller = $controller[0];
        } else {
            throw new Exception("Malformed controller location");
        }

        list($plugin, $controller) = pluginSplit($controller);

        $url = compact('plugin', 'controller', 'action');
        $url = array_merge($params, $url);

        return $url;
    }

    /**
     * @param EntityInterface $entity
     * @return array
     * @throws Exception
     */
    public function toUrl(EntityInterface $entity)
    {
        $url = $this->_parseUrl($entity);
        $url['prefix'] = false;
        $url['page_id'] = $entity->id;

        return $url;
    }

    /**
     * @param EntityInterface $entity
     * @return bool
     * @throws Exception
     */
    public function isEnabled(EntityInterface $entity)
    {
        $url = $this->_parseUrl($entity);
        if ($url['plugin'] && Plugin::loaded($url['plugin']) === false) {
            return false;
        }

        return parent::isEnabled($entity);
    }

    /**
     * @param Controller $controller
     * @param EntityInterface $entity
     * @return \Cake\Network\Response|null
     */
    public function execute(Controller &$controller, EntityInterface $entity)
    {
        $url = $this->toUrl($entity);
        $status = ($entity->get('redirect_status')) ?: 302;
        return $controller->redirect($url, $status);
    }
}
