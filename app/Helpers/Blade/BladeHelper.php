<?php

namespace App\Helpers\Blade;

use Illuminate\Support\Facades\Route;

class BladeHelper
{
    /**
     * Receives an array of <key: string, value: string> and returns the class that matches the current route.
     *
     * @param string $routeName
     * @param array $array
     * @param bool $disabled
     * @return void
     */
    public static function styledLink(string $routeName, array $array, bool $disabled = false): void
    {
        $class = Route::is($routeName)
            ? $array[true]
            : $array[false];

        $route = $disabled
            ? '#'
            : route($routeName);

        echo 'href="'.$route.'" class="'.$class.'"';
    }
}
