<?php

namespace Content\View\Helper;

use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\View\Helper;
use Content\View\Shortcode\ShortcodeRegistry;

class ShortcodeHelper extends Helper
{
    /**
     * @var ShortcodeRegistry
     */
    protected $_registry;

    public function initialize(array $config)
    {
        $this->_registry = new ShortcodeRegistry($this->_View);

        $this->add('echo', 'Content.Echo');
        $this->add('test_short_code', 'Content.Test');

        EventManager::instance()->dispatch(new Event('View.Shortcode.init', null, ['registry' => $this->_registry]));
    }

    public function add($name, $callable)
    {
        $this->_registry->register($name, $callable);
    }

    public function afterRender(Event $event)
    {
        /* @var \Cake\View\View $view */
        $view = $event->getSubject();
        //$content = $view->Blocks->get('content');
        $content = $view->fetch('content');

        $content = $this->renderShortCodes($content);
        $view->assign('content', $content);
    }

    public function renderShortCodes($html)
    {
        $callback = function ($matches) {
            //debug($matches);

            $shortcode = $closecode = $content = null;
            $args = "";
            if (count($matches) == 2) {
                list($match, $shortcode) = $matches;
            } elseif (count($matches) == 3) {
                list($match, $shortcode, $args) = $matches;
            } elseif (count($matches) == 4) {
                list($match, $shortcode, $args, $content) = $matches;
            } elseif (count($matches) == 5) {
                list($match, $shortcode, $args, $content, $closecode) = $matches;
            } else {
                return $matches[0];
            }

            if ($closecode !== null && $shortcode != $closecode) {
                throw new \Exception("Shortcode '$shortcode' has not been closed");
            }

            // parse shortcode params
            $args = explode(" ", trim($args));
            $params = [];
            array_walk($args, function ($v) use (&$params) {
                $attr = explode("=", $v);
                if (count($attr) == 2) {
                    list($key, $val) = $attr;
                    $val = trim(trim($val, "\""));
                    $params[$key] = $val;
                }
            });

            // render shortcode
            $rendered = $this->doShortcode($shortcode, $params, $content);
            if ($rendered/* !== null*/) {
                return $rendered;
            }

            return 'Unknown Shortcode: ' . $match;
        };

        // short code with body: [short_code_name arg1="foo" args2="bar"]custom content[/short_code_name]
        $pattern = '/\[([\w]+)\s?([\w\s\"\=]+)?\](.*)\[\/([\w]+)\]/m';
        $html = preg_replace_callback($pattern, $callback, $html);

        // short code without body: [short_code_name arg1="foot" arg2="bar"/]
        $pattern2 = '/\[([\w]+)\s?([\w\s\"\=]+)?\/\]/m';
        $html = preg_replace_callback($pattern2, $callback, $html);

        return $html;
    }

    protected function doShortcode($shortcode, $params = [], $content = "")
    {
        $handler = $this->_registry->get($shortcode);

        if ($handler) {
            return call_user_func($handler, $shortcode, $params, $content);
        }

        // recursively render short codes by default
        //return $this->renderShortCodes($content);

        return null;
    }
}
