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

            $request->request->add(['user_id'=>$request->user()->id]);
            $openID = Category::where('name','like','Open')->first()->id;
            $ongoingID = Category::where('name','like','Ongoing')->first()->id;

            if(!$request->assignee){
                 $request->request->add(['status'=>$openID]);
            }else {
                 $request->request->add(['status'=>$ongoingID]);
            }
            $call = Call::create($request->only('caller_id','user_id','contact_id'));
            $call->incident()->create($request->only('subject','details','category','catA','catB'))->ticket()->create($request->only('type','priority','assignee','status'));

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
