<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Publish the plugin configuration.
     */
    public function boot()
    {
        Validator::extend('name_characters', function($attribute, $value, $parameters, $validator) {
            $pattern = "/^([ \x{00C0}-\x{01FF}a-zA-Z'\-])+$/u";
            return preg_match($pattern, $value);
        });
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
