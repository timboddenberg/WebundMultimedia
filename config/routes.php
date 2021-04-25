<?php

return [
    'index' => [
        'class' => 'IndexController',
        'action' => 'loadIndex',
        'route' => '/'
    ],
    'search' => [
        'class' => 'SearchController',
        'action' => 'search',
        'route' => '/search'
    ],
    'create' => [
        'class' => 'AccountController',
        'action' => 'loadCreator',
        'route' => '/create'
    ],
    'createUser' => [
        'class' => 'AccountController',
        'action' => 'create',
        'route' => '/create/user'
    ]
];
