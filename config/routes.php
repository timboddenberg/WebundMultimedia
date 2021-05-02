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
    'displayRegister' => [
        'class' => 'AccountController',
        'action' => 'displayRegister',
        'route' => '/user/register'
    ],
    'registerUser' => [
        'class' => 'AccountController',
        'action' => 'register',
        'route' => '/user/performregister'
    ],
    'login' => [
        'class' => 'AccountController',
        'action' => 'displayLogin',
        'route' => '/user/login'
    ],
    'performLogin' => [
        'class' => 'AccountController',
        'action' => 'performLogin',
        'route' => '/user/login/performlogin'
    ],
    'displayProduct' => [
        'class' => 'ProductController',
        'action' => 'displayProduct',
        'route' => '/product'
    ],
    'displayProductAdministration' => [
        'class' => 'ProductController',
        'action' => 'displayProductAdministration',
        'route' => '/product/administration'
    ],
    'addProduct' => [
        'class' => 'ProductController',
        'action' => 'addProduct',
        'route' => '/product/add'
    ],
    'deleteProduct' =>[
        'class' => 'ProductController',
        'action' => 'deleteProduct',
        'route' => '/product/delete'
    ]


];
