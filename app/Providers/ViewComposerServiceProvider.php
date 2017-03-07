<?php

namespace App\Providers;

use App\Utilities\FlashMessenger;
use Illuminate\Support\ServiceProvider;
use View;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Publish the plugin configuration.
     */
    public function boot()
    {
        if (!request()->ajax()) {
            View::composer(['layouts.app'], function ($view) {
                app()->make(FlashMessenger::class)->sendToJavascript();
            });

            if (!app()->runningInConsole()) {
                //View::share('property', $value);
            }
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

}
