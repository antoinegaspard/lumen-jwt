<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/register', [
    'as' => 'register',
    'uses' => 'AuthController@register',
]);

$router->post('/login', [
    'as' => 'login',
    'uses' => 'AuthController@login',
]);
    
$router->get('/me', [
    'as' => 'me',
    'uses' => 'AuthController@me',
    'middleware' => 'auth',
]);