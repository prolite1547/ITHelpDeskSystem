<?php

namespace App\Http\Controllers;
use App\Workstation;
use Illuminate\Http\Request;

class WorkstationController extends Controller
{
    public function getModal(){
        return view('modal.add_ws');
    }

    public function getUpdateModal($wid){
        $ws = Workstation::find($wid);
        return view('modal.edit_ws', ['ws'=>$ws]);
    }

    public function addWorkstation(Request $request){
        $ws = Workstation::create($request->only(['ws_description', 'store_id', 'department_id']));
        if($ws){
            return redirect()->back();
        }else{
            return response('Couldnt create new workstation', 400);
        }
    }

    public function deleteWorkstation($wid)
    {
        $ws = Workstation::find($wid)->delete();
        if($ws){
            return response('Sucessfully deleted', 200);
        }else{
            return response('Couldnt create new workstation', 400);
        }
    }

    public function editWorkstation(Request $request){
        $ws = Workstation::find($request->id);
        $ws->ws_description = $request->ws_description;
        $ws->store_id = $request->store_id;
        $ws->department_id = $request->department_id;
        if($ws->save()){
            return redirect()->back();
        }else{
            return response('unable to update workstation', 400);
        }
    
    }
}
