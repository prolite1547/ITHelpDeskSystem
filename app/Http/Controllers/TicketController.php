<?php

namespace App\Http\Controllers;

use App\Call;
use App\Incident;
use App\Ticket;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }



    public function lookupView($id){

        $ticket = Ticket::findOrFail($id);

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
            $call->incident()->create($request->only('subject','details','category','catA','catB'))->ticket()->create($request->only('type','priority','assignee','status'));

            /*ID OF THE TICKET INSERTED*/
            $insertedTicketID = $call->incident->ticket->id;

            /*CREATE DIRECTORY NAME*/
            $ticketDirectoryName =  str_replace(':','',preg_replace('/[-,\s]/','_',$call->incident->ticket->created_at)) . '_' .$insertedTicketID;

            /*CHECK IF REQUEST CONTAINS A FILE AND STORE IT*/
            if ($request->hasFile('attachments')) {
                foreach ($request->attachments as $attachment){
                    $attachment->storeAs('files/ticket_attachments/'.$ticketDirectoryName.'',$attachment->getClientOriginalName());
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

    public function forVerification(){

        return view('ticket.openTickets');
    }

    public function closed(){

        return view('ticket.openTickets');
    }

    public function userTickets(){

        return view('ticket.openTickets');
    }

    public function all(){

        return view('ticket.openTickets');
    }

}
