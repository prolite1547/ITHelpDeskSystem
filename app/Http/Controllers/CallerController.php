<?php

namespace App\Http\Controllers;

use App\Caller;
use App\Http\Requests\StoreCaller;
use Illuminate\Http\Request;

class CallerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(StoreCaller $request){

        $caller = Caller::create($request->except('_token'));
    }
}
