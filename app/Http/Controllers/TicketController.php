<?php

namespace App\Http\Controllers;

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
        if($request->isMethod('get')){
            $userID = Auth::user()->id;
            $selfOption = [0 => 'None',$userID => 'Self'];
            return view('ticket.add_ticket',['selfOption' => $selfOption]);
        }else {
            $call = Call::create($request->only('caller_id','user_id','store_id'));
        }

    }

    public function open(){

        return view('ticket.openTickets');
    }

    public function ongoing(){

        return view('ticket.openTickets');
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
