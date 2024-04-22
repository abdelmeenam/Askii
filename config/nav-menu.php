<?php

use App\Models\Role;
use App\Models\Tag;
use App\Models\User;

return [
    [
        'title' => 'Dashboard',
        'route' => 'dashboard',
        'icon' => 'fas fa-tachometer-alt',
    ],
    [
        'title' => 'Admins',
        'route' => 'users.index',
        'icon' => 'fas fa-users',
        'ability' => ['view', User::class]
    ],
    [
        'title' => 'Tags',
        'route' => 'tags.index',
        'icon' => 'fas fa-tags',
        'ability' => ['view', Tag::class]

    ],
    [
        'title' => 'Roles',
        'route' => 'roles.index',
        'icon' => 'fas fa-user-shield',
        'ability' => ['view', Role::class]
    ]
];
