<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SystemDataCorrection;
use App\ManualDataCorrection;
use App\Ticket;
use App\Department;
use App\Position;
use App\SDCAttachment;
use App\AppHerGroup;
use App\Store;
use App\Accumulators;

 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class SDCController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index()
    {   
        // return view('datacorrections.system');
         
    }

    
    public function create()
    {   
        $sdc = SystemDataCorrection::orderBy('created_at','desc')->first();
        $departments = Department::all();
        return view('datacorrections.system')->with('sdc',$sdc)->with('departments',$departments);
         
    }

    
    public function store(Request $request)
    {   

        
        $user_id = 0;
       
        $action = $request->action;
  
         
        $status;
        $files = "";


        if($action == "SAVE"){
            $status = 0;
            $posted = 0;
        }else{
            $status = 1;
            $user_id = Auth::user()->id;
        }
  
        $sdc = new SystemDataCorrection();
        $sdc->ticket_no = $request->ticketno; 
        $sdc->date_submitted = $request->datesubmitted;
        $sdc->requestor_name = $request->requestor;
        $sdc->dept_supervisor = $request->supervisor;
        $sdc->department = $request->department;
        $sdc->position = $request->position;

        //DETAILS
        $sdc->affected_ss = $request->affected;
        $sdc->terminal_name =  $request->terminalname;
        $sdc->findings_recommendations = $request->dfindings;
        $sdc->ticket_created = $request->ticket_created;
        $sdc->status = $status;
       

        if($request->app_group != "CUS"){
            $group = $request->app_group;
            $appGroup = AppHerGroup::where('group','=',$group)->first();
            $s_heirarchy = $appGroup->s_heirarchy;
            $unserializedHer = unserialize($s_heirarchy);
            $forward_status = $unserializedHer[0];
            
            $sdc->h_group = $group;
            $sdc->hierarchy = $s_heirarchy;


            if($action == "SAVE"){
                $sdc->forward_status = 0;
            }else{
                $sdc->forward_status = $forward_status;
            }  
           
        }else{
            $unserialized_array = array();
            $group = $request->app_group;
            if($request->approver1 != '0'){
                array_push($unserialized_array, (int)$request->approver1);
            }
            if($request->approver2 != '0'){
                array_push($unserialized_array, (int)$request->approver2);
            }
            if($request->approver3 != '0'){
                array_push($unserialized_array, (int)$request->approver3);
            }
            if($request->approver4 != '0'){
                array_push($unserialized_array, (int)$request->approver4);
            }
            $custom_her = serialize($unserialized_array);
            $sdc->h_group = $group;
            $sdc->hierarchy = $custom_her;
            $forward_status = $unserialized_array[0];

            if($action == "SAVE"){
                $sdc->forward_status = 0;
            }else{
                $sdc->forward_status = $forward_status;
            }  
        }
        $sdc->posted_by =  $user_id;

        if($sdc->save()){
            $sdc->sdc_no = "SDC".$sdc->id;
            $sdc->save();
        }

       

        // $sdc = SystemDataCorrection::orderBy('created_at','desc')->first();
        // $sdc->sdc_no =  "SDC".$sdc->id;
        // $sdc->save();


        if(isset($request->upfile)){
            foreach($request->upfile as $file){
                   // Get filename including its extension
                    $fileNamewithExtension = $file->getClientOriginalName();
                    // Get just filename
                    $fileName = pathinfo($fileNamewithExtension, PATHINFO_FILENAME);
                    // Get just extension
                    $fileExtension = $file->getClientOriginalExtension();
                    // Filename to Store
                    $fileNametoStore = $fileName . '_'. time() .'.'.$fileExtension;
                    //Mime Type
                    // $mime_type = $file->getMimeType();
                    //Upload image
                    $path = $file->storeAs('public/sdc_attachments',$fileNametoStore);
                    // $path1 = "/storage/sdc_attachments/". $fileNametoStore;

                    SDCAttachment::create(['sdc_no' => $request->sdc_id,'path' => $path,'original_name' => $fileNametoStore,'mime_type' => '','extension' => $fileExtension, 'role_id'=>Auth::user()->role_id]);
    
            }
       }

        return redirect()->route('lookupTicketView', ['id'=> $request->ticketno]);
   
    

     

    }

    
    public function show($id)
    {
        $checkMDC = ManualDataCorrection::where('ticket_no', $id)->get();
        $checkSDC = SystemDataCorrection::where('ticket_no', $id)->get();
  
           if(count($checkMDC) <= 0 && count($checkSDC) <= 0 ){
                $sdc = SystemDataCorrection::orderBy('created_at','desc')->first();
                $accum = Accumulators::all();
                $departments = Department::all();
                $appGroup = AppHerGroup::all();
                $positions = Position::all();
                $ticket = Ticket::find($id);
                $stores = Store::all();
                return view('datacorrections.system')
                ->with('sdc',$sdc)->with('ticket', $ticket)
                ->with('departments', $departments)
                ->with('positions',  $positions)
                ->with('appgroup',$appGroup)
                ->with('stores',$stores);
          }else{
              return redirect()->back();
          }
    }

   
    public function edit($id)
    {
        return view('datacorrections.sdcupdate')
        ->with('sdc',SystemDataCorrection::find($id))
        ->with('departments', Department::all())
        ->with('positions', Position::all())
        ->with('appgroup',AppHerGroup::all())
        ->with('stores', Store::all());
    }
 
    public function update(Request $request, $id)
    {     

          
          $post = 1;
          $status = 0;
          $action = $request->action;
          $role_id = $request->role_id;
          $user_id = 0;
          $forward_status;

            if(isset($request->forwardto)){
                $forward_status = $request->forwardto;
            }
         
          switch($action){
                
                case "REJECT":
                     $status = 2;
                break;
                case "APPROVE DATA CORRECTION":
                        $status = 3;
                break;
                case "POST DATA CORRECTION":
                       $status = 1;
                break;
                case "SUBMIT DATA CORRECTION":
                      $status = 1;
                break;
                case "SUBMIT":
                      $status = 4;
                break;
          }

        

          $sdc = SystemDataCorrection::find($id);
          $sdcstatus = $sdc->status;

          //   SUPPORTS UPDATES
          if(($role_id < 5 AND ($status == 0 OR $status == 1))){
               $sdc->ticket_no = $request->ticketno;
                $sdc->date_submitted = $request->datesubmitted;
                $sdc->requestor_name = $request->requestor;
                $sdc->dept_supervisor = $request->supervisor;
                $sdc->department = $request->department;
                $sdc->position = $request->position;
                 //DETAILS
                $sdc->affected_ss = $request->affected;
                $sdc->terminal_name = $request->terminalname;
                $sdc->findings_recommendations = $request->dfindings;
                $sdc->rejection = null;

                if($request->app_group != "CUS"){
                    $group = $request->app_group;
                    $appGroup = AppHerGroup::where('group','=',$group)->first();
                    $s_heirarchy = $appGroup->s_heirarchy;
                    $unserializedHer = unserialize($s_heirarchy);
                    $forward_status = $unserializedHer[0];
                    
                    $sdc->h_group = $group;
                    $sdc->hierarchy = $s_heirarchy;

                    if($action == "SAVE"){
                        $sdc->forward_status = 0;
                    }else{
                        $sdc->forward_status = $forward_status;
                    }


                }else{
                    $unserialized_array = array();
                    $group = $request->app_group;
                    if($request->approver1 != null){
                        array_push($unserialized_array, (int)$request->approver1);
                    }
                    if($request->approver2 != null){
                        array_push($unserialized_array, (int)$request->approver2);
                    }
                    if($request->approver3 != null){
                        array_push($unserialized_array, (int)$request->approver3);
                    }
                    if($request->approver4 != null){
                        array_push($unserialized_array, (int)$request->approver4);
                    }
                    $custom_her = serialize($unserialized_array);
                    $sdc->h_group = $group;
                    $sdc->hierarchy = $custom_her;
                    $forward_status = $unserialized_array[0];


                    if($action == "SAVE"){
                        $sdc->forward_status = 0;
                    }else{
                        $sdc->forward_status = $forward_status;
                    }
                 
                    
                }

                
                if($status != 2 AND $status != 0 AND $sdcstatus != 2){
                    $sdc->posted_by =  Auth::user()->id;
                }
          }
          //  END
         
         
        //   TREASURY SUBMITTED DATA
        if($role_id == 5){  
                //HARD COPY FOR POS
                $forward_status;

                $sdc->hc_last_z_reading = $request->hclastzreading;
                $sdc->hc_last_dcr = $request->hclastdcr;
                $sdc->hc_last_transaction_id = $request->hclasttransactionid;
                $sdc->hc_last_accumulator = $request->hctally;
                $sdc->hc_last_or_no = $request->hclastorno;

                //SOFT COPY FOR POS
                $sdc->sc_last_z_reading = $request->sclastzreading;
                $sdc->sc_last_transaction_id = $request->sclasttransactionid;
                $sdc->sc_last_accumulator = $request->sctally;
                $sdc->sc_last_or_no = $request->sclastorno;
             

                $sdc->pre_next_z_reading = $request->prezreadingno;
                $sdc->pre_next_or_no = $request->prenextorno;
                $sdc->pre_last_transaction_id = $request->prelasttransactionid;
                $sdc->pre_last_acc = $request->prelastacc;
                $sdc->pre_last_or_no = $request->prelastorno;
           
                $sdc->ty1_remarks = $request->ty1remarks;
                $sdc->ty1_fullname = $request->checkedby;
                $sdc->ty1_date_verified = $request->date_checked;
                $unserialize = unserialize($sdc->hierarchy);

                for($x = 0; $x < count($unserialize);  $x++) {
                        if($unserialize[$x] == 1){
                            $forward_status = $unserialize[$x + 1];
                            break;
                        }
                }
                $sdc->forward_status = $forward_status;

                date_default_timezone_set("Asia/Manila");
                $currentDate =  date('Y-m-d h:i:s a');
               
                $sdc->t1_datetime_apprvd =  $currentDate;

 
                
        }

        if($role_id == 6){
            $forward_status;
            $sdc->pre_verified_by = $request->preverifiedby;
            $sdc->pre_date_verified = $request->preverifieddate;
            $sdc->ty2_remarks = $request->ty2remarks;


            $unserialize = unserialize($sdc->hierarchy);

            for($x = 0; $x < count($unserialize);  $x++) {
                    if($unserialize[$x] == 2){
                        $forward_status = $unserialize[$x + 1];
                        break;
                    }
            }
            $sdc->forward_status = $forward_status;
            date_default_timezone_set("Asia/Manila");
            $currentDate =  date('Y-m-d h:i:s a');
           
            $sdc->t2_datetime_apprvd =  $currentDate;
        }
        // END



        // GOV.COMPLIANCES SUBMITTED DATA
            if($role_id == 7){
                $forward_status;
                //PRE-CORRECTION VERIFICATION
                $sdc->pre_acc_verified_by = $request->preaccumulatorverifiedby;
                $sdc->pre_acc_verified_date = $request->predateaccumulator;
                $sdc->govcomp_remarks = $request->govcompremarks;

                $unserialize = unserialize($sdc->hierarchy);

                for($x = 0; $x < count($unserialize);  $x++) {
                        if($unserialize[$x] == 3){
                            $forward_status = $unserialize[$x + 1];
                            break;
                        }
                }
                $sdc->forward_status = $forward_status;

                date_default_timezone_set("Asia/Manila");
                $currentDate =  date('Y-m-d h:i:s a');
               
                $sdc->govcomp_datetime_apprvd =  $currentDate;

                $accum = new Accumulators();

                $accum->sdc_id = $sdc->id;

                if($request->transreset != "" || $request->transreset != null){
                    $accum->trans_reset_count = $request->transreset;
                }
               
                if($request->orreset != "" || $request->orreset != null){
                    $accum->or_reset_count = $request->orreset;
                }

                // ACCUM NET SALES
                $accum->vat_sales = $request->vat_sales;
                $accum->non_vat_sales = $request->non_vat_sales;
                $accum->z_rated_sales = $request->z_rated_sales;
                $accum->vat_amount1 = $request->vat_amount1;
                $accum->vat_exempt_amount1 = $request->vat_ex_amount1;
                $accum->total_net_sales = $request->total_net_sales;

                // ACCUM. NET RETURNS
                $accum->vat_ret = $request->vat_returns;
                $accum->non_vat_ret = $request->non_vat_returns;
                $accum->z_rated_ret = $request->z_rated_ret;
                $accum->vat_amount2 = $request->vat_amount2;
                $accum->vat_exempt_amount2 = $request->vat_ex_amount2;
                $accum->total_net_returns = $request->total_net_returns;

                // ACCUM. NET SALES AFTER RETURNS
                $accum->vat = $request->accum_vat;
                $accum->non_vat = $request->accum_non_vat;
                $accum->z_rated = $request->accum_z_rated;
                $accum->vat_amount3 = $request->vat_amount3;
                $accum->vat_exempt_3 = $request->vat_ex_amount3;
                $accum->total_after_returns = $request->total_after_ret;

                $accum->first_trx = $request->first_trx;
                $accum->last_trx = $request->last_trx;
                $accum->trx_count =  $request->trx_count;
                $accum->prev_reading = $request->prev_reading;
                $accum->curr_reading = $request->curr_reading;

                $accum->save();
                $sdc->accum_id = $accum->id;


            }
        // END

        // APPROVERS SUBMITTED DATA
        if($role_id == 8){
                //APPROVAL OF THE CHANGE REQUEST
                $sdc->app_approved_by = $request->acrapprovedby;
                $sdc->app_date_approved = $request->acrdate;
                $sdc->forward_status = 5;
                date_default_timezone_set("Asia/Manila");
                $currentDate =  date('Y-m-d h:i:s a');
               
                $sdc->app_datetime_apprvd =  $currentDate;
                $sdc->app_remarks = $request->app_remarks;
         }
        // END


        // SUPPORTS LAST UPDATE
        if($role_id < 5 AND $status == 4){
            //CHANGE PROCESSING 
            $sdc->cp_request_assigned_to = $request->cprassignedto;
            $sdc->cp_date_completed =  $request->cprassigneddate;
            $sdc->cp_request_reviewed_by = $request->cprreviewedby;
            $sdc->cp_date_reviewed = $request->cpdatereviewed;
            $sdc->cp_table_fields_affected = $request->tfaffected;
            
            //DEPLOYMENT CONFIRMATION
            $sdc->dc_deployed_by = $request->dcdeployedby;

            // if($request->dcdeployedsigned != null){
            //     $sdc->dc_deployed_signed = $request->dcdeployedsigned;
            // }else{
            //     $sdc->dc_deployed_signed = 0;
            // }
            
            $sdc->dc_date_deployed = $request->dcdeployeddate;
            $sdc->dc_reviewed_by = $request->dcrreviewedby;
            
            // if($request->dcreviewedsigned != null){
            //     $sdc->dc_reviewed_signed = $request->dcreviewedsigned;
            // }else{
            //     $sdc->dc_reviewed_signed = 0;
            // }
            

            $sdc->dc_date_reviewed  = $request->dcrdate;
            
            //POST-CORRECTION VERIFICATION
            $sdc->post_verified_by = $request->pcvverifiedby;
            // if($request->postverifiedsigned != null){
            //     $sdc->post_verified_signed = $request->postverifiedsigned;
            // }else{
            //     $sdc->post_verified_signed = 0;
            // }
            
            $sdc->post_date_verified = $request->pcvdate;
        }
 
           $sdc->status = $status;
           
           $sdc->save();

           if(isset($request->upfile)){
            foreach($request->upfile as $file){
               
                    $fileNamewithExtension = $file->getClientOriginalName();
                    $fileName = pathinfo($fileNamewithExtension, PATHINFO_FILENAME);
                    $fileExtension = $file->getClientOriginalExtension();
                    $fileNametoStore = $fileName . '_'. time() .'.'.$fileExtension;
                    // $mime_type = $file->getMimeType();
                    $path = $file->storeAs('public/sdc_attachments',strtolower($fileNametoStore));

                    SDCAttachment::create(['sdc_no' => $request->sdc_id,'path' => $path,'original_name' => $fileNametoStore,'mime_type' => '','extension' => $fileExtension, 'role_id'=>Auth::user()->role_id]);
    
            
            }
       }

       
       if(isset($request->upfile1)){
        foreach($request->upfile1 as $file){
           
                $fileNamewithExtension = $file->getClientOriginalName();
                $fileName = pathinfo($fileNamewithExtension, PATHINFO_FILENAME);
                $fileExtension = $file->getClientOriginalExtension();
                $fileNametoStore = $fileName . '_'. time() .'.'.$fileExtension;
                // $mime_type = $file->getMimeType();
                $path = $file->storeAs('public/sdc_attachments',strtolower($fileNametoStore));

                SDCAttachment::create(['sdc_no' => $request->sdc_id,'path' => $path,'original_name' => $fileNametoStore,'mime_type' => '','extension' => $fileExtension, 'role_id'=>'5']);

        
        }
   }

           if($role_id < 5){
                if($status == 0){
                    return redirect()->route('sdc.printer', ['id'=>$sdc->id]);
                }else{
                    return redirect()->route('datacorrectons.sdcDeployment');
                }
           }elseif($role_id == 5){
                 return redirect()->route('datacorrectons.treasuryPENDING');
           }elseif($role_id == 6){
                 return redirect()->route('datacorrectons.treasury2PENDING');
           }elseif($role_id == 7){
                 return redirect()->route('datacorrectons.govcompPENDING');
           }elseif($role_id == 8){
                 return redirect()->route('datacorrectons.approverPENDING');
           }
        
        
    }

    
    public function destroy($id)
    {
       
    }


    public function getPosition(Request $request){
        $currPos = "N/A";
        if(isset($request->pos)){
            $currPos = $request->pos;
        }
        $positions = Position::where('department_id', '=', $request->department_id)->get();
        $data = "<option value=''>Choose...</option>";
        $selected = "";
        foreach($positions as $position){
            if($currPos == $position->position){
                $selected = "selected";
            }
            $data .= "<option value='".$position->position."'".$selected.">".$position->position."</option>";
        }

        return response()->json(array('success'=>true, 'data'=>"$data"), 200);
    }

  public function rmvattachment(Request $request){
        $id = $request->id; 
        $attachment = SDCAttachment::findorfail($id);
        $attachment->delete();
        Storage::disk('sdc_attach')->delete($request->original_name);
  }


  public function rejectDataCorrect(Request $request){
        $id = $request->sdcno;
        $reason = $request->content;
        $fstatus = $request->forward_status;
        
        $sdc = SystemDataCorrection::find($id);

        $sdc->rejection = $reason;
        $sdc->status = 2;
        $sdc->save();
 
  }

  public function search(Request $request){ 
     $user_role = Auth::user()->role_id;
     if($user_role == 5){
        $sdc = SystemDataCorrection::where('sdc_no','like', '%' .  $request->q . '%')->whereIn('status', array(1,3,4))->get();
     }else if($user_role == 6){
        $sdc = SystemDataCorrection::where('sdc_no','like', '%' .  $request->q . '%')->whereIn('status', array(1,3,4))->whereIn('forward_status', array(2,3,4,5))->get();
     }else if($user_role == 7){
        $sdc = SystemDataCorrection::where('sdc_no','like', '%' .  $request->q . '%')->whereIn('status', array(1,3,4))->whereIn('forward_status', array(3,4,5))->get();
     }else if($user_role == 8){
        $sdc = SystemDataCorrection::where('sdc_no','like', '%' .  $request->q . '%')->whereIn('status', array(1,3,4))->whereIn('forward_status', array(4,5))->get();
     }
   
    return view('datacorrections.searchresult')->with(compact('sdc'))->with('user_role',$user_role);
  
  }


  public function selectGroup(Request $request){
        $group = $request->group;
        $iscustom = false;
        $data =  "";

        if($group != "CUS"){
            if($group != ""){
                $iscustom = false;
                $data = "";
                $appgroups = AppHerGroup::where('group','=',$group)->first();
                $her = $appgroups->s_heirarchy;
                $serialized = unserialize($her);
                $role = "";
                $data = "<ol class='breadcrumb'>";
                for($x = 0; $x < count($serialized); $x++){
                        switch($serialized[$x])
                        {
                            case 1:
                                $role = "TREASURY 1";
                            break;
                            case 2:
                                $role = "TREASURY 2";
                            break;
                            case 3:
                                $role = "GOVERNMENT COMPLIANCE";
                            break;
                            case 4:
                                 $role = "FINAL APPROVER";
                            break;
    
                        }
                   $data .= "<li class='breadcrumb-item active' aria-current='page'>".$role."</li>";
                }
            $data .= "</ol>";
            }
        }else{
            $iscustom = true;
            $data = "";
            $data = "<div class='row'>";
              
                    $data .= "<div class='col-md-3' id='app1'>";
                    $data.= "<select class='custom-select d-block w-100' name='approver1' id ='approver1'>";
                             $data .= "<option value = '1'>TREASURY 1</option>";
                             $data .= "<option value = '2'>TREASURY 2</option>";
                             $data .= "<option value = '3'>GOV. COMPLIANCE</option>";
                             $data .= "<option value = '4'>FINAL APPROVER</option>";
                    $data .= "</select>";
                    $data .= "</div><span></span>"; 
               
                    $data .= "<div class='col-md-3' id='app2'>";
                    $data.= "<select class='custom-select d-block w-100' name='approver2' id ='approver2'>";
                             $data .= "<option value = '2'>TREASURY 2</option>";
                             $data .= "<option value = '3'>GOV. COMPLIANCE</option>";
                             $data .= "<option value = '4'>FINAL APPROVER</option>";
                    $data .= "</select>";
                    $data .= "</div>"; 

                    $data .= "<div class='col-md-3' id='app3'> ";
                    $data.= "<select class='custom-select d-block w-100' name='approver3' id ='approver3'>";
                            //  $data .= "<option value = '0'>--- Choose ---</option>";
                             $data .= "<option value = '3'>GOV. COMPLIANCE</option>";
                             $data .= "<option value = '4'>FINAL APPROVER</option>";
                    $data .= "</select>";
                    $data .= "</div>"; 

                    $data .= "<div class='col-md-3' id='app4'>";
                    $data.= "<select class='custom-select d-block w-100' name='approver4'  id ='approver4'>";
                            //  $data .= "<option value = '0'>--- Choose ---</option>";
                            $data .= "<option value = '4'>FINAL APPROVER</option>";
                    $data .= "</select>";
                    $data .= "</div>"; 
                
            $data .="</div>";
        }

        return response()->json(array('success'=>true, 'Iscustom'=> $iscustom ,'data'=> $data), 200);
  }


  public function ChangeGroupData(Request $request){
    $data = "";
    if($request->value == 1){
        $data = "<option value = '2'>TREASURY 2</option>";
        $data .= "<option value = '3'>GOV. COMPLIANCE</option>";
        $data .= "<option value = '4'>FINAL APPROVER</option>";
    }elseif($request->value == 2){
        $data = "<option value = '3'>GOV. COMPLIANCE</option>";
        $data .= "<option value = '4'>FINAL APPROVER</option>";
    }elseif($request->value == 3){
        $data = "<option value = '4'>FINAL APPROVER</option>";
    }else{
        $data = "<option value = '0'>--- Choose ---</option>";
    }

     return response()->json(array('success'=>true, 'data'=> $data), 200);
  }

  public function selectGroup2(Request $request){
    $group = $request->group;
    $iscustom = false;
    $data =  "";

    if($group != "CUS"){
        if($group != ""){
            $iscustom = false;
            $data = "";
            $appgroups = AppHerGroup::where('group','=',$group)->first();
            $her = $appgroups->s_heirarchy;
            $serialized = unserialize($her);
            $role = "";
            $data = "<ol class='breadcrumb'>";
            for($x = 0; $x < count($serialized); $x++){
                    switch($serialized[$x])
                    {
                        case 1:
                            $role = "TREASURY 1";
                        break;
                        case 2:
                            $role = "TREASURY 2";
                        break;
                        case 3:
                            $role = "GOVERNMENT COMPLIANCE";
                        break;
                        case 4:
                             $role = "FINAL APPROVER";
                        break;

                    }
               $data .= "<li class='breadcrumb-item active' aria-current='page'>".$role."</li>";
            }
        $data .= "</ol>";
        }
    }else{
        $iscustom = true;
        $sdc = SystemDataCorrection::find($request->sdc_id);
        $her = $sdc->hierarchy;
        $unserialize = unserialize($her);
        $data = "<div class='row'>";
        switch(count($unserialize)){
            case 1 : 
          
                $data .= "<div class='col-md-3' id='app1'>";
                $data.= "<select class='custom-select d-block w-100' name='approver1'  id ='approver1'>";
                        $data .= "<option value = '1'>TREASURY 1</option>";
                        $data .= "<option value = '2'>TREASURY 2</option>";
                        $data .= "<option value = '3'>GOV. COMPLIANCE</option>";
                        $data .= "<option value = '4' selected >FINAL APPROVER</option>";
                $data .= "</select>";
                $data .= "</div>"; 

                $data .= "<div class='col-md-3' id='app2'>";
                $data.= "<select class='custom-select d-block w-100' name='approver2' id ='approver2' disabled>";
                         $data .= "<option value = '0'>--- --- ---</option>";
                $data .= "</select>";
                $data .= "</div>"; 

                $data .= "<div class='col-md-3' id='app3'>";
                $data.= "<select class='custom-select d-block w-100' name='approver3' id ='approver3' disabled>";
                         $data .= "<option value = '0'>--- --- ---</option>";
                $data .= "</select>";
                $data .= "</div>"; 

                $data .= "<div class='col-md-3' id='app4'>";
                $data.= "<select class='custom-select d-block w-100' name='approver4' id ='approver4' disabled>";
                         $data .= "<option value = '0'>--- --- ---</option>";
                $data .= "</select>";
                $data .= "</div>"; 

            break;
            case 2:
                for ($x=0; $x < count($unserialize) ; $x++) { 
                    $y = $x + 1;
                   
                    if($x != 1){
                        $data .= "<div class='col-md-3' id='app".$y."'>";
                        $data.= "<select class='custom-select d-block w-100' name='approver1'  id ='approver1'>";
                                $data .= "<option value = '1'";
                                        if($unserialize[$x] == 1){
                                            $data .= " selected";
                                        }
                                        $data .= ">TREASURY 1</option>";
                                $data .= "<option value = '2'";
                                        if($unserialize[$x] == 2){
                                            $data .= " selected";
                                        }
                                        $data .= ">TREASURY 2</option>";
                                $data .= "<option value = '3'";
                                        if($unserialize[$x] == 3){
                                            $data .= " selected";
                                        }
                                $data .= ">GOV. COMPLIANCE</option>";
                                $data .= "<option value = '4'";
                                        if($unserialize[$x] == 4){
                                            $data .= " selected";
                                        }
                                $data .= ">FINAL APPROVER</option>";
                        $data .= "</select>";
                        $data .= "</div>"; 
                    }else{

                        $data .= "<div class='col-md-3' id='app".$y."'>";
                        $data.= "<select class='custom-select d-block w-100' name='approver2'  id ='approver2'>";
                                $data .= "<option value = '2'>TREASURY 2</option>";
                                $data .= "<option value = '3'>GOV. COMPLIANCE</option>";
                                $data .= "<option value = '4' selected >FINAL APPROVER</option>";
                        $data .= "</select>";
                        $data .= "</div>"; 
                        
                    }

                }

                $data .= "<div class='col-md-3' id='app3'>";
                $data.= "<select class='custom-select d-block w-100' name='approver3' id ='approver3' disabled>";
                         $data .= "<option value = '0'>--- --- ---</option>";
                $data .= "</select>";
                $data .= "</div>"; 

                $data .= "<div class='col-md-3' id='app4'>";
                $data.= "<select class='custom-select d-block w-100' name='approver4' id ='approver4' disabled>";
                         $data .= "<option value = '0'>--- --- ---</option>";
                $data .= "</select>";
                $data .= "</div>"; 
            break;
            case 3:
            for ($x=0; $x < count($unserialize) ; $x++) { 
                $y = $x + 1;
               
                if($x == 0){
                    $data .= "<div class='col-md-3' id='app".$y."'>";
                    $data.= "<select class='custom-select d-block w-100' name='approver1'  id ='approver1'>";
                            $data .= "<option value = '1'";
                                    if($unserialize[$x] == 1){
                                        $data .= " selected";
                                    }
                                    $data .= ">TREASURY 1</option>";
                            $data .= "<option value = '2'";
                                    if($unserialize[$x] == 2){
                                        $data .= " selected";
                                    }
                                    $data .= ">TREASURY 2</option>";
                            $data .= "<option value = '3'";
                                    if($unserialize[$x] == 3){
                                        $data .= " selected";
                                    }
                            $data .= ">GOV. COMPLIANCE</option>";
                            $data .= "<option value = '4'";
                                    if($unserialize[$x] == 4){
                                        $data .= " selected";
                                    }
                            $data .= ">FINAL APPROVER</option>";
                    $data .= "</select>";
                    $data .= "</div>";
                }elseif($x == 1){
                    $data .= "<div class='col-md-3' id='app".$y."'>";
                    $data.= "<select class='custom-select d-block w-100' name='approver2'  id ='approver2'>";
                          
                            $data .= "<option value = '2'";
                                    if($unserialize[$x] == 2){
                                        $data .= " selected";
                                    }
                                    $data .= ">TREASURY 2</option>";
                            $data .= "<option value = '3'";
                                    if($unserialize[$x] == 3){
                                        $data .= " selected";
                                    }
                            $data .= ">GOV. COMPLIANCE</option>";
                            $data .= "<option value = '4'";
                                    if($unserialize[$x] == 4){
                                        $data .= " selected";
                                    }
                            $data .= ">FINAL APPROVER</option>";
                    $data .= "</select>";
                    $data .= "</div>";

                }elseif ($x == 2){

                    $data .= "<div class='col-md-3' id='app".$y."'>";
                    $data.= "<select class='custom-select d-block w-100' name='approver3'  id ='approver3'>";
                            $data .= "<option value = '3'>GOV. COMPLIANCE</option>";
                            $data .= "<option value = '4' selected >FINAL APPROVER</option>";
                    $data .= "</select>";
                    $data .= "</div>"; 
                    
                }

            }

            $data .= "<div class='col-md-3' id='app4'>";
            $data.= "<select class='custom-select d-block w-100' name='approver4' id ='approver4' disabled>";
                     $data .= "<option value = '0'>--- --- ---</option>";
            $data .= "</select>";
            $data .= "</div>"; 
            break;
            case 4:
            for ($x=0; $x < count($unserialize) ; $x++) { 
                $y = $x + 1;
               
                if($x == 0){
                    $data .= "<div class='col-md-3' id='app".$y."'>";
                    $data.= "<select class='custom-select d-block w-100' name='approver1'  id ='approver1'>";
                            $data .= "<option value = '1'";
                                    if($unserialize[$x] == 1){
                                        $data .= " selected";
                                    }
                                    $data .= ">TREASURY 1</option>";
                            $data .= "<option value = '2'";
                                    if($unserialize[$x] == 2){
                                        $data .= " selected";
                                    }
                                    $data .= ">TREASURY 2</option>";
                            $data .= "<option value = '3'";
                                    if($unserialize[$x] == 3){
                                        $data .= " selected";
                                    }
                            $data .= ">GOV. COMPLIANCE</option>";
                            $data .= "<option value = '4'";
                                    if($unserialize[$x] == 4){
                                        $data .= " selected";
                                    }
                            $data .= ">FINAL APPROVER</option>";
                    $data .= "</select>";
                    $data .= "</div>";
                }elseif($x == 1){
                    $data .= "<div class='col-md-3' id='app".$y."'>";
                    $data.= "<select class='custom-select d-block w-100' name='approver2'  id ='approver2'>";
                          
                            $data .= "<option value = '2'";
                                    if($unserialize[$x] == 2){
                                        $data .= " selected";
                                    }
                                    $data .= ">TREASURY 2</option>";
                            $data .= "<option value = '3'";
                                    if($unserialize[$x] == 3){
                                        $data .= " selected";
                                    }
                            $data .= ">GOV. COMPLIANCE</option>";
                            $data .= "<option value = '4'";
                                    if($unserialize[$x] == 4){
                                        $data .= " selected";
                                    }
                            $data .= ">FINAL APPROVER</option>";
                    $data .= "</select>";
                    $data .= "</div>";

                }elseif ($x == 2){

                    $data .= "<div class='col-md-3' id='app".$y."'>";
                    $data.= "<select class='custom-select d-block w-100' name='approver3'  id ='approver3'>";
                            $data .= "<option value = '3'>GOV. COMPLIANCE</option>";
                            $data .= "<option value = '4' selected >FINAL APPROVER</option>";
                    $data .= "</select>";
                    $data .= "</div>"; 
                    
                }

            }

            $data .= "<div class='col-md-3' id='app4'>";
            $data.= "<select class='custom-select d-block w-100' name='approver4' id ='approver4' disabled>";
                     $data .= "<option value = '4'>FINAL APPROVER</option>";
            $data .= "</select>";
            $data .= "</div>"; 
            break;
        }
        $data .="</div>";
    }

    return response()->json(array('success'=>true, 'Iscustom'=> $iscustom ,'data'=> $data), 200);
}

public function addHierarchy(Request $request){
     $arr = [];
     $arr_serialize = [];
     $group_name = $request->group_name;
     $app = "app";
     $approver = "approver";
    $ahg = new AppHerGroup();
    $ahg->group = $group_name;
     for ($i=1; $i <= 4; $i++) { 
         $app  = "app{$i}";
         $approver = "approver{$i}";
         if($request->$app != null){
             array_push($arr, (int) $request->$app);
             $ahg->$approver = (int) $request->$app;
         }
     }
     $arr_serialize = serialize($arr);
     $ahg->s_heirarchy = $arr_serialize;
     $ahg->save();
     return redirect()->back();
}
   
}
