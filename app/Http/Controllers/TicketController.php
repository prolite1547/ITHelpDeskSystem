<?php

namespace App\Http\Controllers;

use App\Call;
use App\File;
use App\Incident;
use App\Ticket;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'incident.getFiles'
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

    public function addTicket(Request $request){


        if($request->isMethod('GET')){

            $userID = Auth::user()->id;
            $selfOption = [null => 'None',$userID => 'Self'];

            return view('ticket.add_ticket',['selfOption' => $selfOption]);
        }else if($request->isMethod('POST')) {


            /*GET ID OF THE USER WHO ADDED THE TICKET*/
            $request->request->add(['user_id'=>$request->user()->id]);

            /*GET ID'S OF THE OPEN AND ONGOING CATEGORY IN THE CATEGORY TABLE*/
            $openID = Category::where('name','like','Open')->first()->id;
            $ongoingID = Category::where('name','like','Ongoing')->first()->id;


            /*CHECK IF THE STATUS OF TICKET WILL BE OPEN OR ONGOING*/
            if(!$request->assignee){
                $request->request->add(['status'=>$openID]);
            }else {
                $request->request->add(['status'=>$ongoingID]);
            }

            /*INSERT CALL TO THE DATABASE AND TO ITS RELATED TABLES*/
            $call = Call::create($request->only('caller_id','user_id','contact_id'));
            $call->incident()->create($request->only('subject','details','category','catA','catB'))
                 ->ticket()->create($request->only('type','priority','assignee','status'));


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

            return redirect()->route('lookupTicketView',['id' => $insertedTicketID]);
        }

    }

    public function open(){

        return view('ticket.openTickets');
    }

    public function ongoing(){

        return view('ticket.ongoingTickets');
    }

    public function closed(){

        return view('ticket.closedTickets');
    }

    public function all(){

        return view('ticket.allTickets');
    }

    public function forVerification(){

        return view('ticket.openTickets');
    }

    public function userTickets(){

        return view('ticket.openTickets');
    }

    public function delete($id){

        $ticket = Ticket::findOrFail($id)->delete();
//        $ticket = Ticket::findOrFail($id)->incident->call->delete();

        return redirect()->route('openTickets');
    }

    public function edit($id,Request $request){
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

}
