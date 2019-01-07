<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DCController extends Controller
{
     public function index(){
         return view('datacorrections.datacorrections');
     }

     public function system(){
        return view('datacorrections.systemdcs');
     }

     public function manual(){
        return view('datacorrections.manualdcs');
     }
}
