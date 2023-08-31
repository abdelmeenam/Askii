<?php

return[
    [
        'title'=>'Dashboard',
        'route'=>'dashboard',
        'icon'=>'fas fa-tachometer-alt',
    ],
    [
        'title'=>'Users',
        'route'=>'users.index',
        'icon'=>'fas fa-users',
    ],
  [
      'title'=>'Tags',
      'route'=>'tags.index',
      'icon'=>'fas fa-tags',
      'ability'=>['view' ,Tag::class]
  ],
    [
        'title'=>'Roles',
        'route'=>'roles.index',
        'icon'=>'fas fa-user-shield',
        'ability'=>['view' ,Role::class]
    ]
];
