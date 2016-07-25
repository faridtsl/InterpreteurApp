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
Route::get('interpreteur/list','InterpreteurController@showInterpreteurs');
Route::get('interpreteur/archive','InterpreteurController@archiveInterpreteurs');
Route::get('interpreteur/{id}','InterpreteurController@showInterpreteur');
Route::post('interpreteur/update','InterpreteurController@updateInterpreteur');
Route::post('interpreteur/delete','InterpreteurController@deleteInterpreteur');
Route::post('interpreteur/restore','InterpreteurController@restoreInterpreteur');

//Client Routes
Route::get('client/add', 'ClientController@show');
Route::post('client/add', 'ClientController@store');
Route::get('client/list','ClientController@showClients');
Route::get('client/archive','ClientController@archiveClients');
Route::get('client/{id}','ClientController@showClient');
Route::post('client/update','ClientController@updateClient');
Route::post('client/delete','ClientController@deleteClient');
Route::post('client/restore','ClientController@restoreClient');

//Langues Routes
Route::get('langue/add','LangueController@show');
Route::post('langue/add','LangueController@store');

//Images Routes
Route::get('images/{img}',function ($img){
    return \App\Tools\ImageTools::getImage($img);
});


//Auth Routes
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@logout');
// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::auth();



Route::get('/home', 'HomeController@index');
