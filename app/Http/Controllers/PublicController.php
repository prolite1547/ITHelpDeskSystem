<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('login');
    }



    public function login(){
        if(Auth::check()){
            return redirect()->route('dashboard');
        }

        return view('welcome');
    }

    public function dashboard(){
        return view('dashboard');
    }


    public function treasuryDashboard(){
        return view('treasury.dashboard');
    }

    public function publicDashboard(){
        Auth::logout();
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
