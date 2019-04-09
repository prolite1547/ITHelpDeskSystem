<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests\StoreContact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','check.role']);
    }

    public function create(StoreContact $request){
        Contact::create($request->except('_token'));
    }

}
