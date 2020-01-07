<?php

namespace Content\View\Shortcode;

use Cake\View\View;

abstract class Shortcode
{
    /**
     * @var View
     */
    protected $_view;

    public function __construct(View $view)
    {
        $this->_view = $view;
    }

    abstract public function __invoke($name, $params, $content);
}
