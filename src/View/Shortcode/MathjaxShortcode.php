<?php
declare(strict_types=1);

namespace Content\View\Shortcode;

class MathjaxShortcode extends Shortcode
{
    /**
     * @inheritDoc
     */
    public function __invoke(string $name, array $params, ?string $content = null): string
    {
        $this->_view->loadHelper('Sugar.Mathjax');

        $params += ['exp' => null];

        return sprintf("$ %s $", $params['exp']);
    }
}
