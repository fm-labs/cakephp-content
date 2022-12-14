<?php
declare(strict_types=1);

namespace Content\View\Shortcode;

class TestShortcode extends Shortcode
{
    /**
     * @inheritDoc
     */
    public function __invoke(string $name, array $params, ?string $content = null): string
    {
        return "I'm a test <strong>short code :)</strong> with content $content";
    }
}
