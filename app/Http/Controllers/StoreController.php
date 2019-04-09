<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBranch;
use App\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','check.role']);
    }

    public function create(StoreBranch $request) {

        $store = Store::create($request->except('_token'));
    }


    public function storeContacts($id){
        $store = $store = Store::whereId($id)->with('contacts')->first();;

        return view('modal.storeContacts',compact('store'));
    }
}
