<?php

namespace App\Providers;

use App\Utilities\FlashMessenger;
use Illuminate\Support\ServiceProvider;

class FlashMessengerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FlashMessenger::class, function ($app) {

            $notificationsConfig = config('flashmessengernotifications');

            $alertsConfig = config('flashmessengeralerts');

            return new FlashMessenger($notificationsConfig, $alertsConfig);
        });
    }

    /**
     * Publish the plugin configuration.
     */
    public function boot()
    {
    }

}
