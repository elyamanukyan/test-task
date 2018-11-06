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

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('domains', 'DomainController', ['except' => ['show', 'create']]);
    Route::get('domains/restore/{id}', 'DomainController@restore');
    Route::post('domains/check', 'DomainController@check');
});

Route::get('{slug}', function() {
    abort(404);
})->where('slug', '([A-Za-z0-9\-\/]+)');
