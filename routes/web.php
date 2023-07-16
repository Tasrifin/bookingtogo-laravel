<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

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
    return redirect('customer');
});

// Route::get('/customer', 'App\Http\Controllers\CustomerController@index');
// Route::get('/customer/create', 'App\Http\Controllers\CustomerController@create');
// Route::post('/customer/store', 'App\Http\Controllers\CustomerController@store');
// Route::get('/customer/edit', 'App\Http\Controllers\CustomerController@edit');
// Route::put('/customer/update', 'App\Http\Controllers\CustomerController@update');
// Route::delete('/customer/destroy', 'App\Http\Controllers\CustomerController@destroy');
Route::resource('customer', CustomerController::class);