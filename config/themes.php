<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable or disable the package
    |--------------------------------------------------------------------------
    |
    | Set the value to true or false to enable or disable the package.
    |
    */
    'enable' => env('THEMES_ENABLE', true),

    /*
    |--------------------------------------------------------------------------
    | Default theme provider
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the theme provider connections
    | below you wish to use as your default provider.
    |
    | Available drivers: "file"
    |
    */
    'driver' => env('THEMES_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Default theme
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default theme.
    |
    */
    'theme' => env('THEMES_THEME', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Themes path
    |--------------------------------------------------------------------------
    |
    | Specify a path for themes.
    |
    */
    'path' => base_path('resources/themes'),

];
