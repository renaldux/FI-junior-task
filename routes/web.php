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

Route::get('/', function (){
    return view('home');
})->middleware('guest');


/**
 * Accounts routes
 */
Route::get('/dashboard', 'AcountsController@dashboard')->name('dashboard');
Route::get('/create-account', 'AcountsController@create')->name('newAccount');
Route::get('/transfer', 'AcountsController@transfer')->name('transfer');


/**
 * Transfer routes
 */
Route::get('/my-transfers', 'TransfersController@getTransfers')->name('myTransfers');
Route::post('/submit-transfer', 'TransfersController@submitTransfer')->name('submitTransfer');

Auth::routes();

