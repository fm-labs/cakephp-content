<?php
declare(strict_types=1);

namespace Content\View\Shortcode;

class EchoShortcode extends Shortcode
{
    /**
     * @inheritDoc
     */
    public function __invoke(string $name, array $params, ?string $content = null): string
    {
        $params = array_merge(['color' => 'auto', 'repeat' => 1, 'message' => null], $params);
        $content = $params['message'] ?? $content;
        $out = '';
        $repeat = min((int)$params['repeat'], 100);
        for ($i = 0; $i < $repeat; $i++) {
            $out .= sprintf('<span style="color:%s">%s</span>', $params['color'], $content) . '<br />';
        }

        return $out;
    }
}
