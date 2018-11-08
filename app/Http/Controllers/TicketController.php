<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Category;
use Illuminate\Http\Request;
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

    public function addView(){
        return view('ticket.add_ticket');
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
