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
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Webklex\IMAP\Client;




Route::get('/', 'PublicController@login')->name('index');
Route::get('/dashboard', 'PublicController@dashboard')->name('dashboard');


//////////////////////////
////////*USER*///////////
//////////////////////////
Route::get('/user/profile/{id}','UserController@profile')->name('userProfile');
Route::post('/image','UserController@changeProf')->name('changeProf');

//////////////////////////
////////*TICKETS*/////////
//////////////////////////

Route::get('/ticket/{id}','TicketController@getTicket');
Route::get('/tickets/add','TicketController@addTicketView')->name('addTicketView');
Route::post('/ticket/add','TicketController@addTicket')->name('addTicket');
Route::get('/tickets/view/{id}', 'TicketController@lookupView')->name('lookupTicketView');
Route::patch('/tickets/view/edit/{id}', 'TicketController@edit')->name('editTicket');
Route::get('/tickets/open', 'TicketController@open')->name('openTickets');
Route::get('/tickets/ongoing', 'TicketController@ongoing')->name('ongoingTickets');
Route::get('/tickets/closed', 'TicketController@closed')->name('closedTickets');
Route::get('/tickets/all', 'TicketController@all')->name('allTickets');
Route::get('/tickets/verification', 'TicketController@forVerifcation')->name('verificationTickets');
Route::get('/tickets/closed', 'TicketController@closed')->name('closedTickets');
Route::get('/tickets/my', 'TicketController@userTickets')->name('myTickets');
Route::get('/tickets/all', 'TicketController@all')->name('allTickets');
Route::delete('/ticket/delete/{id}', 'TicketController@delete')->name('ticketDelete');

//////////////////////////
////////*RESOLVE*/////////
//////////////////////////
Route::post('/ticket/{id}/resolve/create','ResolveController@create')->name('addResolve');

//////////////////////////
////////*FILE*////////////
//////////////////////////
Route::get('/file/download/{id}','FileController@download')->name('fileDownload');
Route::post('/file/ticket/{id}','TicketController@addFile');
//////////////////////////
////////*MODAL*////////////
//////////////////////////
Route::get('/modal/ticketEdit/{id}','TicketController@editModal')->name('modalTicketEdit');
Route::view('/modal/form/resolve','modal.resolve_form')->name('modalTicketEdit');
//////////////////////////
////////*MESSAGE*/////////
//////////////////////////
Route::post('/message/new','MessageController@create');

//Route::get('/requests', 'PublicController@dashboard')->name('requests');
//Route::get('/reports', 'PublicController@dashboard')->name('reports');
//Route::get('/knowledgeBase', 'PublicController@dashboard')->name('knowledgeBase');

Route::get('/tickets/ticket-data/{status}','DatatablesController@tickets')->name('datatables.tickets');

Route::get('/test',function (){

    $array = ['name' => 'John'];

    echo json_encode($array);

});

Route::get('/test2',function (){
    $oClient = new Client();
    $oClient->connect();
    $aFolder = $oClient->getFolder('INBOX');
    $aMessage = $aFolder->query()->UNSEEN()->get();

    foreach ($aMessage as $message){
        echo $message->getHTMLBody(true);
    }
    dd($aMessage);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
