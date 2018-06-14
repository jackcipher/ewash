<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/test', 'TestController@test');

Auth::routes();




Route::get('/home', 'HomeController@index')->name('home');



$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function($api){
    $api->get('users/{id}', 'App\Api\V1\Controllers\UserController@show');
});
