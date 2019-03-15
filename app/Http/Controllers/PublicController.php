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




}
