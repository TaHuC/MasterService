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
})->name('wellcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/type', 'TypeController');
Route::resource('/brand', 'BrandController');
Route::get('/brand/select/{brand}/{typeId}', 'BrandController@findBrand');
Route::resource('/model', 'ModelController');
Route::get('/model/select/{model}/{brandId}', 'ModelController@findModel');
Route::resource('/client', 'ClientController');
Route::get('/client/show/{id}', 'ClientController@getClient');
Route::resource('/search', 'SearchController');
Route::resource('/product', 'ProductController');
Route::get('/product/serial/{serial}', 'ProductController@getSerial');
Route::resource('/order', 'OrderController');
Route::post('/order/status', 'OrderController@changeStatus')->name('order.changeStatus');
Route::get('/order/params/{status}/{limit?}', 'OrderController@paramsOrder');
Route::get('/order/productId/{id}', 'OrderController@getProductId');
Route::resource('/repair', 'RepairController');
Route::resource('/status', 'StatusController');
Route::resource('/users', 'UsersController');
Route::resource('/notes', 'NoteController');
Route::get('/notes/{id}/{param}', 'NoteController@showNotes');
Route::get('/settings', 'SettingsController@index')->name('settings');
Route::put('/settings', 'SettingsController@update')->name('settings.update');
Route::resource('/api/tasks', 'TaskController');
Route::get('/api/tasks/filter/{filter}', 'TaskController@index')->name('tasks.completed');
