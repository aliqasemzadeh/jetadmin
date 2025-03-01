<?php

return [
    'route-prefix' => [
        'user' => 'user',
        'administrator' => 'administrator',
    ],
    'panels' => [
        'user' => [
            'title' => 'jetadmin.panels.user',
            'icon' => 'home',
            'route' => 'user.dashboard.index',
        ],
        'administrator' => [
            'title' => 'jetadmin.panels.administrator',
            'icon' => 'wrench-screwdriver',
            'route' => 'administrator.dashboard.index',
        ],
    ]
];
