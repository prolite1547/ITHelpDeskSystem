<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePassRequest;
use App\Http\Requests\StoreUser;
use App\Http\Resources\UserResource;
use App\TempUser;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Hash;
use PDO;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(StoreUser $request){

        TempUser::create()->user()->create($request->except('_token'));

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

    public function modalChangePass($id){
        return view('modal.change_pass');
    }

    public function changePass(ChangePassRequest $request){
    
        // $user = User::find($request->user_id)->get();
        // $user->password = Hash::make($request->new_pass);
        // $user->save();

        return response()->json(array(['success'=>true, 'data'=> $request->user_id]), 200);
    }

    public function checkPass(ChangePassRequest $request){
        $current_user = User::find($request->user_id);        
        if(Hash::check($request->old_pass, $current_user->password)){
            $current_user->password = Hash::make($request->new_pass);
            $current_user->save();
            return response()->json(array('success'=>true, 'text'=> 'User password has been successfully updated..'), 200);
        }
        return response()->json(array('success'=>false,'text'=>'Old password is incorrect..'), 200);
    }

    public function getOracleUsers(){
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_CASE => PDO::CASE_LOWER,
        ];
        try {
            $myServer = '192.168.3.101';
            $myDB = 'dev';
            $oci_uname = 'appsro';
            $oci_pass = 'appsro';
            $tns = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$myServer.")(PORT = 1521)))(CONNECT_DATA=(SID=".$myDB.")))";

            $conn = new PDO("oci:dbname=".$tns, $oci_uname, $oci_pass,$options);
            
        
        } catch(PDOException $e) {
            return  'ERROR: ' . $e->getMessage();
        }

    }
}
