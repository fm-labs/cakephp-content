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

    /**
     * Shortcode constructor.
     *
     * @param \Cake\View\View $view
     */
    public function __construct(View $view)
    {
        $this->_view = $view;
    }

    /**
     * @param string $name Shortcode name
     * @param array $params Shortcode params
     * @param string|null $content Shortcode body contents (optional)
     * @return string
     */
    abstract public function __invoke(string $name, array $params, ?string $content = null): string;
}
