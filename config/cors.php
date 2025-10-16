<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    */

    // Paths that should accept CORS requests
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Allowed HTTP methods for CORS
    'allowed_methods' => ['*'],

    // Allowed origins (your frontend dev server)
    'allowed_origins' => ['http://localhost:5173'],

    // Patterns to match allowed origins
    'allowed_origins_patterns' => [],

    // Allowed headers
    'allowed_headers' => ['*'],

    // Headers exposed to the browser
    'exposed_headers' => [],

    // Maximum age (seconds) for preflight requests
    'max_age' => 0,

    // Whether cookies/auth credentials are supported
    'supports_credentials' => true,
];
