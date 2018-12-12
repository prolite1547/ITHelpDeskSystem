<?php

namespace App\Http\Controllers;

use App\Caller;
use App\Contact;
use App\Http\Resources\CallerCollection;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\StoreCollection;
use App\Role;
use App\Store;
use Illuminate\Http\Request;

class SelectController extends Controller
{

    public function branch(Request $request){

        if($request->query('q')){
            return new StoreCollection(Store::where('store_name','LIKE', "%{$request->query('q')}%")->get(['id' ,'store_name as text']));
        }else{
            return new StoreCollection(Store::all(['id' ,'store_name as text']));
        }

    }

    public function caller(Request $request){

        if($request->query('q')){
            return new CallerCollection(Store::with('callers')->whereHas('callers',function ($query) use($request){
                $query->where('name', 'like', "%{$request->query('q')}%");
            })->get());
        }else{
            return new CallerCollection(Store::with('callers')->get());
        }


    }

    public function contact(Request $request){

        if($request->query('q')){
            return new ContactCollection(Store::with('contactNumbers')->whereHas('contactNumbers',function ($query) use($request){
                $query->where('number', 'like', "%{$request->query('q')}%");
            })->get());
        }else{
            return new ContactCollection(Store::with('contactNumbers')->get());
        }


    }
}
