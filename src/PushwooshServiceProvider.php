<?php

/*
 * This file is part of the Laravel Pushwoosh package.
 *
 * (c) Contextmapp B.V. <support@contextmapp.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Contextmapp\Pushwoosh;

use Gomoob\Pushwoosh\Client\Pushwoosh;
use Illuminate\Support\ServiceProvider;

/**
 * ServiceProvider for Laravel applications.
 */
class PushwooshServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/pushwoosh.php' => config_path('pushwoosh.php'),
        ]);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/pushwoosh.php', 'pushwoosh');

        $this->app->singleton(PushwooshManager::class, function ($app) {
            return new PushwooshManager($app['config']['pushwoosh'], $app[PushwooshFactory::class]);
        });

        $this->app->singleton(PushwooshFactory::class, function () {
            return new PushwooshFactory();
        });

        $this->app->singleton(Pushwoosh::class, function ($app) {
            return $app[PushwooshManager::class]->application();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [
            PushwooshManager::class,
            PushwooshFactory::class,
            Pushwoosh::class,
        ];
    }
}
