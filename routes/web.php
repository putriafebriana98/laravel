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
use App\Society;

Route::get('/', function () {

    return view('welcome');
});
//Route::get('society/ajaxdata','AjaxdataController@index')->name('ajaxdata');
Route::get('ajaxdata','AjaxdataController@index')->name('ajaxdata');
Route::get('ajaxdata/getdata','AjaxdataController@getdata')->name('ajaxdata.getdata');
Route::resource('society','AjaxdataController');

Route::post('ajaxdata/postdata','AjaxdataController@postdata')->name('ajaxdata.postdata');

