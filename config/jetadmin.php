<?php

return [
    'route-prefix' => [
        'user' => 'user',
        'administrator' => 'administrator',
    ],
    'panels' => [
        'user' => [
            'title' => 'jetadmin.panels.user',
            'permission' => 'user_access',
            'icon' => 'home',
            'route' => 'user.dashboard.index',
        ],
        'administrator' => [
            'title' => 'jetadmin.panels.administrator',
            'permission' => 'administrator_access',
            'icon' => 'wrench-screwdriver',
            'route' => 'administrator.dashboard.index',
        ],
    ]
];
