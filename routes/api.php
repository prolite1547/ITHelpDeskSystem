<?php

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource as UserResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/user', function(){
    return UserResource::collection(User::all());
});

Route::get('/messages/{id}', 'ApiController@get_messages');
Route::get('/tickets/{status}', 'ApiController@get_tickets');
Route::get('/get/ticket-details/{id}', 'ApiController@get_ticket_details');

