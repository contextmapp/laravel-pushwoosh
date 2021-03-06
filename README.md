# Laravel Pushwoosh

> A simple wrapper around Gomoob's [php-pushwoosh](https://github.com/gomoob/php-pushwoosh/) package for integration with the Laravel framework.

[![Build Status](https://travis-ci.org/contextmapp/laravel-pushwoosh.svg?branch=master)](https://travis-ci.org/contextmapp/laravel-pushwoosh)
[![Coverage Status](https://coveralls.io/repos/github/contextmapp/laravel-pushwoosh/badge.svg?branch=master)](https://coveralls.io/github/contextmapp/laravel-pushwoosh?branch=master)
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

## Usage

You can use the wrapper to interact with the Pushwoosh SDK directly, or, you could add support for Pushwoosh to your
[Laravel notifications](https://laravel.com/docs/notifications).

### Laravel Notifications

If you are using Laravel's notification system, you can add `'pushwoosh'` to the `via()` response of a notification.
The channel name is also available as a class constant on the `Contextmapp\Pushwoosh\PushwooshChannel` class.
The notification class is expected to implement the `Contextmapp\Pushwoosh\Contracts\PushwooshNotification` contract.
Your notifiable classes should implement the `Contextmapp\Pushwoosh\Contracts\PushwooshNotifiable` contract.
