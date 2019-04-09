<?php

namespace App\Http\Controllers;

use App\Expiration;
use App\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExtendController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','check.role']);
    }

    public function create(Request $request,$id){
        $duration = Expiration::findOrFail($request->duration)->expiration;
        DB::transaction(function () use($request,$id,$duration){

            $request->request->add(['extended_by' => $request->user()->id]);
            $ticket = Ticket::findOrFail($id);

            (is_null($ticket->assignee)) ? $status = 1 : $status = 2;

            $ticket->status = $status;
            $ticket->expiration = Carbon::now()->addHours($duration);
            $ticket->save();

            $ticket->extended()->create($request->except('_token'));
        });

        return redirect()->back();

    }
}
