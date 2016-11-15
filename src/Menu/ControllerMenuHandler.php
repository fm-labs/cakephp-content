<?php
namespace Content\Menu;

use Exception;

class ControllerMenuHandler extends BaseMenuHandler implements MenuHandlerInterface
{
    public function getViewUrl()
    {
        $controller = explode('::', $this->item->url);
        $action = 'index';
        $params = [];
        if (count($controller) == 2) {
            list($controller, $action) = $controller;

            $action = explode(':', $action);
            if (count($action) == 2) {
                list($action, $args) = $action;

                $args = explode(',', $args);
                array_walk($args, function ($val, $idx) use (&$params) {
                    $val = trim($val);
                    if (preg_match('/^[\{](.*)[\}]$/', $val, $matches)) {
                        $val = $this->get($matches[1]);
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
        $url = ['prefix' => false, 'plugin' => $plugin, 'controller' => $controller, 'action' => $action];
        $url = array_merge($params, $url);
        return $url;
    }

    public function getAdminUrl()
    {
        $url = $this->getViewUrl();
        $url['admin'] = true;
        return $url;
    }
}