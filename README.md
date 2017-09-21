# Laravel Pushwoosh

> A simple wrapper around Gomoob's [php-pushwoosh](https://github.com/gomoob/php-pushwoosh/) package for integration with the Laravel framework.

[![Version](https://img.shields.io/packagist/v/contextmapp/laravel-pushwoosh.svg)](https://packagist.org/packages/contextmapp/laravel-pushwoosh)
[![License](https://img.shields.io/packagist/l/contextmapp/laravel-pushwoosh.svg)](https://packagist.org/packages/contextmapp/laravel-pushwoosh)

## Installation

Use [Composer](https://getcomposer.org/) to pull this package in as a 
dependency.

```sh
composer require contextmapp/laravel-pushwoosh
```

If you are using Laravel 5.4 or lower, or if you have disabled package 
discovery, add the provider to the `providers` array in `config/app.php`:

```php
Contextmapp\Pushwoosh\PushwooshServiceProvider::class
```

If you want to use the `Pushwoosh` facade, you should
also add the correct alias to the `aliases` array:

```php
'Pushwoosh' => Contextmapp\Pushwoosh\Facades\Pushwoosh::class
```

## Configuration

You should publish the configuration file that is supplied with this package
to set up your Pushwoosh details.

```sh
php artisan vendor:publish --provider=Contextmapp\Pushwoosh\PushwooshServiceProvider
```

This command copies the configuration file to `config/pushwoosh.php`.

Make sure you set up the `api_token` and `application_id` of the default 
application.
