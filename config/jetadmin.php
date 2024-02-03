<?php
return [
    'name' => 'Bootstrap Admin Panel',
    'container-app' => 'container',
    'container-panel' => 'container-fluid',
    'container-admin' => 'container-fluid',
    'admin-prefix-url' => 'admin',
    'panel-prefix-url' => 'panel',
    'test-mode' => 0,
    'per-page' => 15,
    'verify_code_start' => 101010,
    'verify_code_finish' => 989898,
    'default-country' => 105,

    'home' => [
        'display-carousels' => 1,
        'count-carousels' => 5,
        'display-articles' => 1,
        'count-articles' => 5,
    ],
    'modules' => [
        'user' => true,
        'user_verify' => true,
        'user_mobile_verify' => true,
        'notification' => false,
        'content' => true,
        'support' => true,
    ]
];
