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

/* Get Auth0 token */
$router->get('auth',  ['uses' => 'AuthController@getToken']);

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {

    /* Employees endpoints */
    $router->get('employees',  ['uses' => 'EmployeeController@showAll']);
    $router->get('employees/{id}', ['uses' => 'EmployeeController@show']);
    $router->post('employees', ['uses' => 'EmployeeController@create']);
    $router->delete('employees/{id}', ['uses' => 'EmployeeController@delete']);
    $router->put('employees/{id}', ['uses' => 'EmployeeController@update']);
    $router->get('superior/employees/{id}', ['uses' => 'EmployeeController@showSuperiorEmployees']);

    /* Positions endpoints */
    $router->get('positions',  ['uses' => 'PositionController@showAll']);
    $router->get('positions/{id}', ['uses' => 'PositionController@show']);
    $router->post('positions', ['uses' => 'PositionController@create']);
    $router->delete('positions/{id}', ['uses' => 'PositionController@delete']);
    $router->put('positions/{id}', ['uses' => 'PositionController@update']);
});
