<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Workstation;
use App\Canvass;
use App\Item;
use App\CanvassForm;
use App\CanvassAttachments;
use App\ItemHistory;
use App\Ticket;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\RedirectMiddleware;

class CanvassController extends Controller
{
    public function showCanvassForm($tid){
        $posted = 0;
        $canvass_form = CanvassForm::where('ticket_id', '=', $tid)->first();
        $ticket = TIcket::findorFail($tid);
        $status = ['3','4','6'];
 
        if($canvass_form){
            $posted = $canvass_form->posted;
        }
        if(in_array($ticket->status,$status)){
            $posted = 1;
        }

        return view('modal.canvass_form', [
            'tid'=>$tid, 
            'canvass_form'=>$canvass_form, 
            'posted'=>$posted
            ]);
    }

    public function showAddCitem($sid, $tid){
        $workstation = Workstation::where('store_id', '=', $sid)->whereNull('deleted_at')->pluck('ws_description','id');
         
        return view('modal.canvass_item', ['workstations'=>$workstation, 'ticket_id'=>$tid]);
    }

    public function showUpdateCitem($id, $sid){
        $workstation = Workstation::where('store_id', '=', $sid)->pluck('ws_description','id');
        $canvass = Canvass::where('id', '=', $id)->first();
        $items = Item::where('workstation_id', '=', $canvass->item->workstation_id)->pluck('item_description', 'id');
        return view('modal.canvass_item_update', ['canvass'=>$canvass, 'workstations'=>$workstation, 'items'=>$items]);
    }

    public function addToCanvass(Request $request){
        $canvassItem = Canvass::create($request->only(['ticket_id', 'c_storename','c_serial_no', 'c_itemdesc', 'c_qty', 'c_price', 'purchase_date', 'date_installed', 'item_id', 'is_approved', 'approval_id', 'app_code']));
        if($canvassItem->id){
            return response()->json(array('success'=>true, 'result'=>'Item successfully added to canvass'), 200);
        }
            return response()->json(array('success'=>false, 'result'=>'Failed to add item'), 400);
    }

    public function updateItemCanvass(Request $request){
        $canvass = Canvass::findorFail($request->id);
        $canvass->update($request->only(['ticket_id', 'c_storename','c_serial_no', 'c_itemdesc', 'c_qty', 'c_price', 'purchase_date', 'date_installed', 'item_id', 'is_approved', 'approval_id', 'app_code']));
        if($canvass){
            return response()->json(array('success'=>true, 'result'=>'Item successfully updated'), 200);
        }
            return response()->json(array('success'=>false, 'result'=>'Failed to update item'), 400);
    }

    public function deleteItemCanvass($id){
        $canvass = Canvass::find($id)->delete();
        if($canvass){
            return response()->json(array('success'=>true, 'result'=>'Item successfully deleted'), 200);
        }
            return response()->json(array('success'=>false, 'result'=>'Failed to delete item'), 400);
    }

    public function postCanvass(Request $request){
           
            $canvass = Canvass::where('ticket_id','=', $request->ticket_id)->where('is_approved','=','1')->whereNull('deleted_at')->count();
            if($canvass > 0){
                $c_form = CanvassForm::create($request->only(['ticket_id', 'remarks', 'purpose', 'posted']));
                if($c_form->id){
                    if($request->upfile){
                        foreach($request->upfile as $file){
                                $route = 'public/canvass/' . $c_form->id;
                                $fileNamewithExtension = $file->getClientOriginalName();
                                $fileName = pathinfo($fileNamewithExtension, PATHINFO_FILENAME);
                                $fileExtension = $file->getClientOriginalExtension();
                                $fileNametoStore = $fileName . '_'. time() .'.'.$fileExtension;
                                $mime_type = $file->getMimeType();
                                $path = $file->storeAs($route,$fileNametoStore);
                                $storedPath = $c_form->id.'/'.$fileNametoStore;
                                CanvassAttachments::create(['path' => $storedPath,'original_name' => $fileNametoStore,'mime_type' => $mime_type,'extension' => $fileExtension, 'canvass_form_id'=>$c_form->id]);
                        }
                     }
                     $app_canvass = Canvass::where('ticket_id','=', $request->ticket_id)->where('is_approved','=','1')->whereNull('deleted_at')->get();
                     foreach($app_canvass as $c){
                        ItemHistory::create([
                            'ticket_id'=>$c->ticket_id,
                            'serial_no_old'=>$c->item->serial_no,
                            'item_desc_old'=>$c->item->item_description,
                            'item_id'=>$c->item_id,
                            'action'=>'Replaced',
                            'serial_no_new'=>$c->c_serial_no,
                            'item_replaced'=>$c->c_itemdesc,
                            'user_id'=>Auth::user()->id
                        ]);

                        $item2replaced = Item::find($c->item_id);
                        $item2replaced->no_replace =  $item2replaced->no_replace + 1;
                        $item2replaced->serial_no = $c->c_serial_no;
                        $item2replaced->item_description = $c->c_itemdesc;
                        $item2replaced->save();
                    }
 
                    //  return redirect()->back();
                    return response()->json(array('success'=>true, 'result'=>'Canvass has been successfully posted'), 200);
                }else{
                    return response()->json(array('success'=>false, 'result'=>'Fails to post canvass'), 200);
                }
               
            }
                return response()->json(array('success'=>false, 'result'=>'Failed to post canvass, please check your canvass form'),200);
    }


    



}
