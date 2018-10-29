<?php

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

$router->post('auth/login', 'AuthController@auth');

$router->group(['middleware' => 'jwt.auth'], function() use ($router) {

    $router->get('score/{query}', ['uses' => 'ScoreController@score']);
    $router->get('v2/score/{query}', ['uses' => 'ScoreController@v2Score', 'middleware' => 'jsonapi']);
});