<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@showWelcome');
Route::get('/createUser', 'HomeController@createUser');
Route::post('/storeUser', 'HomeController@storeUser');

Route::get('/login', 'HomeController@getLogin');
Route::post('/login', 'HomeController@postLogin');

Route::get('/privatePage', 'HomeController@getPrivatePage');

Route::get('/logout','HomeController@logout');