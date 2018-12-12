<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SystemDataCorrection;
use App\Ticket;
use App\Department;
use App\Position;



class SDCController extends Controller
{
    
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

            //HARD COPY FOR POS
            'hc_last_z_reading' => $request->hclastzreading,
            'hc_last_dcr' => $request->hclastdcr,
            'hc_last_transaction_id' => $request->hclasttransactionid,
            'hc_last_accumulator' => $request->hctally,
            'hc_last_or_no' => $request->hclastorno,

            //SOFT COPY FOR POS
            'sc_last_z_reading' => $request->sclastzreading,
            'sc_last_transaction_id'=> $request->sclasttransactionid,
            'sc_last_accumulator' => $request->sctally,
            'sc_last_or_no' => $request->sclastorno,

            'findings_recommendations' => $request->dfindings,

            //PRE-CORRECTION VERIFICATION
            'pre_acc_verified_by' => $request->preaccumulatorverifiedby,
            'pre_acc_verified_date' => $request->predateaccumulator,
            'pre_next_z_reading' => $request->prezreadingno,
            'pre_next_or_no' => $request->prenextorno,
            'pre_last_transaction_id' => $request->prelasttransactionid,
            'pre_last_acc' => $request->prelastacc,
            'pre_last_or_no' => $request->prelastorno,
            'pre_verified_by'=> $request->preverifiedby,
            'pre_date_verified' => $request->preverifieddate,
        
            //APPROVAL OF THE CHANGE REQUEST
            'app_approved_by' => $request->acrapprovedby,
            'app_date_approved'=> $request->acrdate,

            //CHANGE PROCESSING 
            'cp_request_assigned_to' => $request->cprassignedto,
            'cp_date_completed' => $request->cprassigneddate,
            'cp_request_reviewed_by'=> $request->cprreviewedby,
            'cp_date_reviewed'=> $request->cpdatereviewed,
            'cp_table_fields_affected' => $request->tfaffected,
            
             //DEPLOYMENT CONFIRMATION
             'dc_deployed_by' => $request->dcdeployedby,
             'dc_date_deployed' => $request->dcdeployeddate,
             'dc_reviewed_by' => $request->dcrreviewedby,
             'dc_date_reviewed' => $request->dcrdate,
             
             //POST-CORRECTION VERIFICATION
             'post_verified_by' => $request->pcvverifiedby,
             'post_date_verified' => $request->pcvdate
        ]);

        return redirect()->route('lookupTicketView', ['id'=> $request->ticketno]);

     
    }

    
    public function show($id)
    {
        $sdc = SystemDataCorrection::orderBy('created_at','desc')->first();
        $departments = Department::all();
        $positions = Position::all();
        $ticket = Ticket::find($id);
        return view('datacorrections.system')->with('sdc',$sdc)->with('ticket', $ticket)->with('departments', $departments)->with('positions',  $positions);
         
    }

   
    public function edit($id)
    {
        return view('datacorrections.sdcupdate')->with('sdc',SystemDataCorrection::find($id))->with('departments', Department::all())->with('positions', Position::all());
    }
 
    public function update(Request $request, $id)
    {
         $sdc = SystemDataCorrection::find($id);

          $sdc->ticket_no = $request->ticketno;
          $sdc->date_submitted = $request->datesubmitted;
          $sdc->requestor_name = $request->requestor;
          $sdc->dept_supervisor = $request->supervisor;
          $sdc->department = $request->department;
          $sdc->position = $request->position;
         
         //DETAILS
          $sdc->affected_ss = $request->affected;
          $sdc->terminal_name = $request->terminalname;

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

          $sdc->findings_recommendations = $request->dfindings;

         //PRE-CORRECTION VERIFICATION
          $sdc->pre_acc_verified_by = $request->preaccumulatorverifiedby;
            if($request->preaccsigned != null){
                $sdc->pre_acc_verified_signed = $request->preaccsigned;
            }else{
                $sdc->pre_acc_verified_signed = 0;
            }
          $sdc->pre_acc_verified_date = $request->predateaccumulator;
          $sdc->pre_next_z_reading = $request->prezreadingno;
          $sdc->pre_next_or_no = $request->prenextorno;
          $sdc->pre_last_transaction_id = $request->prelasttransactionid;
          $sdc->pre_last_acc = $request->prelastacc;
          $sdc->pre_last_or_no = $request->prelastorno;
          $sdc->pre_verified_by = $request->preverifiedby;

          if($request->preverifiedsigned != null){
            $sdc->pre_verified_signed = $request->preverifiedsigned;
          }else{
            $sdc->pre_verified_signed = 0;
          }
          
          $sdc->pre_date_verified = $request->preverifieddate;
     
         //APPROVAL OF THE CHANGE REQUEST
          $sdc->app_approved_by = $request->acrapprovedby;
          if($request->appapprovedsigned != null){
            $sdc->app_approved_signed = $request->appapprovedsigned;
          }else{
            $sdc->app_approved_signed = 0;
          }
        
          $sdc->app_date_approved = $request->acrdate;

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
           $sdc->posted = $request->posted;
           
           $sdc->save();

           return redirect()->route('sdc.printer', ['id'=>$sdc->id]);
    }

    
    public function destroy($id)
    {
       
    }


   
}
