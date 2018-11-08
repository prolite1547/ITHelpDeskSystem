<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('login');
    }



    public function login(){
        return view('welcome');
    }

    public function dashboard(){
        return view('dashboard');
    }




}
