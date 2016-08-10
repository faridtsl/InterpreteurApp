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

Route::get(
    '/',
    ['middleware'=>'auth',
        'uses'=>function () {
        return view('welcome');
    }]);




//Interpreteur Routes

Route::get(
    'interpreteur/add',
    ['middleware'=>'auth','uses' =>'InterpreteurController@show']
);

Route::post(
    'interpreteur/add',
    ['middleware'=>'auth','uses'=>'InterpreteurController@store']
);

Route::get(
    'interpreteur/list',
    ['middleware'=>'auth','uses'=>'InterpreteurController@showInterpreteurs']
);

Route::get(
    'interpreteur/archive',
    ['middleware'=>'auth','uses'=>'InterpreteurController@archiveInterpreteurs']
);

Route::get(
    'interpreteur/{id}',
    ['middleware'=>'auth','uses'=>'InterpreteurController@showInterpreteur']
);

Route::post(
    'interpreteur/update',
    ['middleware'=>'auth','uses'=>'InterpreteurController@updateInterpreteur']
);

Route::post(
    'interpreteur/delete',
    ['middleware'=>'auth','uses'=>'InterpreteurController@deleteInterpreteur']
);

Route::post(
    'interpreteur/restore',
    ['middleware'=>'auth','uses'=>'InterpreteurController@restoreInterpreteur']
);





//Client Routes

Route::get(
    'client/add',
    ['middleware'=>'auth','uses'=>'ClientController@show']
);

Route::post(
    'client/add',
    ['middleware'=>'auth','uses'=>'ClientController@store']
);

Route::get(
    'client/list',
    ['middleware'=>'auth','uses'=>'ClientController@showClients']
);

Route::get(
    'client/archive',
    ['middleware'=>'auth','uses'=>'ClientController@archiveClients']
);

Route::get(
    'client/{id}',
    ['middleware'=>'auth','uses'=>'ClientController@showClient']
);

Route::post(
    'client/update',
    ['middleware'=>'auth','uses'=>'ClientController@updateClient']
);

Route::post(
    'client/delete',
    ['middleware'=>'auth','uses'=>'ClientController@deleteClient']
);

Route::post(
    'client/restore',
    ['middleware'=>'auth','uses'=>'ClientController@restoreClient']
);





//Demande Routes

Route::get(
    'demande/add',
    ['middleware'=>'auth','uses'=>'DemandeController@show']
);
Route::post(
    'demande/add',
    ['middleware'=>'auth','uses'=>'DemandeController@store']
);
Route::post(
    'demande/list',
    ['middleware'=>'auth','uses'=>'DemandeController@showList']
);
Route::get(
    'demande/list',
    ['middleware'=>'auth','uses'=>'DemandeController@showList']
);
Route::get(
    '/calendar',
    ['middleware'=>'auth','uses'=>'DemandeController@showCalendar']
);
Route::get(
    '/demande/update',
    ['middleware'=>'auth','uses'=>'DemandeController@showUpdate']
);
Route::post(
    '/demande/update',
    ['middleware'=>'auth','uses'=>'DemandeController@storeUpdate']
);
Route::get(
    '/demande/duplicate',
    ['middleware'=>'auth','uses'=>'DemandeController@duplicateDemande','as'=>'/demande/list']
);
Route::get(
    '/demande/archive',
    ['middleware'=>'auth','uses'=>'DemandeController@archiveDemandes']
);
Route::get(
    '/demande/restore',
    ['middleware'=>'auth','uses'=>'DemandeController@restoreDemande']
);
Route::post(
    '/demande/delete',
    ['middleware'=>'auth','uses'=>'DemandeController@deleteDemande']
);
Route::get(
    '/demande/get/{id}',
    ['middleware'=>'auth','uses'=>'DemandeController@getDemande']
);


//Langues Routes

Route::get(
    'langue/add',
    ['middleware'=>'auth','uses'=>'LangueController@show']
);

Route::post(
    'langue/add',
    ['middleware'=>'auth','uses'=>'LangueController@store']
);

Route::get(
    'langue/{id}',
    ['middleware'=>'auth','uses'=>'LangueController@getLangue']
);

Route::get(
    'etat/add',
    ['middleware'=>'auth','uses'=>'EtatController@show']
);

Route::post(
    'etat/add',
    ['middleware'=>'auth','uses'=>'EtatController@store']
);

Route::get(
    'traductions/{id}',
    ['middleware'=>'auth','uses'=>'TraductionController@getTraductions']
);
Route::post(
    'traduction/delete',
    ['middleware'=>'auth','uses'=>'TraductionController@deleteTraduction']
);

//Adresse Routes

Route::get(
    'adresse/{id}',
    ['middleware'=>'auth','uses'=>'AdresseController@get']
);
Route::get(
    'adresse/update/{id}',
    ['middleware'=>'auth','uses'=>'AdresseController@showUpdate']
);
Route::post(
    'adresse/update',
    ['middleware'=>'auth','uses'=>'AdresseController@storeUpdate']
);


//Devis Routes
Route::get(
    'devis/add',
    ['middleware'=>'auth','uses'=>'DevisController@show']
);
Route::post(
    'devis/add',
    ['middleware'=>'auth','uses'=>'DevisController@store']
);
Route::get(
    'devis/list',
    ['middleware'=>'auth','uses'=>'DevisController@showDevis']
);
Route::get(
    'devis/resend',
    ['middleware'=>'auth','uses'=>'DevisController@resendDevis']
);
Route::get(
    'devis/view',
    ['middleware'=>'auth','uses'=>'DevisController@viewDevis']
);
Route::get(
    'devis/restore',
    ['middleware'=>'auth','uses'=>'DevisController@restoreDevis']
);
Route::get(
    'devis/archive',
    ['middleware'=>'auth','uses'=>'DevisController@archiveDevis']
);
Route::get(
    'devis/delete',
    ['middleware'=>'auth','uses'=>'DevisController@deleteDevis']
);
Route::get(
    'devis/validate',
    ['middleware'=>'auth','uses'=>'DevisController@validateDevis']
);


//Facture Routes
Route::get(
    'facture/list',
    ['middleware'=>'auth','uses'=>'FactureController@showFactures']
);



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
