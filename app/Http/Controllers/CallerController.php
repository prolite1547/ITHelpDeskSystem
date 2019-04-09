<?php

namespace App\Http\Controllers;

use App\Caller;
use App\Http\Requests\StoreCaller;


class CallerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','check.role']);
    }

    public function create(StoreCaller $request){

        Caller::create($request->except('_token'));
    }
}
