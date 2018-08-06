# Laravel Route Helpers [![Build Status](https://travis-ci.org/n7olkachev/laravel-route-helpers.svg?branch=master)](https://travis-ci.org/n7olkachev/laravel-route-helpers)

Rails like route helpers for your Laravel application.

## Why?

Fully autocompletable routes. Less typing, less errors.

## Examples

```php
// routes.php

\Route::group(['prefix' => '/admin', 'as' => 'admin.'], function () {
    \Route::get('/')->name('home');
    \Route::group(['prefix' => '/users', 'as' => 'users.'], function () {
        \Route::get('/{user}')->name('show');
    });
});
```

This package will generate special helpers for you, so you can generate urls like:

```php
admin_home_url();
admin_users_show_url(['user' => $user->id]);
```

It's totally IDE friendly, so after typing `admin_` you'll see both helpers as suggestions!

## Installation

You can install the package via composer:

``` bash
composer require n7olkachev/laravel-route-helpers
```

To create helpers run:

```bash
php artisan route:helpers
```

Then you just need to add generated file to composer autoload section, like so:

```json
// composer.json
...
"autoload": {
    "files": [
        "storage/route-helpers/cache.php"
    ],
}
...
```

The path of generated file can be changed via config.

## Testing

``` bash
$ composer test
```

## Credits

- [Nikita Tolkachev](https://github.com/n7olkachev)

## Sponsored by

https://websecret.by/en

Web agency based in Minsk, Belarus

## License

The MIT License (MIT)
