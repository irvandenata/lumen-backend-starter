<?php

/** @var \Laravel\Lumen\Routing\Router $router */


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/login', 'Auth\AuthController@login');
$router->get('/logout', 'Auth\AuthController@logout');
$router->get('/status', 'Auth\AuthController@me');
$router->get('/categories', 'CategoryController@index');
$router->post('/category', 'CategoryController@create');
$router->get('/category/{slug}', 'CategoryController@show');
$router->patch('/category/{slug}', 'CategoryController@update');
$router->put('/category/{slug}', 'CategoryController@update');
$router->delete('/category/{slug}', 'CategoryController@delete');

$router->get('/tags', 'TagController@index');
$router->post('/tag', 'TagController@create');
$router->get('/tag/{slug}', 'TagController@show');
$router->patch('/tag/{slug}', 'TagController@update');
$router->put('/tag/{slug}', 'TagController@update');
$router->delete('/tag/{slug}', 'TagController@delete');

$router->get('/contents', 'ContentController@index');
$router->post('/content', 'ContentController@create');
$router->get('/content/{slug}', 'ContentController@show');
$router->patch('/content/{slug}', 'ContentController@update');
$router->put('/content/{slug}', 'ContentController@update');
$router->delete('/content/{slug}', 'ContentController@delete');

$router->post('/upload', 'FileController@uploadImgContent');
$router->delete('/delete/{id}', 'FileController@deleteImgContent');
