<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;

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
        return view('dashboard');
    }

    public function maintenance(){
        return view('maintenance');
    }

    public function search(Request $request){
        $ticket = Ticket::find($request->q);

        return view('search')->with(compact('ticket'));
    }
}
