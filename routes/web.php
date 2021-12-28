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
$router->group(['prefix' => 'api'], function () use ($router) {

    $router->post('/login', 'Auth\AuthController@login');
    $router->get('/logout', 'Auth\AuthController@logout');
    $router->get('/status', 'Auth\AuthController@me');

    $router->get('/about', 'Admin\AboutController@index');
    $router->post('/about', 'Admin\AboutController@update');
    $router->get('/banner', 'Admin\BannerController@index');
    $router->post('/banner', 'Admin\BannerController@update');




    $router->get('/categories', 'Admin\CategoryController@index');
    $router->post('/category', 'Admin\CategoryController@create');
    $router->get('/category/{slug}', 'Admin\CategoryController@show');
    $router->patch('/category/{slug}', 'Admin\CategoryController@update');
    $router->put('/category/{slug}', 'Admin\CategoryController@update');
    $router->delete('/category/{slug}', 'Admin\CategoryController@delete');

    $router->get('/tags', 'Admin\TagController@index');
    $router->post('/tag', 'Admin\TagController@create');
    $router->get('/tag/{slug}', 'Admin\TagController@show');
    $router->patch('/tag/{slug}', 'Admin\TagController@update');
    $router->put('/tag/{slug}', 'Admin\TagController@update');
    $router->delete('/tag/{slug}', 'Admin\TagController@delete');

    $router->get('/contents', 'Admin\ContentController@index');
    $router->post('/content', 'Admin\ContentController@create');
    $router->get('/content/{slug}', 'Admin\ContentController@get');
    $router->get('/contents/{slug}', 'Admin\ContentController@view');
    $router->patch('/contentfirst/{id}', 'Admin\ContentController@updateFirst');
    $router->put('/contentfirst/{id}', 'Admin\ContentController@updateFirst');
    $router->patch('/content/{slug}', 'Admin\ContentController@update');
    $router->put('/content/{slug}', 'Admin\ContentController@update');
    $router->delete('/content/{slug}', 'Admin\ContentController@delete');

    $router->get('/file/{slug}', 'Admin\FileController@getImgContent');
    $router->post('/file/upload', 'Admin\FileController@uploadImgContent');
    $router->post('/file/profile', 'Admin\FileController@uploadProfile');
    $router->post('/file/banner', 'Admin\FileController@uploadBanner');
    $router->delete('/file/delete/{id}', 'Admin\FileController@deleteImgContent');


    $router->get('/front/contentsbycategory', 'Front\ContentController@showByCategory');
    $router->get('/front/about', 'Front\AboutController@index');
});
