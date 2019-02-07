<?php

namespace App\Http\Controllers;

use App\Call;
use App\Caller;
use App\CategoryB;
use App\CategoryC;
use App\File;
use App\Http\Requests\StoreTicket;
use App\Incident;
use App\Mail\PLDTIssue;
use App\Status;
use App\Ticket;
use App\Category;
use App\Message;
use Carbon\Carbon;
use DateInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getTicket($id)
    {

        $ticket = Ticket::with([
            'incident.call.loggedBy',
            'statusRelation',
            'incident.call.callerRelation',
            'typeRelation',
            'incident.call.contact.store',
            'assigneeRelation',
            'incident.categoryRelation',
            'incident.catARelation',
            'incident',
            'incident.getFiles',
            'ticketMessages'
        ])
            ->findOrFail($id)->toArray();

        return response()->json($ticket);
    }

    public function lookupView($id)
    {

        $ticket = Ticket::with([
            'incident.call.loggedBy',
            'statusRelation',
            'incident.call.callerRelation',
            'typeRelation',
            'incident.call.contact.store',
            'assigneeRelation',
            'incident.categoryRelation',
            'incident.catARelation',
            'incident',
            'incident.getFiles'
        ])
            ->findOrFail($id);

        return view("ticket.ticket_lookup", ['ticket' => $ticket]);
    }

    public function addTicketView(Request $request)
    {
        $userID = Auth::user()->id;

        /*CHECK IF USER STILL HAS UNCOMPLETED TICKET DATA'S*/
        $uncompleted_ticket = validateLoggersTicketStatus($userID);
        if($uncompleted_ticket){
            return redirect()->route('incompleteTicket',['id' => $uncompleted_ticket->id]);
        }else{
            return view('ticket.add_ticket');
        }

    }

    public function incompleteTicket($id){

        $ticket = Ticket::findOrFail($id);

        if($ticket->logged_by === Auth::id()){
            return view('ticket.incomplete',compact('ticket'));
        }else {
            return redirect()->back();
        }

    }

    public function addTicket(StoreTicket $request)
    {
        /*INSERT/FETCH THEN GET CALLER ID*/
        $caller_id = addCaller($request->except(['_token', 'store']));
        $requester_id = $request->user()->id;

        $insert_data = DB::transaction(function () use ($request, $caller_id,$requester_id) {

            /*INSERT CALL RECORD*/
            $call = Call::create(['caller_id' => $caller_id, 'user_id' => $requester_id])
                ->incident()->create()
                ->ticket()->create(['store' => $request->store, 'status' => 1,'logged_by' => $requester_id]);

            return $call;
        });

        /*FETCH ID OF THE INSERTED TICKET*/
        $ticket_id = $insert_data->incident->ticket->id;

        return response(compact('ticket_id'));

    }

    public function addTicketDetails(StoreTicket $request)
    {

        /*GET ID'S OF THE OPEN AND ONGOING CATEGORY IN THE CATEGORY TABLE*/
        $openID = 1;
        $ongoingID = 2;

        /*ID OF THE TICKET AND INCIDENT THAT THE DETAILS WILL BE INSERTED TO*/
        $ticket_id = $request->ticket_id;

        /*INCIDENT_ID OF THE TICKET THE DETAILS WILL BE INSERTED TO*/
        $incident_id = Ticket::findOrFail($ticket_id)->incident_id;

        /*FETCH THE EXPIRATION HOURS COLUMN*/
        $expiration_hours = CategoryB::findOrFail($request->catB)->getExpiration->expiration;
        $catA = CategoryB::findOrFail($request->catB)->group->id;

        /*GENERATE TE EXPIRATION DATE*/
        $expiration_date = Carbon::now()->addHours($expiration_hours);


        /*ADD EXPIRATION IN REQUEST ARRAY*/
        $request->request->add(array('expiration' => $expiration_date, 'catA' => $catA));

        /*CHECK IF THE STATUS OF TICKET WILL BE OPEN OR ONGOING*/
        if (!$request->assignee) {
            $request->request->add(['status' => $openID]);
        } else {
            $request->request->add(['status' => $ongoingID]);
        }

         DB::transaction(function () use ($request, $incident_id,$ticket_id) {

             Incident::findOrFail($incident_id)->update($request->only('subject', 'details', 'category', 'catA', 'catB'));
             $ticket = Ticket::findOrFail($ticket_id);
             $ticket->update($request->only('expiration', 'type', 'priority', 'assignee', 'status','group'));

            /*CREATE DIRECTORY NAME*/
            $ticketDirectoryName = str_replace(':', '', preg_replace('/[-,\s]/', '_', $ticket->created_at)) . '_' . $ticket_id;

            /*CHECK IF REQUEST CONTAINS A FILE AND STORE IT*/
            if ($request->hasFile('attachments')) {
                foreach ($request->attachments as $attachment) {

                    $original_name = $attachment->getClientOriginalName();
                    $mime_type = $attachment->getMimeType();
                    $original_ext = $attachment->getClientOriginalExtension();
                    $path = $attachment->store("$ticketDirectoryName", 'ticket');

                    File::create(['incident_id' => $incident_id, 'path' => $path, 'original_name' => $original_name, 'mime_type' => $mime_type, 'extension' => $original_ext]);
                };
            }

        });


        return redirect()->route('lookupTicketView', ['id' => $ticket_id]);


    }

    public function open()
    {

        $ticketTotals = ticketTypeCount('status', 1);

        return view('ticket.openTickets', $ticketTotals);
    }

    public function ongoing()
    {

        $ticketTotals = ticketTypeCount('status', 2);
        return view('ticket.ongoingTickets', $ticketTotals);
    }

    public function expired()
    {

        $ticketTotals = ticketTypeCount('status', 6);
        return view('ticket.expiredTickets', $ticketTotals);
    }

    public function closed()
    {

        $ticketTotals = ticketTypeCount('status', 3);
        return view('ticket.closedTickets', $ticketTotals);
    }

    public function fixed()
    {

        $ticketTotals = ticketTypeCount('status', 4);
        return view('ticket.fixedTickets', $ticketTotals);
    }

    public function all()
    {

        $ticketTotals = ticketTypeCount('all');
        return view('ticket.allTickets', $ticketTotals);
    }

    public function forVerification()
    {

        return view('ticket.openTickets');
    }

    public function userTickets()
    {
        $ticketTotals = ticketTypeCount('user', Auth::id());
        return view('ticket.myTickets', $ticketTotals);
    }

    public function delete($id)
    {

        $ticket = Ticket::findOrFail($id)->delete();
//        $ticket = Ticket::findOrFail($id)->incident->call->delete();

        return redirect()->route('openTickets');
    }

    public function edit($id, StoreTicket $request)
    {
        try {
            DB::beginTransaction();
            $bool = true;
            if ($request->filled(['incident'])) {
                $incident = Ticket::findOrFail($id)->incident;

                foreach ($request->incident as $key => $value) {
                    $incident->$key = $value;
                }
                $incident->save();

            }

            if ($request->filled(['ticket'])) {
                $ticket = Ticket::findOrFail($id);
                foreach ($request->ticket as $key => $value) {
                    $ticket->$key = $value;
                }
                $ticket->save();
            }

            if ($request->filled(['fileID'])) {
                foreach ($request->fileID as $id) {
                    $file = File::findOrFail($id);
                    if (Storage::disk('ticket')->delete($file->path)) $file->delete();
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            $bool = $e;
            DB::rollback();
        }


        return response()->json(['success' => $bool]);

    }

    public function editModal($id)
    {
        $ticket = Ticket::with([
            'incident.call.loggedBy',
            'statusRelation',
            'incident.call.callerRelation',
            'typeRelation',
            'incident.call.contact.store',
            'assigneeRelation',
            'incident.categoryRelation',
            'incident.catARelation',
            'incident',
        ])
            ->findOrFail($id);
        $view = view('modal.ticket_edit', ['ticket' => $ticket]);
        $viewString = strlen($view->render());
        return response()->view('modal.ticket_edit', ['ticket' => $ticket])->header('Content-Encoding', 'none')->header('Content-Length', $viewString);
    }

    public function addFile($id, Request $request)
    {

        $ticket = Ticket::findOrFail($id);
        $destination = $ticket->getFileDirectoryFolder();

        foreach ($request->file as $attachment) {

            $original_name = $attachment->getClientOriginalName();
            $mime_type = $attachment->getMimeType();
            $original_ext = $attachment->getClientOriginalExtension();
            $path = $attachment->store($destination, 'ticket');

            File::create(['incident_id' => $ticket->incident->id, 'path' => $path, 'original_name' => $original_name, 'mime_type' => $mime_type, 'extension' => $original_ext]);
        };
    }

    public function print($id){
        $ticket = Ticket::all()->where('id', $id);
        return  view('layouts.printTicket')->with('ticket',$ticket);
    }

    public function addPLDTTicket(Request $request)
    {
        $validation = [
            'to' => 'required|string',
            'subject' => 'required|string|min:5',
            'details' => 'required|string|min:5',
            'branch' => 'required|numeric',
            'contact' => 'required|string|min:5',
            'type' => 'required|string'
        ];

        $voice =  ['dial' => 'required|string|min:5'];


        $data = ['pid' => 'required|string|min:5'];

        /*GET CATEGORY B id*/
        $catB = CategoryC::findOrFail($request->concern)->catB;

        /*16 IS THE ID OF THE CATEGORY B VOICE*/
        if($catB === 16){
            $validation = $validation + $voice;
            $request->request->add(['type' => 'voice']);
        }elseif ($catB === 17){
            $validation = $validation + $data;
            $request->request->add(['type' => 'data']);
        }else{
            $request->request->add(['type' => 'both']);
            $validation = $validation + $data + $voice;
        }

        $request->validate($validation);

        $to = explode(',',$request->to);
        Mail::to($to)->send(new PLDTIssue($request));
    }

    public function editStatus(StoreTicket $request,$id){
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 4;
        $ticket->fixed_date = Carbon::now();
        $ticket->save();
    }

    public function reject(Request $request,$id){
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 5;
        $ticket->save();
        $rejected_by = Auth::id();
        $ticket->rejectData()->create(['reason' => $request->reason,'rejected_by' => $rejected_by]);

        return redirect()->route('lookupTicketView',['id' => $id]);
    }

    public function extend(Request $request){
        dd($request->all());
    }

    public function rejectForm($id){
        return view('modal.rejectForm',['id' => $id]);
    }

    public function rejectFormDetails($id){
        $ticket = Ticket::findOrFail($id);
        $rejectData = $ticket->rejectData->first();
        return view('modal.reject_lookup',compact('ticket','rejectData'));
    }

    public function getExtendForm($id){
        return view('modal.extendForm',['id' => $id]);
    }

    public function ticketExtendDetails($id){
        return view('ticketExtendDetails');
    }
}
