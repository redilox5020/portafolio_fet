<?php

namespace App\Helpers;

class HtmlMinifier
{
    public static function minify($html)
    {
        $html = preg_replace('/>\s+</', '><', $html);
        $html = preg_replace('/\s+/', ' ', $html);
        return trim($html);
    }
}
