<?php

namespace App\Http\Controllers;

use App\PldtId;
use Illuminate\Http\Request;

class PidController extends Controller
{
    public function store(Request $request){
      PldtId::create($request->except('_token'));
    }
}
