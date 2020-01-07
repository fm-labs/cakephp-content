<?php

namespace Content\View\Shortcode;

class EchoShortcode extends Shortcode
{
    public function __invoke($name, $params, $content)
    {
        $params = array_merge(['color' => null, 'repeat' => 1], $params);
        $out = "";
        for ($i = 0; $i < $params['repeat']; $i++) {
            $out .= $i . ":" . sprintf("<span style=\"color:%s\">%s</span>", $params['color'], $content) . "<br />";
        }

        return $out;
    }
}
