<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBranch;
use App\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(StoreBranch $request) {

        $store = Store::create($request->except('_token'));
    }
}
