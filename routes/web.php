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

// API Routes
$router->group(['prefix' => 'api'], function () use ($router) {
    // Mahasiswa routes
    $router->get('mahasiswa', 'MahasiswaController@index');
    $router->get('mahasiswa/{id}', 'MahasiswaController@show');
    $router->post('mahasiswa', 'MahasiswaController@store');
    $router->put('mahasiswa/{id}', 'MahasiswaController@update');
    $router->delete('mahasiswa/{id}', 'MahasiswaController@destroy');

    // Dosen routes
    $router->get('dosen', 'DosenController@index');
    $router->get('dosen/{id}', 'DosenController@show');
    $router->post('dosen', 'DosenController@store');
    $router->put('dosen/{id}', 'DosenController@update');
    $router->delete('dosen/{id}', 'DosenController@destroy');

    // Makul routes
    $router->get('makul', 'MakulController@index');
    $router->get('makul/{id}', 'MakulController@show');
    $router->post('makul', 'MakulController@store');
    $router->put('makul/{id}', 'MakulController@update');
    $router->delete('makul/{id}', 'MakulController@destroy');

    // JWT Auth routes
    $router->post('login', ['uses' => 'AuthController@login']);
    $router->post('logout', ['uses' => 'AuthController@logout']);
    $router->post('refresh', ['uses' => 'AuthController@refresh']);
    $router->post('user-profile', ['uses' => 'AuthController@me']);
});
