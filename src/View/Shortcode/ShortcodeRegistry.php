<?php
declare(strict_types=1);

namespace Content\View\Shortcode;

use Cake\Core\App;
use Cake\View\View;

/**
 * Class ShortcodeRegistry
 * @package Content\View\Shortcode
 */
class ShortcodeRegistry
{
    /**
     * @var array Map of registered shortcodes
     */
    protected $_shortcodes = [];

    /**
     * @var \Cake\View\View
     */
    protected $_view;

    /**
     * ShortcodeRegistry constructor.
     * @param View $view
     * @param array $shortcodes
     */
    public function __construct(View $view, array $shortcodes = [])
    {
        $this->_view = $view;
        $this->_shortcodes = $shortcodes;
    }

    /**
     * @param string $shortcode
     * @param callable $callable
     * @return $this
     */
    public function register(string $shortcode, $callable)
    {
        $this->_shortcodes[$shortcode] = ['className' => $callable];

        return $this;
    }

    /**
     * @param string $shortcode
     * @return callable|null
     */
    public function get(string $shortcode): ?callable
    {
        if (isset($this->_shortcodes[$shortcode])) {
            $className = $this->_shortcodes[$shortcode]['className'];
            if (is_string($className)) {
                $this->_shortcodes[$shortcode]['className'] = $this->_resolveClass($className);
            }
            return $this->_shortcodes[$shortcode]['className'];
        }

        return null;
    }

    /**
     * @param string $className
     * @return Shortcode
     */
    protected function _resolveClass(string $className): Shortcode
    {
        $class = App::className($className, 'View\Shortcode', 'Shortcode');
        return new $class($this->_view);
    }
}
