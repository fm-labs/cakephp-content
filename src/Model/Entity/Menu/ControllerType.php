<?php
namespace Content\Model\Entity\Menu;

use Cake\Routing\Exception\MissingRouteException;
use Cake\Routing\Router;

class ControllerType extends BaseType
{
    protected $_defaultConfig = [
        'title' => null,
        'controller' => null,
        'controller_action' => null,
    ];

    /**
     * {@inheritDoc}
     */
    public function getLabel()
    {
        return $this->getConfig('title');
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl()
    {
        return $this->_parseUrl(
            $this->getConfig('controller'),
            $this->getConfig('controller_action')
        );
    }

    /**
     * @return mixed
     */
    public function getPermaUrl()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isVisibleInMenu()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isVisibleInSitemap()
    {
        return true;
    }

    /**
     * @param string $controller Controller name ('MyController', 'Plugin.MyPluginController', 'MyController::action')
     * @param string|null $action Action name
     * @param string|null|bool $prefix Url prefix
     * @return array
     * @throws \Exception
     */
    protected function _parseUrl($controller, $action = 'index', $prefix = false)
    {
        $controller = explode('::', $controller);
        $action = ($action) ?: 'index';
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
                        $val = $this->getConfig($matches[1]);
                        $params[$matches[1]] = $val;
                    } else {
                        $params[] = $val;
                    }
                });

                //debug($params);
            } elseif (count($action) == 1) {
                $action = $action[0];
            } else {
                throw new \Exception("Malformed controller params");
            }
        } elseif (count($controller) == 1) {
            $controller = $controller[0];
        } else {
            throw new \Exception("Malformed controller location");
        }

        list($plugin, $controller) = pluginSplit($controller);

        $url = compact('plugin', 'controller', 'action', 'prefix');
        $url = array_merge($params, $url);

        return $url;
    }

    protected function _checkUrl($url)
    {
        try {
            if (is_array($url)) {
                $url = Router::url($url);
            }
        } catch (MissingRouteException $ex) {
            $url = false;
        }

        return $url;
    }
}
