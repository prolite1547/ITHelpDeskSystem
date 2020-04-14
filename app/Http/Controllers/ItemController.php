<?php

namespace App\Http\Controllers;

use App\Item;
use App\Workstation;
use App\ItemRepair;
use App\Ticket;
use App\ItemHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function getCompoModal($id){
        $ws = Workstation::find($id)->first();
        return view('modal.parts_compo')->with('ws',$ws);
    }
    
    public function getModal($wid){
        $workstation = Workstation::findorfail($wid);
        return view('modal.add_ws_item', [
            'wid'=> $wid,
            'workstation'=> $workstation
            ]);
    }

    public function addItem(Request $request){
        $item = Item::create($request->only(['workstation_id', 'serial_no', 'item_description', 'itemcateg_id', 'date_used']));
        if($item){
            return $item->id;
        }else{
            return response('Failed to add new item to Workstation', 400);
        }
    }

    public function getrepairedModal($tid, $sid){
        $workstation = Workstation::where('store_id', '=', $sid)->whereNull('deleted_at')->pluck('ws_description','id');
        $ticket = Ticket::findorFail($tid);
        // $repairs = ItemRepair::where('ticket_id', '=', $id)->first();
          
        return view('modal.item_repaired', ['ticket_id'=>$tid, 'workstations'=>$workstation , 'ticket'=>$ticket]);
    }

    public function getItemsfromWS($wid){
        $ws_items = \App\Item::where('workstation_id', '=', $wid)->get(['id','item_description']);
        return ($ws_items) ?  response()->json($ws_items) : response('Failed to Get Items from Workstation',404);

    }

    public function getSerial(Request $request){
        $items = Item::find($request->id);
        $serial = $items->serial_no;
       if($items){
            return $serial;
       }
       return '';
    }

    public function addrepairedItem(Request $request){
        $itemRepair = ItemRepair::create($request->only(['ticket_id', 'workstation_id', 'item_id', 'reason', 'date_repaired']));
        if($itemRepair){
            $item_id = $itemRepair->item_id;
            $item = Item::find($item_id);
            $currentRepair = $item->no_repaired;
            $item->no_repaired = $currentRepair + 1;
            $item->save();
            
            if($itemRepair->id){
                $item_history = ItemHistory::create([
                    'ticket_id'=>$itemRepair->ticket_id,
                    'serial_no_old'=>$itemRepair->item->serial_no,
                    'item_desc_old'=>$itemRepair->item->item_description,
                    'item_id'=>$itemRepair->item_id,
                    'action'=>'Repaired',
                    'user_id'=>Auth::user()->id
                ]);
                if($item_history) return $itemRepair->id;
            }
        }
            return response('Unable to add item to list', 400);
    }
}
