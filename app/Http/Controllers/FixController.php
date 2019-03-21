<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFix;
use App\Ticket;
use Illuminate\Http\Request;

class FixController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function create(StoreFix $request,$id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->status = 4;

        $ticket->save();

        /*GET ID OF THE USER WHO RESOLVED THE TICKET*/
        $request->request->add(['fixed_by' => $request->user()->id]);

        $resolve = $ticket->fixTicket()->create($request->except('_token'));


    }

    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        $fix = $ticket->fixTicket()->latest('created_at')->first();
        return view('modal.fix_lookup')->with(compact('ticket','fix'));
    }
}
