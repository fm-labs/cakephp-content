<?php
declare(strict_types=1);

namespace Content\View\Shortcode;

class MathjaxShortcode extends Shortcode
{
    public function __invoke($name, $params, $content)
    {
        $this->_view->loadHelper('Content.Mathjax');

        $params += ['exp' => null];

        return sprintf("$ %s $", $params['exp']);
    }
}
