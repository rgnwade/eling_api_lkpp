<?php

return [
    'defaults' => [
        'guard' => 'api',
        // 'passwords' => 'users',
    ],

    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'secret-user',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => \App\Models\UserLkpp::class
        ],
        'secret-user' => [
            'driver' => 'secret-key',
            // 'model' => \App\Models\DetailsLkpp::class
        ]
    ]
];