<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('str_pad', [$this, 'strPad']),
            new TwigFilter('parse_icons', [$this, 'parseIconsFilter'], ['is_safe' => ['html']])
        ];
    }

    public function strPad(string $str, int $length, string $padStr, int $padType = STR_PAD_RIGHT): string
    {
        return str_pad($str, $length, $padStr, $padType);
    }

    public function parseIconsFilter(string $text): string
    {
        $fontwesomeStyle = 's';

        return preg_replace_callback(
            '/\.([a-z]+)-([a-z0-9+-]+)/',
            function ($matches) use ($fontwesomeStyle) {
                if ('icon' == $matches[1]) {
                    $matches[1] = 'fa'.substr($fontwesomeStyle, 0, 1);
                } elseif ('brand' == $matches[1]) {
                    $matches[1] = 'fab';
                }

                return sprintf('<i class="%1$s fa-%2$s"></i> ', $matches[1], $matches[2]);
            },
            $text
        );
    }
}
