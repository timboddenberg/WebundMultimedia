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
        'class' => 'CreatorController',
        'action' => 'loadCreator',
        'route' => '/create'
    ],
    'createUser' => [
        'class' => 'CreatorController',
        'action' => 'create',
        'route' => '/create/user'
    ]
];
