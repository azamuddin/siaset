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


Route::get('/kategori/{id}/delete', 'KategoriController@delete');
Route::resource('/kategori', 'KategoriController');

Route::get('/satker/{id}/delete', 'SatkerController@delete');
Route::resource('/satker', 'SatkerController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/aset/import', 'AsetController@import');
Route::post('/aset/import', 'AsetController@processImport');
Route::resource('/aset', 'AsetController');
