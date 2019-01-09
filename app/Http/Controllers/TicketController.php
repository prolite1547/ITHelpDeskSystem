<?php

namespace App\Http\Controllers;

use App\Call;
use App\CategoryB;
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

    public function getTicket($id){

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

    public function lookupView($id){

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

//            dd($ticket->incident->id);
        return view('ticket.ticket_lookup',['ticket' => $ticket]);
    }

    public function addTicketView(Request $request){
        $userID = Auth::user()->id;
        $selfOption = [null => 'None',$userID => 'Self'];

        return view('ticket.add_ticket',['selfOption' => $selfOption]);
    }

    public function addTicket(StoreTicket $request){


            /*FETCH THE EXPIRATION HOURS COLUMN*/
            $expiration_hours = CategoryB::findOrFail($request->catB)->expiration;
            $catA = CategoryB::findOrFail($request->catB)->group->id;

            /*GENERATE TE EXPIRATION DATE*/
            $expiration_date = Carbon::now()->addHours($expiration_hours);


            /*ADD EXPIRATION IN REQUEST ARRAY*/
            $request->request->add(array('expiration' => $expiration_date,'catA' => $catA));


            /*GET ID OF THE USER WHO ADDED THE TICKET*/
            $request->request->add(['user_id'=>$request->user()->id]);

            /*GET ID'S OF THE OPEN AND ONGOING CATEGORY IN THE CATEGORY TABLE*/
            $openID = Status::where('name','like','Open')->first()->id;
            $ongoingID = Status::where('name','like','Ongoing')->first()->id;


            /*CHECK IF THE STATUS OF TICKET WILL BE OPEN OR ONGOING*/
            if(!$request->assignee){
                $request->request->add(['status'=>$openID]);
            }else {
                $request->request->add(['status'=>$ongoingID]);
            }

            /*INSERT CALL TO THE DATABASE AND TO ITS RELATED TABLES*/
            $insertedTicketID = DB::transaction(function () use ($request) {
                $call = Call::create($request->only('caller_id','user_id','contact_id'));
                $call->incident()->create($request->only('subject','details','category','catA','catB'))
                    ->ticket()->create($request->only('expiration','type','priority','assignee','status'));


                /*ID OF THE TICKET INSERTED*/
                $insertedTicketID = $call->incident->ticket->id;

                /*CREATE DIRECTORY NAME*/
                $ticketDirectoryName =  str_replace(':','',preg_replace('/[-,\s]/','_',$call->incident->ticket->created_at)) . '_' .$insertedTicketID;

                /*CHECK IF REQUEST CONTAINS A FILE AND STORE IT*/
                if ($request->hasFile('attachments')) {
                    foreach ($request->attachments as $attachment){

                        $original_name = $attachment->getClientOriginalName();
                        $mime_type = $attachment->getMimeType();
                        $original_ext = $attachment->getClientOriginalExtension();
                        $path = $attachment->store("$ticketDirectoryName",'ticket');

                        File::create(['incident_id' => $insertedTicketID,'path' => $path,'original_name' => $original_name,'mime_type' => $mime_type,'extension' => $original_ext]);
                    };
                }

                return $insertedTicketID;

            });



            return redirect()->route('lookupTicketView',['id' => $insertedTicketID]);



    }

    public function open(){

        $ticketTotals = ticketTypeCount('status',1);

        return view('ticket.openTickets',$ticketTotals);
    }

    public function ongoing(){

        $ticketTotals = ticketTypeCount('status',2);
        return view('ticket.ongoingTickets',$ticketTotals);
    }

    public function closed(){

        $ticketTotals = ticketTypeCount('status',3);
        return view('ticket.closedTickets',$ticketTotals);
    }

    public function all(){

        $ticketTotals = ticketTypeCount('all');
        return view('ticket.allTickets',$ticketTotals);
    }

    public function forVerification(){

        return view('ticket.openTickets');
    }

    public function userTickets(){
        $ticketTotals = ticketTypeCount('user',Auth::id());
        return view('ticket.myTickets',$ticketTotals);
    }

    public function delete($id){

        $ticket = Ticket::findOrFail($id)->delete();
//        $ticket = Ticket::findOrFail($id)->incident->call->delete();

        return redirect()->route('openTickets');
    }

    public function edit($id,StoreTicket $request){
        try{
            DB::beginTransaction();
            $bool = true;
            if($request->filled(['incident'])){
                $incident = Ticket::findOrFail($id)->incident;

                foreach ($request->incident as $key => $value){
                    $incident->$key = $value;
                }
                $incident->save();

            }

            if ($request->filled(['ticket'])){
                $ticket = Ticket::findOrFail($id);
                foreach ($request->ticket as $key => $value){
                    $ticket->$key = $value;
                }
                $ticket->save();
            }

            if ($request->filled(['fileID'])){
                foreach ($request->fileID as $id){
                    $file = File::findOrFail($id);
                    if(Storage::disk('ticket')->delete($file->path))$file->delete();
                }
            }

            DB::commit();
        }catch(\Exception $e){
            $bool = false;
            DB::rollback();
        }




        return response()->json(['success' => $bool]);

    }

    public function editModal($id){
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
        $view = view('modal.ticket_edit',['ticket' => $ticket]);
        $viewString = strlen($view->render());
        return response()->view('modal.ticket_edit',['ticket' => $ticket])->header('Content-Encoding','none')->header('Content-Length',$viewString);
    }

    public function addFile($id,Request $request){

        $ticket = Ticket::findOrFail($id);
        $destination = $ticket->getFileDirectoryFolder();

        foreach ($request->file as $attachment){

            $original_name = $attachment->getClientOriginalName();
            $mime_type = $attachment->getMimeType();
            $original_ext = $attachment->getClientOriginalExtension();
            $path = $attachment->store($destination,'ticket');

            File::create(['incident_id' => $ticket->incident->id,'path' => $path,'original_name' => $original_name,'mime_type' => $mime_type,'extension' => $original_ext]);
        };
    }

    public function print($id){
        $ticket = Ticket::findOrFail($id);
        return view('layouts.ticketPrint')->with(compact('ticket'));
    }

    public function addPLDTTicket(Request $request){
        Mail::to($request->to)->send(new PLDTIssue());
    }

}
