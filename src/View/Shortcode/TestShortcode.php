<?php
declare(strict_types=1);

namespace Content\View\Shortcode;

class TestShortcode extends Shortcode
{
    public function __invoke($name, $params, $content)
    {
        return "I'm a test <strong>short code :)</strong> with content $content";
    }
}
