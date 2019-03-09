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


use App\ConnectionIssueReply;
use App\Ticket;
use Illuminate\Support\Facades\Mail;
use Webklex\IMAP\Client;


Route::get('/', 'PublicController@login')->name('index');
Route::get('/dashboard', 'PublicController@dashboard')->name('dashboard');


//////////////////////////
////////*USER*///////////
//////////////////////////
Route::get('/user/profile/{id}', 'UserController@profile')->name('userProfile');
Route::post('/image', 'UserController@changeProf')->name('changeProf');
Route::post('/user/add', 'UserController@create')->name('addUser');

//////////////////////////
////////*TICKETS*/////////
//////////////////////////

Route::get('/ticket/incomplete/{id}', 'TicketController@incompleteTicket')->name('incompleteTicket');
Route::get('/ticket/{id}', 'TicketController@getTicket');
Route::get('/tickets/add', 'TicketController@addTicketView')->name('addTicketView');
Route::post('/ticket/add', 'TicketController@addTicket')->name('addTicket');
Route::patch('/ticket/add/details', 'TicketController@addTicketDetails')->name('addTicketDetails');
Route::post('/ticket/pldt/add', 'TicketController@addConnectionIssue')->name('addConnectionIssue');
Route::get('/tickets/view/{id}', 'TicketController@lookupView')->name('lookupTicketView');
Route::patch('/ticket/edit/{id}', 'TicketController@edit')->name('editTicket');
Route::patch('/tickets/status/fixed/{id}', 'TicketController@editStatus')->name('editStatus');
Route::get('/tickets/open', 'TicketController@open')->name('openTickets');
Route::get('/tickets/ongoing', 'TicketController@ongoing')->name('ongoingTickets');
Route::get('/tickets/expired', 'TicketController@expired')->name('expiredTickets');
Route::get('/tickets/closed', 'TicketController@closed')->name('closedTickets');
Route::get('/tickets/fixed', 'TicketController@fixed')->name('fixedTickets');
Route::get('/tickets/all', 'TicketController@all')->name('allTickets');
Route::get('/tickets/verification', 'TicketController@forVerifcation')->name('verificationTickets');
Route::get('/tickets/closed', 'TicketController@closed')->name('closedTickets');
Route::get('/tickets/my', 'TicketController@userTickets')->name('myTickets');
Route::get('/tickets/all', 'TicketController@all')->name('allTickets');
Route::delete('/ticket/delete/{id}', 'TicketController@delete')->name('ticketDelete');
Route::post('/ticket/reject/{id}', 'TicketController@reject')->name('ticketReject');
Route::post('/ticket/extend/{id}', 'TicketController@extend')->name('ticketExtend');
Route::get('/modal/form/ticketExtendDetails/{id}', 'TicketController@ticketExtendDetails')->name('ticketExtendDetails');

//////////////////////////
////////*FIX*/////////
//////////////////////////
Route::post('/ticket/{id}/fix/create', 'FixController@create')->name('addFix');

//////////////////////////
////////*FILE*////////////
//////////////////////////
Route::get('/file/download/{id}', 'FileController@download')->name('fileDownload');
Route::post('/file/ticket/{id}', 'TicketController@addFile');
//////////////////////////
////////*MODAL*////////////
//////////////////////////
//Route::get('/modal/ticketEdit/{id}','StoreController@contacts')->name('modalTicketEdit');
Route::get('/modal/ticketEdit/{id}', 'TicketController@editModal')->name('modalTicketEdit');
Route::get('/modal/form/reject/{ticket_id}', 'TicketController@rejectForm');
Route::get('/modal/lookup/reject/{ticket_id}', 'TicketController@rejectFormDetails');
Route::view('/modal/form/fix', 'modal.fix_form');
Route::view('/modal/form/userAdd', 'modal.user_add');
Route::get('/modal/form/extend/{id}', 'TicketController@getExtendForm');
Route::get('/modal/form/fix/{id}', 'FixController@show')->name('modalFixView');
Route::get('/modal/{store_id}/contacts', 'StoreController@storeContacts')->name('storeContacts');

//////////////////////////
////////*MESSAGE*/////////
//////////////////////////
Route::post('/message/new', 'MessageController@create');
Route::delete('/message/delete/{id}', 'MessageController@destroy');

//////////////////////////
////////*CALLER*/////////
//////////////////////////
Route::post('/caller/save', 'CallerController@create');

//////////////////////////
////////*STORE*/////////
//////////////////////////
Route::post('/store/save', 'StoreController@create');

//////////////////////////
////////*CONTACT*/////////
//////////////////////////
Route::post('/contact/save', 'ContactController@create');

//////////////////////////
////////*ADMIN*/////////
//////////////////////////
Route::get('/admin', 'AdminController@index')->name('adminPage');

//////////////////////////
////////*SELECT*/////////
//////////////////////////
Route::get('/select/store', 'SelectController@branch');
Route::get('/select/caller', 'SelectController@caller');
Route::get('/select/contact', 'SelectController@contact');
Route::get('/select/position', 'SelectController@position');
Route::get('/select/department', 'SelectController@department');
Route::get('/select/expiration', 'SelectController@expiration');

//////////////////////////
////////*REPORTS*/////////
//////////////////////////
Route::get('/reports', 'AdminController@report')->name('reportsPage');

//////////////////////////
////////*DATATABLES*//////
//////////////////////////

Route::get('/tickets/ticket-data/{status}', 'DatatablesController@tickets');

//////////////////////////
////////*MAINTENANCE*//////
//////////////////////////
Route::get('/maintenance', 'HomeController@maintenance')->name('maintenancePage');

//////////////////////////
////////*SEARCH*//////
//////////////////////////
Route::get('/search', 'HomeController@search')->name('search');

//////////////////////////
////////*RESOLVE*//////
//////////////////////////
Route::post('/ticket/resolve/{id}', 'ResolveController@store');

//////////////////////////
////////*POSITION*//////
//////////////////////////
Route::post('/add/position', 'PositionController@create');

//////////////////////////
////////*DEPARTMENT*//////
//////////////////////////
Route::post('/add/department', 'DepartmentController@create');

//////////////////////////
////////*Connection Issue Reply*//////
//////////////////////////
Route::get('/reply/conversation/{id}', 'ConnectionIssueReplyController@replyConversation')->name('replyConversation');
Route::post('/reply/support', 'ConnectionIssueReplyController@replyMail');

//////////////////////////
////////*API*//////
//////////////////////////
Route::get('/api/user/{id}', 'UserController@userAPI');
Route::get('/api/connIssReply/{ticket_id}', 'ConnectionIssueReplyController@connIssReplyAPI');

//////////////////////////
////////*EXTENDED*//////
//////////////////////////
Route::post('/add/extend/{id}', 'ExtendController@create')->name('addExtend');

Route::get('/test', function () {

    $collection = Ticket::with(['connectionIssueMailReplies' => function ($query) {
        return $query->latest('reply_date');
    }])->findOrFail(10);

    dd($collection->connectionIssueMailReplies);
    return new \App\Http\Resources\ConnectionIssueReplyCollection(ConnectionIssueReply::all());
});

Route::get('/test2.1', function () {
    $nntp = imap_open('{imap.gmail.com:993/imap/ssl}Ticketing', 'it.support@citihardware.com', 'citihardware2020');
    $threads = imap_thread($nntp);


    foreach ($threads as $key => $val) {
        $tree = explode('.', $key);
        if ($tree[1] == 'num') {
            $header = imap_headerinfo($nntp, $val);
            echo "<ul>\n\t<li>" . $header->subject . "\n";
        } elseif ($tree[1] == 'branch') {
            echo "\t</li>\n</ul>\n";
        }
    }

    imap_close($nntp);

    dd($threads);
});

Route::get('/test2', function () {
    $oClient = new Client();
    $oClient->connect();


    $inboxFolder = $oClient
        ->getFolder('INBOX');


    $inboxMessages = $inboxFolder
        ->query()
        ->on('21.02.2019')
        ->subject('This is the subject (TID#1)')
        ->setFetchFlags(false)
        ->setFetchBody(true)
        ->setFetchAttachment(false)
        ->get();


    $latestInboxMessage = $inboxMessages->first();

    if ($latestInboxMessage !== null) {
        $plain_text = $latestInboxMessage->getTextBody();
        $html_body = $latestInboxMessage->getHTMLBody();
        $reply = (new \EmailReplyParser\Parser\EmailParser())->parse($latestInboxMessage->getTextBody())->getVisibleText();
        $hasAttachments = $latestInboxMessage->getAttachments()->count();
        $subject = $latestInboxMessage->getSubject();
        $from = $latestInboxMessage->getFrom();
        $to = json_encode($latestInboxMessage->getTo());
        $cc = json_encode($latestInboxMessage->getCC());
        $reply_to = $latestInboxMessage->getInReplyTo();
        $reply_date = $latestInboxMessage->getDate();
        $ticket_id = 1;
        $connection_issue = new ConnectionIssueReply;
        $connection_issue_fillable = $connection_issue->getFillable();
        dd(json_encode($from));
//    $connection_issue->create(compact($connection_issue_fillable));
    }
});

Route::get('/test5', function () {
    dd(Auth::user()->position->group);

});

Route::get('/ongoingMail', function () {

    $ongoingMailInc = Ticket::whereStatus(2)->whereHas('incident', function ($query) {
        $query->whereNotNull('connection_id');
    })->with(['connectionIssueMailReplies' => function ($query) {
        $query->latest('reply_date');
    }, 'incident:id,subject'])->get();

    foreach ($ongoingMailInc as $ticket) {
        $ticketID = $ticket->id;
        $subject = $ticket->incident->subject;
        $latest_reply = $ticket->connectionIssueMailReplies->first();

        fetchNewConnectionIssueEmailReplies($ticketID, $subject, $latest_reply);
    }
});

Auth::routes();
Auth::routes(['register' => false]);
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


Route::get('datacorrections/manualdc', 'DCController@manual')->name('datacorrections.manual');


Route::get('datacorrections/sdc', 'DatatablesController@sdc')->name('datacorrection.sdc');
Route::get('datacorrections/mdc', 'DatatablesController@mdc')->name('datacorrection.mdc');


Route::get('datacorrections/sdc-data/{status}', 'DatatablesController@system')->name('datacorrections.system');
Route::get('datacorrections/ty-data/{status}', 'DatatablesController@treasury')->name('datacorrections.dataty');
Route::get('datacorrections/gc-data/{status}', 'DatatablesController@govcomp')->name('datacorrections.datagc');
Route::get('datacorrections/app-data/{status}', 'DatatablesController@approver')->name('datacorrections.dataapp');

Route::get('datacorrections/sdc/saved', 'DCController@sdc_route')->name('datacorrectons.sdcSave');
Route::get('datacorrections/sdc/posted', 'DCController@sdc_route')->name('datacorrectons.sdcPosted');
Route::get('datacorrections/sdc/ongoing', 'DCController@sdc_route')->name('datacorrectons.sdcOngoing');
Route::get('datacorrections/sdc/forapproval', 'DCController@sdc_route')->name('datacorrectons.sdcForApproval');
Route::get('datacorrections/sdc/approved', 'DCController@sdc_route')->name('datacorrectons.sdcApproved');
Route::get('datacorrections/sdc/done', 'DCController@sdc_route')->name('datacorrectons.sdcDone');


Route::get('datacorrections/ty/sdc/all', 'DCController@treasury_all')->name('datacorrectons.treasuryALL');
Route::get('datacorrections/ty/sdc/pending', 'DCController@treasury_pending')->name('datacorrectons.treasuryPENDING');
Route::get('datacorrections/ty/sdc/done', 'DCController@treasury_done')->name('datacorrectons.treasuryDONE');

Route::get('datacorrections/gc/sdc/all', 'DCController@govcomp_all')->name('datacorrectons.govcompALL');
Route::get('datacorrections/gc/sdc/pending', 'DCController@govcomp_pending')->name('datacorrectons.govcompPENDING');
Route::get('datacorrections/gc/sdc/done', 'DCController@govcomp_done')->name('datacorrectons.govcompDONE');


Route::get('datacorrections/app/sdc/all', 'DCController@approver_all')->name('datacorrectons.approverALL');
Route::get('datacorrections/app/sdc/pending', 'DCController@approver_pending')->name('datacorrectons.approverPENDING');
Route::get('datacorrections/app/sdc/done', 'DCController@approver_done')->name('datacorrectons.approverDONE');


Route::get('print/{id}/ticket', 'TicketController@print')->name('print.ticket');
