<?php
declare(strict_types=1);

namespace Content\View\Shortcode;

use Cake\View\View;

abstract class Shortcode
{
    /**
     * @var \Cake\View\View
     */
    protected $_view;

    public function __construct(View $view)
    {
        $this->_view = $view;
    }

    abstract public function __invoke($name, $params, $content);
}
