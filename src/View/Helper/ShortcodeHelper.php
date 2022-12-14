<?php
declare(strict_types=1);

namespace Content\View\Helper;

use Cake\View\Helper;
use Content\View\Shortcode\ShortcodeRegistry;
use Cupcake\Cupcake;

/**
 * Class ShortcodeHelper
 *
 * @package Content\View\Helper
 */
class ShortcodeHelper extends Helper
{
    /**
     * @var \Content\View\Shortcode\ShortcodeRegistry
     */
    protected $_registry;

    /**
     * @param array $config
     */
    public function initialize(array $config): void
    {
        $shortcodes = Cupcake::doFilter('content_shortcodes_init', []);
        $this->_registry = new ShortcodeRegistry($this->_View, $shortcodes);
    }

    /**
     * Register new shortcode at runtime.
     *
     * @param string $name
     * @param $callable
     */
    public function add(string $name, $callable)
    {
        $this->_registry->register($name, $callable);
    }

//    public function afterLayout(Event $event)
//    {
//        /** @var \Cake\View\View $view */
//        $view = $event->getSubject();
//        //$content = $view->Blocks->get('content');
//        $content = $view->fetch('content');
//
//        $content = $this->renderShortCodes($content);
//        $view->assign('content', $content);
//    }

    /**
     * Parse shortcodes in html text.
     *
     * @param string $html
     * @return string
     */
    public function renderShortCodes(string $html): string
    {
        $pattern = "/\[([\w]+)\s?(.*)?(\/)?\]/m"; // matches [foo...]

        $paramsParser = function ($paramsStr) {
            $pattern = '/([\w]+)=\"([^"]+)\"/'; // matches foo="bar"
            preg_match_all($pattern, $paramsStr, $matches);

            //debug($paramsStr);
            //debug($matches);
            $params = [];
            for ($i = 0; $i < count($matches[0]); $i++) {
                $key = $matches[1][$i];
                $val = $matches[2][$i];
                $params[$key] = $val;
            }

            return $params;
        };

        $callback = function ($matches) use ($paramsParser) {
            //debug($matches);
            $shortcode = $closecode = null;
            $content = $args = '';
            if (count($matches) == 2) {
                [$match, $shortcode] = $matches;
            } elseif (count($matches) == 3) {
                [$match, $shortcode, $args] = $matches;
            } else {
                $match = $matches[0];
            }

            // parse shortcode params and handle shortcode
            $params = $paramsParser($args);
            $rendered = $this->doShortcode($shortcode, $params, $content);
            if ($rendered) {
                return $rendered;
            }

            return $match;
        };
        $html = preg_replace_callback($pattern, $callback, $html);

        return $html;
    }

    /**
     * @param string $shortcode
     * @param array $params
     * @param string $content
     * @return mixed|null
     */
    protected function doShortcode(string $shortcode, array $params = [], string $content = '')
    {
        $handler = $this->_registry->get($shortcode);
        if ($handler) {
            return call_user_func($handler, $shortcode, $params, $content);
        }

        // recursively render short codes by default
        //return $this->renderShortCodes($content);

        return null;
    }

    /**
     * @param $html
     * @return string|string[]|null
     * @throws \Exception
     * @deprecated
     */
    public function renderShortCodesOld($html)
    {
        $callback = function ($matches) {
            //debug($matches);

            $shortcode = $closecode = $content = null;
            $args = '';
            if (count($matches) == 2) {
                [$match, $shortcode] = $matches;
            } elseif (count($matches) == 3) {
                [$match, $shortcode, $args] = $matches;
            } elseif (count($matches) == 4) {
                [$match, $shortcode, $args, $content] = $matches;
            } elseif (count($matches) == 5) {
                [$match, $shortcode, $args, $content, $closecode] = $matches;
            } else {
                return $matches[0];
            }

            if ($closecode !== null && $shortcode != $closecode) {
                throw new \Exception("Shortcode '$shortcode' has not been closed");
            }

            // parse shortcode params
            $args = explode(' ', trim($args));
            $params = [];
            array_walk($args, function ($v) use (&$params) {
                $attr = explode('=', $v);
                if (count($attr) == 2) {
                    [$key, $val] = $attr;
                    $val = trim(trim($val, '"'));
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
        //$pattern = '/\[([\w]+)\s?([\w\s\"\=]+)?\](.*)\[\/([\w]+)\]/m';
        $pattern = '/\[([\w]+)\s?(.*)\](.*)\[\/([\w]+)\]/m';
        $html = preg_replace_callback($pattern, $callback, $html);

        // short code without body: [short_code_name arg1="foot" arg2="bar"/]
        $pattern2 = '/\[([\w]+)\s?([\w\s\"\=]+)?\/\]/m';
        $html = preg_replace_callback($pattern2, $callback, $html);

        return $html;
    }
}
