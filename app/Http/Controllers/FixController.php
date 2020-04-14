<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFix;
use App\Ticket;
use App\ItemRepair;
use Illuminate\Http\Request;

class FixController extends Controller
{
    public function __construct()
    {
        return $this->middleware(['auth','check.role']);
    }

    public function create(StoreFix $request,$id)
    {   
        if($request->fix_category == '23'){
            $itemrepair = ItemRepair::where('ticket_id','=',$id)->count();
            if($itemrepair <= 0){
                return response()->json(array('result'=>'Please add repaired items on ticket details', 'able'=>false), 200);
            }
        }
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 4;
        $ticket->save();
        /*GET ID OF THE USER WHO RESOLVED THE TICKET*/
        $request->request->add(['fixed_by' => $request->user()->id]);
        $resolve = $ticket->fixTicket()->create($request->except('_token'));

        return response()->json(array('result'=>'Ticket marked as fixed successfully!!','able'=>true), 200);

    }

    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        $fix = $ticket->fixTicket()->latest('created_at')->first();
        return view('modal.fix_lookup')->with(compact('ticket','fix'));
    }
}
