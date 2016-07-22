<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Interpreteur Routes
Route::get('interpreteur/add', 'InterpreteurController@show');
Route::post('interpreteur/add', 'InterpreteurController@store');
Route::get('images/{img}','InterpreteurController@getImage');
Route::get('interpreteur/list','InterpreteurController@showInterpreteurs');
Route::get('interpreteur/{id}','InterpreteurController@showInterpreteur');
Route::post('interpreteur/update','InterpreteurController@updateInterpreteur');
Route::post('interpreteur/delete','InterpreteurController@deleteInterpreteur');

Route::get('langue/add','LangueController@show');
Route::post('langue/add','LangueController@store');


Route::get('auth/login', 'Auth\AuthController@getLogin');

Route::post('auth/login', 'Auth\AuthController@postLogin');

Route::get('auth/logout', 'Auth\AuthController@logout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');

Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::auth();

Route::get('/home', 'HomeController@index');
