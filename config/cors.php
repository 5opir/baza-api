<?php

return [
    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    //'allowed_origins' => [
    //    'https://aesthetic-parfait-fe1d13.netlify.app',
    //    'http://localhost:3000',
    //],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];