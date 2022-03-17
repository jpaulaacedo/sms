<?php

use Illuminate\Support\Facades\Route;

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
    return view('home');  
     
});

Route::get('/', 'HomeController@index');

Auth::routes(['register'=>false]);
// Auth::routes(['register' => false]);
Route::get('/home', 'HomeController@index');

Route::get('/messengerial', 'MessengerialController@index');

Route::post('/messengerial/store', 'MessengerialController@store_request');

 Route::get('vehicle', function () {
    return view('vehicle');
});
Route::get('dc_approval', function () {
    return view('dc_approval');
});