<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Authentication Guard
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication guard for your application.
    | The "web" guard is used for standard users, while the "admin" guard is
    | used for admin authentication.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Each authentication guard is defined here. Laravel uses session-based
    | authentication and Eloquent user providers by default.
    |
    */

   'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'admin' => [
        'driver' => 'session',
        'provider' => 'admins', // Must match providers key
    ],
],
    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Each authentication guard requires a user provider. These providers
    | determine how users are retrieved from your database.
    |
    */

   'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],

    'admins' => [  // ✅ Add this admin provider
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class,
    ],
],


    /*
    |--------------------------------------------------------------------------
    | Password Reset Configuration
    |--------------------------------------------------------------------------
    |
    | These settings define how password resets function for each user type.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60, // Password reset link expires in 60 minutes
            'throttle' => 60, // Can request reset once every 60 seconds
        ],

        'admins' => [
            'provider' => 'admins',
            'table' => 'admin_password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | The number of seconds before re-confirming passwords for security.
    |
    */

    'password_timeout' => 10800, // 3 hours

];
