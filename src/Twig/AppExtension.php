<?php 

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('parse_icons', [$this, 'parseIconsFilter'], ['is_safe' => ['html']])
        ];
    }

    public function parseIconsFilter(string $text): string
    {
        $fontwesomeStyle = 's';

        return preg_replace_callback(
            '/\.([a-z]+)-([a-z0-9+-]+)/',
            function ($matches) use ($fontwesomeStyle) {
                if ('icon' == $matches[1]) {
                    $matches[1] = 'fa'.$fontwesomeStyle;
                } elseif ('brand' == $matches[1]) {
                    $matches[1] = 'fab';
                }

                return sprintf('<i class="%1$s fa-%2$s"></i> ', $matches[1], $matches[2]);
            },
            $text
        );
    }
}