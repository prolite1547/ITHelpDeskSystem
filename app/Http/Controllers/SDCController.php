<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SystemDataCorrection;
use App\ManualDataCorrection;
use App\Ticket;
use App\Department;
use App\Position;
use App\SDCAttachment;
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
        $forward_status = 1;
        $status;
        $files = "";


        if($action == "SAVE"){
            $status = 0;
            $posted = 0;
        }else{
            $status = 1;
            $forward_status =  $request->forwardto;
            $user_id = Auth::user()->id;
        }

       
 
       
 
        SystemDataCorrection::create([
              
            'ticket_no' => $request->ticketno,
            'sdc_no' => $request->sdcno,
            'date_submitted' => $request->datesubmitted,
            'requestor_name' => $request->requestor,
            'dept_supervisor' => $request->supervisor,
            'department' => $request->department,
            'position' => $request->position,
            
            //DETAILS
            'affected_ss' => $request->affected,
            'terminal_name' => $request->terminalname,

            'findings_recommendations' => $request->dfindings,

             'status' => $status,
             'forward_status' => $forward_status,
             'posted_by' => $user_id
        ]);


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
                    $mime_type = $file->getMimeType();
                    //Upload image
                    $path = $file->storeAs('public/sdc_attachments',$fileNametoStore);
                    // $path1 = "/storage/sdc_attachments/". $fileNametoStore;

                    SDCAttachment::create(['sdc_no' => $request->sdc_id,'path' => $path,'original_name' => $fileNametoStore,'mime_type' => $mime_type,'extension' => $fileExtension]);
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
                $departments = Department::all();
                $positions = Position::all();
                $ticket = Ticket::find($id);
                return view('datacorrections.system')->with('sdc',$sdc)->with('ticket', $ticket)->with('departments', $departments)->with('positions',  $positions);
          }else{
              return redirect()->back();
          }
    }

   
    public function edit($id)
    {
        return view('datacorrections.sdcupdate')->with('sdc',SystemDataCorrection::find($id))->with('departments', Department::all())->with('positions', Position::all());
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
                case "SUBMIT":
                    // if($role_id == 5){
                    //     $status = 2;
                    // }elseif($role_id == 6){
                    //     $status = 3;
                    // }elseif($role_id == 7){
                    //     $status = 4;
                    // }else{
                    //     $status = 5;
                    // }
                break;
                case "SAVE":
                    $status = 0;
                break;
                case "POST":
                     $status = 1;
                     $user_id = Auth::user()->id;
                break;
                case "REJECT":
                     $status = 2;
                break;
                default:
                     $status = 1;
                break;
                
          }

        

          $sdc = SystemDataCorrection::find($id);

          //   SUPPORTS UPDATES
          if($role_id < 5 AND $status < 5){
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

                if($user_id != 0){
                    $sdc->posted_by = $user_id;
                }
          }
          //  END
         
         
        //   TREASURY SUBMITTED DATA
        if($role_id == 5){
                //HARD COPY FOR POS
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

                $sdc->pre_verified_by = $request->preverifiedby;
                $sdc->pre_date_verified = $request->preverifieddate;
                $sdc->ty1_remarks = $request->ty1remarks;
                $sdc->ty1_fullname = $request->checkedby;
            
        }

        if($role_id == 6){
            $sdc->ty2_remarks = $request->ty2remarks;
        }
        // END



        // GOV.COMPLIANCES SUBMITTED DATA
            if($role_id == 6){
                //PRE-CORRECTION VERIFICATION
                $sdc->pre_acc_verified_by = $request->preaccumulatorverifiedby;
                $sdc->pre_acc_verified_date = $request->predateaccumulator;
                $sdc->govcomp_remarks = $request->govcompremarks;
            }
        // END
      
          


        // APPROVERS SUBMITTED DATA
        if($role_id == 7){
                //APPROVAL OF THE CHANGE REQUEST
                $sdc->app_approved_by = $request->acrapprovedby;
                $sdc->app_date_approved = $request->acrdate;
         }
        // END


        // SUPPORTS LAST UPDATE
        if($role_id < 5){
            //CHANGE PROCESSING 
            $sdc->cp_request_assigned_to = $request->cprassignedto;
            $sdc->cp_date_completed =  $request->cprassigneddate;
            $sdc->cp_request_reviewed_by = $request->cprreviewedby;
            $sdc->cp_date_reviewed = $request->cpdatereviewed;
            $sdc->cp_table_fields_affected = $request->tfaffected;
            
            //DEPLOYMENT CONFIRMATION
            $sdc->dc_deployed_by = $request->dcdeployedby;

            if($request->dcdeployedsigned != null){
                $sdc->dc_deployed_signed = $request->dcdeployedsigned;
            }else{
                $sdc->dc_deployed_signed = 0;
            }
            
            $sdc->dc_date_deployed = $request->dcdeployeddate;
            $sdc->dc_reviewed_by = $request->dcrreviewedby;
            
            if($request->dcreviewedsigned != null){
                $sdc->dc_reviewed_signed = $request->dcreviewedsigned;
            }else{
                $sdc->dc_reviewed_signed = 0;
            }
            

            $sdc->dc_date_reviewed  = $request->dcrdate;
            
            //POST-CORRECTION VERIFICATION
            $sdc->post_verified_by = $request->pcvverifiedby;
            if($request->postverifiedsigned != null){
                $sdc->post_verified_signed = $request->postverifiedsigned;
            }else{
                $sdc->post_verified_signed = 0;
            }
            
            $sdc->post_date_verified = $request->pcvdate;
        }

           if($action == "APPROVED & FORWARD" OR $action == "SUBMIT FOR APPROVAL"){
                $sdc->forward_status = $forward_status;
           }

           $sdc->status = $status;
           
           $sdc->save();

           if(isset($request->upfile)){
            foreach($request->upfile as $file){
                    $fileNamewithExtension = $file->getClientOriginalName();
                    $fileName = pathinfo($fileNamewithExtension, PATHINFO_FILENAME);
                    $fileExtension = $file->getClientOriginalExtension();
                    $fileNametoStore = $fileName . '_'. time() .'.'.$fileExtension;
                    $mime_type = $file->getMimeType();
                    $path = $file->storeAs('public/sdc_attachments',strtolower($fileNametoStore));

                    SDCAttachment::create(['sdc_no' => $request->sdc_id,'path' => $path,'original_name' => $fileNametoStore,'mime_type' => $mime_type,'extension' => $fileExtension]);
            }
       }

           if($role_id < 5){
                if($status != 5){
                    return redirect()->route('sdc.printer', ['id'=>$sdc->id]);
                }else{
                    return redirect()->route('datacorrectons.sdcApproved');
                }
           }elseif($role_id == 5){
                 return redirect()->route('datacorrectons.treasuryPENDING');
           }elseif($role_id == 6){
                 return redirect()->route('datacorrectons.govcompPENDING');
           }else{
                 return redirect()->route('datacorrectons.approverPENDING');
           }
        
        
    }

    
    public function destroy($id)
    {
       
    }


    public function getPosition(Request $request){
        
        $positions = Position::where('department_id', '=', $request->department_id)->get();
        $data = "<option value=''>Choose...</option>";
        foreach($positions as $position){
            $data .= "<option value='".$position->position."'>".$position->position."</option>";
        }

        return response()->json(array('success'=>true, 'data'=>"$data"), 200);
    }

  public function rmvattachment(Request $request){
        $id = $request->id; 
        $attachment = SDCAttachment::findorfail($id);
        $attachment->delete();
        Storage::disk('sdc_attach')->delete($request->original_name);
  }


   
}
