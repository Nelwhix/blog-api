<?php

return [
    'paths' => ['*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:3000')],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['XMLHttpRequest', 'x-xsrf-token', 'x-requested-with', 'content-type'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
