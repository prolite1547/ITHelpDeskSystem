<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','check.role']);
    }

    public function index(){

        return view('adminPage');
    }

    public function report(){
        return view('report');
    }
}
