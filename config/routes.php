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
    'logout' => [
        'class' => 'AccountController',
        'action' => 'displayLogout',
        'route' => '/user/logout'
    ],
    'performLogout' => [
        'class' => 'AccountController',
        'action' => 'performLogout',
        'route' => '/user/logout/performLogout'
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
    ],
    'displayAddComment' =>[
        'class' => 'ProductController',
        'action' => 'displayAddComment',
        'route' => '/product/addComment'
    ],
    'addComment' =>[
        'class' => 'ProductController',
        'action' => 'addComment',
        'route' => '/product/addComment/submit'
    ],
    'removeUser'=>[
        'class' => 'AccountController',
        'action' => 'displayUserRemover',
        'route' => '/user/remove'
    ],
    'performUserRemove'=>[
        'class' => 'AccountController',
        'action' => 'performRemove',
        'route' => '/user/remove/perform'
    ],
    'displayAllProducts'=>[
        'class' => 'ProductController',
        'action' => 'displayAllProducts',
        'route' => '/allProducts/all'
    ],
    'addProductToShoppingCart'=>[
        'class' => 'ShoppingCartController',
        'action'=> 'addProductToShoppingCart',
        'route' => '/product/addtoshoppingcart'
    ],
    'displayShoppingCart'=>[
        'class' => 'ShoppingCartController',
        'action' => 'displayShoppingCart',
        'route' => '/shoppingcart'
    ],
    'deleteProductFromShoppingCart' =>[
        'class' => 'ShoppingCartController',
        'action' => 'deleteProductFromShoppingCart',
        'route' => '/shoppingcart/deleteproduct'
    ],
    'rateProduct' =>[
        'class' => 'ProductController',
        'action' => 'rateProduct',
        'route' => '/product/rate'
    ],
    'showEditProductInDatabase' =>[
        'class'=>'ProductController',
        'action'=>'displayEditProductInDatabase',
        'route'=>'/product/edit'
    ],
    'editProductInDatabase'=>[
        'class'=>'ProductController',
        'action'=>'editProductInDatabase',
        'route'=>'/admin/product/edit'
    ],
    'increaseProductInShoppingCart'=>[
        'class'=>'ShoppingCartController',
        'action'=>'increaseProductInShoppingCart',
        'route'=>'/shoppingcart/increaseProductInShoppingCart'
    ],
    'decreaseProductInShoppingCart'=>[
        'class'=>'ShoppingCartController',
        'action'=>'decreaseProductInShoppingCart',
        'route'=>'/shoppingcart/decreaseProductInShoppingCart'
    ],
    'ratedProducts' =>[
        'class' => 'ProductController',
        'action' => 'displayRatedProducts',
        'route' => '/ratedProducts'
    ],
    'deleteRating' =>[
        'class' => 'ProductController',
        'action' => 'deleteRatedProduct',
        'route' => '/deleteRating'
    ],
    'userAdministration' => [
        'class' => 'AccountController',
        'action' => 'displayUserAdministration',
        'route' => '/user/administration'
    ],
    'userAdministrationHtml' => [
        'class' => 'AccountController',
        'action' => 'getUserAdministrationColumnHtml',
        'route' => '/user/administration/getAdministrationHtml'
    ],
    'deleteUserById' => [
        'class' => 'AccountController',
        'action' => 'removeUserById',
        'route' => '/user/administration/removeUserById'
    ],
    'UpdateAdminStatusById' => [
        'class' => 'AccountController',
        'action' => 'updateUserAdminStatusById',
        'route' => '/user/administration/updateUserAdminStatusById'
    ],
    'displayActivityOverview' => [
        'class' => 'ActivityController',
        'action' => 'displayActivityOverview',
        'route' => '/activity/display'
    ],
    'getAllProductsAsOptions' => [
        'class' => 'ActivityController',
        'action' => 'getAllProductFromDatabaseAsOptions',
        'route' => '/activity/getProductOptions'
    ],
    'getActivityData' => [
        'class' => 'ActivityController',
        'action' => 'getActivityData',
        'route' => '/activity/getActivityData'
    ],
    'RemoveAdminStatusById' => [
        'class' => 'AccountController',
        'action' => 'removeUserAdminStatusById',
        'route' => '/user/administration/removeUserAdminStatusById'
    ],
    'userEdit' => [
        'class' => 'AccountController',
        'action' => 'displayUserEdit',
        'route' => '/user/edit'
    ],
    'performUserEdit' => [
        'class' => 'AccountController',
        'action' => 'performUserEdit',
        'route' => '/user/performUserEdit'
    ],
    'performPasswordChange' => [
        'class' => 'AccountController',
        'action' => 'performPasswordChange',
        'route' => '/user/performPasswordChange'
    ],
    'purchaseProducts' => [
        'class' => 'ShoppingCartController',
        'action' => 'handlePurchase',
        'route' => '/shoppingcart/purchaseProducts'
    ],
    'displayOrderOverview' => [
        'class' => 'ShoppingCartController',
        'action' => 'displayOrderOverview',
        'route' => '/orderOverview'
    ],
    'displayMyOrders' =>[
        'class' => 'ProductController',
        'action'=> 'displayOrders',
        'route'=>'/orders'
    ]
];
