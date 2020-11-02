<?php
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Almacenar la suscripcion
Route::post('/push','PushController@store');

//Obtener key publico
Route::get('/key','PushController@getKey');
Route::post('/deleteSubscribe','PushController@delete');


Route::get('/push','PushController@push')->name('push');



// Route::get('/prueba2','DatosController@showView');

Route::get('/{id}/edit','EditController@showEditView')->name('edit');
Route::put('/{id}', 'EditController@update');

Route::post('/entrada_datos','DatosController@store')->name('entrada_datos');

