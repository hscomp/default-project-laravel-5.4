<?php

namespace App\Providers;

use Form;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerFormCompoments();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function registerFormCompoments()
    {
        Form::component('textField', 'components.form.text', ['name', 'label', 'value' => null, 'attributes' => [], 'parentClass' => [], 'parentAttributes' => []]);
        Form::component('textareaField', 'components.form.textarea', ['name', 'label', 'value' => null, 'attributes' => [], 'parentClass' => [], 'parentAttributes' => []]);
        Form::component('passwordField', 'components.form.password', ['name', 'label', 'attributes' => [], 'parentClass' => [], 'parentAttributes' => []]);
        Form::component('submitField', 'components.form.submit', ['label', 'attributes' => [], 'parentClass' => [], 'parentAttributes' => []]);
    }
}
