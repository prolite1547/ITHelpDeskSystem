<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePosition;
use App\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','check.role']);
    }

    public function create(StorePosition $request){
        Position::create($request->except('_token'));
    }
}
