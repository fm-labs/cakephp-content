<?php

namespace Content\View\Shortcode;

use Cake\Core\App;
use Cake\View\View;

class ShortcodeRegistry
{
    /**
     * @var array Map of registered shortcodes
     */
    protected $_shortcodes = [];

    /**
     * @var View
     */
    protected $_view;

    public function __construct(View $view)
    {
        $this->_view = $view;
    }

    public function register($shortcode, $callable)
    {
        if (is_string($callable)) {
            $callable = $this->_resolveShortcode($callable);
        }
        $this->_shortcodes[$shortcode] = ['callable' => $callable];
    }

    public function get($shortcode)
    {
        if (isset($this->_shortcodes[$shortcode])) {
            return $this->_shortcodes[$shortcode]['callable'];
        }

        return null;
    }

    protected function _resolveShortcode($className)
    {
        $class = App::className($className, 'View\Shortcode', 'Shortcode');
        $obj = new $class($this->_view);

        return $obj;
    }
}
