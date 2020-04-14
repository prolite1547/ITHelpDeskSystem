<?php

namespace App\Http\Controllers;

use App\Contact;
use App\ContactPerson;
use App\Http\Requests\StoreContact;
use App\Http\Requests\StoreContactPerson;
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

    public function addContactPerson(StoreContactPerson $request){
        ContactPerson::create($request->except('_token'));
    }

}
