<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(StoreUser $request){

         User::create($request->except('_token'));

    }

    public function profile($id){

        $user = User::findOrFail($id);

        return view('user_profile',with(['user' => $user]));
    }

    public function changeProf(Request $request){
        $userID = $request->user()->id;
        $file = $request->image->store($userID,'profpic');


        $user = User::findOrFail($userID);
        $prevImage = $user->profpic->image;


        if($prevImage !== 'default.png') {
            Storage::disk('profpic')->delete($prevImage);
        }


            $user->profpic->update(['image' => $file])->save();
    }

    public function userAPI($id){
        return new UserResource(User::find($id));
    }
}
