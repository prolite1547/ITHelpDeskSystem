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
use App\Role;
use App\Store;
use App\Ticket;
use App\User;
use Yajra\DataTables\Facades\DataTables;






Route::get('/', 'PublicController@login')->name('index');
Route::get('/dashboard', 'PublicController@dashboard')->name('dashboard');

//////////////////////////
////////*TICKETS*/////////
//////////////////////////

Route::get('/ticket/add', 'TicketController@addTicket')->name('addTicketView');
Route::post('/ticket/add','TicketController@addTicket')->name('addTicket');
Route::get('/tickets/view/{id}', 'TicketController@lookupView')->name('lookupTicketView');
Route::get('/tickets/open', 'TicketController@open')->name('openTickets');
Route::get('/tickets/ongoing', 'TicketController@ongoing')->name('ongoingTickets');
Route::get('/tickets/verification', 'TicketController@forVerifcation')->name('verificationTickets');
Route::get('/tickets/closed', 'TicketController@closed')->name('closedTickets');
Route::get('/tickets/tickets', 'TicketController@userTickets')->name('myTickets');
Route::get('/tickets/all', 'TicketController@all')->name('allTickets');




//Route::get('/requests', 'PublicController@dashboard')->name('requests');
//Route::get('/reports', 'PublicController@dashboard')->name('reports');
//Route::get('/knowledgeBase', 'PublicController@dashboard')->name('knowledgeBase');

Route::get('/tickets/ticket-data/{status}','DatatablesController@tickets')->name('datatables.tickets');

Route::get('/test',function (){

$dataArray = groupListSelectArray(Role::class,'role','users','id','name');
$branchArray = groupListSelectArray(Store::class,'store_name','contactNumbers','id','number');

dd($dataArray);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
