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


use App\Caller;
use App\Contact;
use App\Incident;
use App\Store;
use App\User;
use Illuminate\Support\Carbon;
use Webklex\IMAP\Client;




Route::get('/', 'PublicController@login')->name('index');
Route::get('/dashboard', 'PublicController@dashboard')->name('dashboard');


//////////////////////////
////////*USER*///////////
//////////////////////////
Route::get('/user/profile/{id}','UserController@profile')->name('userProfile');
Route::post('/image','UserController@changeProf')->name('changeProf');
Route::post('/user/add','UserController@create')->name('addUser');

//////////////////////////
////////*TICKETS*/////////
//////////////////////////

Route::get('/ticket/incomplete/{id}','TicketController@incompleteTicket')->name('incompleteTicket');
Route::get('/ticket/{id}','TicketController@getTicket');
Route::get('/tickets/add','TicketController@addTicketView')->name('addTicketView');
Route::post('/ticket/add','TicketController@addTicket')->name('addTicket');
Route::patch('/ticket/add/details','TicketController@addTicketDetails')->name('addTicketDetails');
Route::post('/ticket/pldt/add','TicketController@addPLDTTicket')->name('addPLDTTicket');
Route::get('/tickets/view/{id}', 'TicketController@lookupView')->name('lookupTicketView');
Route::patch('/ticket/edit/{id}', 'TicketController@edit')->name('editTicket');
Route::patch('/tickets/status/fixed/{id}', 'TicketController@editStatus')->name('editStatus');
Route::get('/tickets/open', 'TicketController@open')->name('openTickets');
Route::get('/tickets/ongoing', 'TicketController@ongoing')->name('ongoingTickets');
Route::get('/tickets/closed', 'TicketController@closed')->name('closedTickets');
Route::get('/tickets/fixed', 'TicketController@fixed')->name('fixedTickets');
Route::get('/tickets/all', 'TicketController@all')->name('allTickets');
Route::get('/tickets/verification', 'TicketController@forVerifcation')->name('verificationTickets');
Route::get('/tickets/closed', 'TicketController@closed')->name('closedTickets');
Route::get('/tickets/my', 'TicketController@userTickets')->name('myTickets');
Route::get('/tickets/all', 'TicketController@all')->name('allTickets');
Route::delete('/ticket/delete/{id}', 'TicketController@delete')->name('ticketDelete');
Route::post('/ticket/reject/{id}', 'TicketController@reject')->name('ticketReject');

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
//Route::get('/modal/ticketEdit/{id}','StoreController@contacts')->name('modalTicketEdit');
Route::get('/modal/ticketEdit/{id}','TicketController@editModal')->name('modalTicketEdit');
Route::get('/modal/form/reject/{ticket_id}','TicketController@rejectForm');
Route::get('/modal/lookup/reject/{ticket_id}','TicketController@rejectFormDetails');
Route::view('/modal/form/resolve','modal.resolve_form');
Route::view('/modal/form/userAdd','modal.user_add');
Route::get('/modal/form/resolve/{id}','ResolveController@show')->name('modalResolveView');
Route::get('/modal/{store_id}/contacts','StoreController@storeContacts')->name('storeContacts');

//////////////////////////
////////*MESSAGE*/////////
//////////////////////////
Route::post('/message/new','MessageController@create');
Route::delete('/message/delete/{id}','MessageController@destroy');

//////////////////////////
////////*CALLER*/////////
//////////////////////////
Route::post('/caller/save','CallerController@create');

//////////////////////////
////////*STORE*/////////
//////////////////////////
Route::post('/store/save','StoreController@create');

//////////////////////////
////////*CONTACT*/////////
//////////////////////////
Route::post('/contact/save','ContactController@create');

//////////////////////////
////////*ADMIN*/////////
//////////////////////////
Route::get('/admin','AdminController@index')->name('adminPage');

//////////////////////////
////////*SELECT*/////////
//////////////////////////
Route::get('/select/store', 'SelectController@branch');
Route::get('/select/caller', 'SelectController@caller');
Route::get('/select/contact', 'SelectController@contact');
Route::get('/select/position', 'SelectController@position');
Route::get('/select/department', 'SelectController@department');

//////////////////////////
////////*REPORTS*/////////
//////////////////////////
Route::get('/reports', 'AdminController@report')->name('reportsPage');

//////////////////////////
////////*DATATABLES*//////
//////////////////////////

Route::get('/tickets/ticket-data/{status}','DatatablesController@tickets');

//////////////////////////
////////*MAINTENANCE*//////
//////////////////////////
Route::get('/maintenance','HomeController@maintenance')->name('maintenancePage');

//////////////////////////
////////*SEARCH*//////
//////////////////////////
Route::get('/search','HomeController@search')->name('search');

//////////////////////////
////////*POSITION*//////
//////////////////////////
Route::post('/add/position','PositionController@create');
//////////////////////////
////////*DEPARTMENT*//////
//////////////////////////
Route::post('/add/department','DepartmentController@create');
//////////////////////////
////////*API*//////
//////////////////////////
Route::get('/api/user/{id}','UserController@userAPI');

Route::get('/test',function (){


    $store = Store::whereId(1)->with('contacts')->first();
//    $contacts = Contact::whereHas('store',function ($query){
//        $query->whereId(2);
//    })->get();
//    foreach ($store as $contact){
//        echo '<pre>';
//        echo $store;
//        echo '</pre>';
//    }

    foreach ($store->contacts as $contact){
        echo '<pre>';
        echo $contact;
        echo '</pre>';
    }
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


Route::resource('sdc', 'SDCController');
Route::resource('mdc', 'MDCController');
Route::get('system/{id}/print', 'PrintController@sdcprinter')->name('sdc.printer');
Route::get('manual/{id}/print', 'PrintController@mdcprinter')->name('mdc.printer');
Route::get('reports/reports', 'ReportsController@reports')->name('reports.reports');
Route::post('reports/genipp', 'ReportsController@generateIPP')->name('reports.genipp');
Route::post('reports/genipc', 'ReportsController@generateIPC')->name('reports.genipc');
Route::post('reports/genilr', 'ReportsController@generateILR')->name('reports.genilr');
Route::post('reports/genrds', 'ReportsController@generateRDS')->name('reports.genrds');
Route::get('reports/charts', 'ReportsController@loadChart')->name('reports.charts');
Route::post('reports/lvr', 'ReportsController@loadLVR')->name('reports.lvrchart');
Route::post('reports/ipcr', 'ReportsController@loadIPCR')->name('reports.ipcr');
Route::post('reports/tpr', 'ReportsController@loadTR')->name('reports.tpr');

Route::post('get/positions', 'SDCController@getPosition')->name('get.positions');

// Data Corrections Separate Page
 Route::get('datacorrections', 'DCController@index')->name('datacorrections');
 Route::get('datacorrections/systemdc', 'DCController@system')->name('datacorrections.system');
 Route::get('datacorrections/manualdc', 'DCController@manual')->name('datacorrections.manual');
 Route::get('datacorrections/sdc','DatatablesController@sdc')->name('datacorrection.sdc');
 Route::get('datacorrections/mdc','DatatablesController@mdc')->name('datacorrection.mdc');
