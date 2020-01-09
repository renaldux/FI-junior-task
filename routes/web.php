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
});

Route::get('/myaccounts', function (){
    return view('myaccounts');
});

Route::get('/transfer', 'AcountsController@myAccounts')->name('transfer');

Route::post('submittransfer', 'AcountsController@transferAction');

Route::get('/mytransfers', 'TransfersController@getTransfers');

Route::get('/dashboard', 'AcountsController@getMyAccounts')->name('dashboard');

Route::get('/new-account', 'AcountsController@newAccount')->name('newAccount');

Auth::routes();

