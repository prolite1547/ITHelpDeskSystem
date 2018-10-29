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

use App\Category;
use App\CategoryGroup;








Route::get('/', 'PublicController@login')->name('index');
Route::get('/dashboard', 'PublicController@dashboard')->name('dashboard');
Route::get('/tickets', 'PublicController@tickets')->name('tickets');
//Route::get('/requests', 'PublicController@dashboard')->name('requests');
//Route::get('/reports', 'PublicController@dashboard')->name('reports');
//Route::get('/knowledgeBase', 'PublicController@dashboard')->name('knowledgeBase');

Route::get('/test',function (){

    $data = DB::table('categories')->where('group',6)->orderByRaw('RAND()')->first();

    var_dump( $data->id);
//    foreach ($data as $row){
//        echo $row->id;
//    }

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
