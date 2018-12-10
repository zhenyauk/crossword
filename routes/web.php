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
    return "Hello";
});
//Import crosswords
Route::get('/import', 'ImportController@index');
Route::post('/importExcel', 'ImportController@importCrossword');
//Import crosswords fields
Route::get('/import-fields', 'ImportController@fields');
Route::post('/import-fields', 'ImportController@importFields');