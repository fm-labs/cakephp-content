<?php
namespace Content\Page;

use Cake\Controller\Controller;
use Cake\Core\Plugin;
use Cake\Datasource\EntityInterface;
use Exception;

class ControllerPageType extends AbstractPageType
{
    protected function _parseUrl()
    {
        $page =& $this->page;
        $controller = explode('::', $page->redirect_controller);
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

        $url = compact('plugin', 'controller', 'action');
        $url = array_merge($params, $url);
        return $url;
    }

    public function getUrl()
    {
        $url = $this->_parseUrl();
        $url['prefix'] = false;
        $url['page_id'] = $this->page->id;

        return $url;
    }

    public function isPublished()
    {
        $url = $this->_parseUrl();
        if ($url['plugin'] && Plugin::loaded($url['plugin']) === false) {
            return false;
        }
        return parent::isPublished();
    }

    public function execute(Controller &$controller)
    {
        $controller->redirect($this->page->redirect_controller_url, $this->page->redirect_status);
        return false;
    }
}