
This package is a theme management package for Laravel with a set of tools to help you easily and quickly build a theme management system for your laravel based project. The goal of this package is to remain as flexible as possible and provide a way to use it internally.

## Supports

| Version | Laravel Version | PHP Version |
|---- |----|----|
| 1.0 | 5.5 | 7.1, 7.2 |

This package supports **Blade**, **PHP** and **Twig** template engines.

## Features

This package provides tools for the following:

- Change themes on runtime.
- Get theme meta infomations.
- Support fallback templates.
- Preview a theme using URL query parameter.
- Extend the theme functionalities.


##Installation

To get started with this package, add the following lines to your `composer.json` file and run `composer update`.

```php
"require": {
	"roland/laravel-theme-manager": "~1.0"
}
```

Or, Run `composer require` from your terminal to install the package via the Composer package manager:


```shell
composer require roland/laravel-theme-manager
```

## Service Provider & Facade

If you disabled the laravel's automatic package discovery feature these will help you.

```php
// Service Provider
Roland\Theme\ThemeServiceProvider::class,

// Facade
'Theme' => Roland\Theme\Facades\Theme::class,
```

## Publish Configuration

Much of the package comes preconfigured, so that you can start building your API right away after you installed. You can either use `.env` file or `config/themes.php` to configure most of the package.

You also can publish the configuration file with the following Artisan command:

```shell
php artisan vendor:publish --provider="Roland\Theme\ThemeServiceProvider"
```

#### Enable or disable the package

You can set the value to true or false to enable or disable the package.

```array
enable => true,
```

#### Default theme provider

Here you may specify which of the theme provider connections below you wish to use as your default provider.

> Available drivers: "file"

```array
'driver' => 'file',
```

#### Default theme

Here you may specify the default theme.

```array
'theme' => 'default',
```

#### Themes path

Here you may specify a path for themes.

```array
'path' => base_path('resources/themes'),
```

##Basic Usage
### Create a theme

To create a theme, first, add a `themes` folder to the `resources` folder of your app.

Inside the `themes` folder, any folder you create with a `theme.json` the file represents a theme.

The folder structure will look like this:

```
resources
└── themes
    ├── [Theme folder]
    |   └── theme.json
    |   └── welcome.blade.php
    |
    └── [Another theme folder]
        └── theme.json
        └── welcome.blade.php
```

### Theme information file (theme.json)

This package only recognize a folder as a theme when a file called `theme.json` exists.

This is the basic structure of the theme information file. You can add any number of key, value pairs to the file and retrieve later.

```json
{
	"theme_title": "Default theme",
	"theme_description": "Default theme for the theme package",
	"theme_uri": "https://domain.com",
	"theme_version": "1.0.0",
	"theme_license": "The MIT License (MIT)",
	"theme_tags": "default, simple",
	"theme_type": "web",
	"author_name": "Jon Deep",
	"author_email": "JonDeep@domain.com",
	"author_uri": "https://domain.com"
}

```

### Basic methods

To simply display a view (welcome) using the current theme. Otherwise fallback (index).

	return Theme::view(['welcome', 'index']);

To set the current theme on runtime.

	return Theme::use('mytheme')->view(['welcome']);
	
To set the current theme and update the default config theme.

	Theme::set('mytheme');

Add `theme` parameter to preview a theme on runtime.

	https://localhost/?theme=mytheme

You also can change the theme provider at runtime.

	return Theme::driver('file')->view(['welcome']);

To check whether a theme exists or not.

	Theme::exists('mytheme');
	
To check all themes.

	Theme::all();
Ps: it will return a json with all the installed themes

Return theme's information as `json`.

```php
// Return default theme's info
return Theme::info();

// Return provided theme's info
return Theme::info('mytheme');
```

Pass data to views.

```php
// with() method
return Theme::with(['name' => 'Victoria'])->view(['welcome']);

// Alternative way
return Theme::view(['welcome'], ['name' => 'Victoria']);
```
##Advanced
We allow you extend or add more theme providers using `extend` function on runtime without a hassle.

```php
	Theme::extend('riak', function($app)
	{
		return 'Riak theme driver';
	});

	// Chnage the theme driver from route
	return Theme::driver('riak');
```

Configure Middleware 

- Publish the package: ````php artisan vendor:publish````
- On ```Http/kernel.php``` add to protected ``'theme' => \App\Http\Middleware\CheckTheme::class,``
- Use middleware on the routes

 Route example:
 `` Route::get('/', ['uses' => 'TestController@home'])->middleware('theme:ThemeName');``
 
 ps. using the theme will allow you to use the deafult Laravel ```view()``` with the currect theme :) 

## License
This package is licensed under the [The MIT License (MIT)](https://opensource.org/licenses/MIT).
