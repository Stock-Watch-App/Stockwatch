<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Supabase Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Supabase integration
    |
    */

    'url' => env('SUPABASE_URL'),
    'key' => env('SUPABASE_ANON_KEY'),
    'service_key' => env('SUPABASE_SERVICE_KEY'),
    
    /*
    |--------------------------------------------------------------------------
    | Database Configuration
    |--------------------------------------------------------------------------
    |
    | Direct database connection settings for PostgreSQL
    |
    */
    
    'database' => [
        'host' => env('SUPABASE_DB_HOST'),
        'port' => env('SUPABASE_DB_PORT', 5432),
        'database' => env('SUPABASE_DB_DATABASE'),
        'username' => env('SUPABASE_DB_USERNAME'),
        'password' => env('SUPABASE_DB_PASSWORD'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for Supabase Auth integration
    |
    */
    
    'auth' => [
        'jwt_secret' => env('SUPABASE_JWT_SECRET'),
        'providers' => [
            'google' => env('SUPABASE_GOOGLE_ENABLED', false),
            'facebook' => env('SUPABASE_FACEBOOK_ENABLED', false),
            'twitter' => env('SUPABASE_TWITTER_ENABLED', false),
            'discord' => env('SUPABASE_DISCORD_ENABLED', false),
            'twitch' => env('SUPABASE_TWITCH_ENABLED', false),
            'reddit' => env('SUPABASE_REDDIT_ENABLED', false),
        ],
    ],

];