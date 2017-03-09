<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Email activation
    |--------------------------------------------------------------------------
    |
    | If the email activation is enabled, activation email will be sent to
    | registered user. You can format email structure in view folder. You can
    | define more registration types, user object is default.
    */

    'email_activation' => [
        'user' => env('REGISTRATION_EMAIL_ACTIVATION_USER', true)
    ],

    /*
    |--------------------------------------------------------------------------
    | Instant login
    |--------------------------------------------------------------------------
    |
    | If the instant login is enabled, user is logged immediately after success
    | registration. Value is ignored, when is enabled email activation. You can
    | define more registration types, user object is default.
    */

    'instant_login' => [
        'user' => env('REGISTRATION_INSTANT_LOGIN_USER', false)
    ],
];