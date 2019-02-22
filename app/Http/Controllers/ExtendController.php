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
        $this->middleware('auth');
    }

    public function create(Request $request,$id){
        $duration = Expiration::findOrFail($request->duration)->expiration;
        DB::transaction(function () use($request,$id,$duration){

            $request->request->add(['extended_by' => $request->user()->id]);
            $ticket = Ticket::findOrFail($id);
            $ticket->status = 2;
            $ticket->expiration = Carbon::now()->addHours($duration);
            $ticket->save();

            $ticket->extended()->create($request->except('_token'));
        });

        return redirect()->back();

    }
}
