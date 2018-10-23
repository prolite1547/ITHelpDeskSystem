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

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/add', function () {
    return view('add_ticket');
});


Route::get('/view', function () {
    return view('ticket_lookup');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
