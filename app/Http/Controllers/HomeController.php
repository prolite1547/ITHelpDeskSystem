<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function maintenance(){
        return view('maintenance');
    }

    public function search(Request $request){
        $search_results = DB::table('incidents')
            ->select(['tickets.id','subject','details'])
            ->join('tickets','tickets.incident_id','=','incidents.id')
            ->whereRaw("concat_ws(' ',tickets.id,incidents.subject,incidents.details) LIKE '%$request->q%'")
            ->get();

        return view('search')->with(compact('search_results'));
    }
}
