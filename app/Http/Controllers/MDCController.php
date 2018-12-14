<?php

namespace App\Http\Controllers;
use App\ManualDataCorrection;
use App\Ticket;
use App\Department;
use App\Position;
use Illuminate\Http\Request;

class MDCController extends Controller
{
 
    public function index()
    {
        return view('datacorrections.manual');
    }
 
    public function create()
    { 
       $mdc = ManualDataCorrection::orderBy('created_at','desc')->first();
       return view('datacorrections.manual')->with('mdc',$mdc);
    }

    
    public function store(Request $request)
    {   

        ManualDataCorrection::create([
            'ticket_no' => $request->ticketno,
            'mdc_no' => $request->mdcno,
            'date_submitted' => $request->datesubmitted,
            'requestor_name' => $request->requestor,
            'position' => $request->position,
            'department' => $request->department,
            'affected_ss' => $request->affected,
            'affected_date' => $request->affecteddate,
            'findings_recommendations'=>$request->dfindings,
            'verified_by'=> $request->verifiedby,
            'pre_should_be_data' => $request->dshouldbe,
            'pre_verified_by'=>$request->preverifiedby,
            'pre_date_verified' => $request->preverifieddate,
            'app_head_approver'=> $request->hacrapprovedby,
            'app_head_approver_date'=> $request->hacrdate,
            'app_approver'=> $request->acrapprovedby,
            'app_approver_date' => $request->acrdate,
            'cp_request_assignedTo' => $request->cprassignedto,
            'cp_date_completed' => $request->cprassigneddate,
            'cp_request_reviewedBy'=> $request->cprreviewedby,
            'cp_date_reviewed' => $request->cpdatereviewed,
            'dc_deployed_by' => $request->dcdeployedby,
            'dc_date_deployed' => $request->dcdeployeddate,
            'dc_reviewed_by'=> $request->dcrreviewedby,
            'dc_date_reviewed' => $request->dcrdate,
            'post_verified_by' => $request->pcvverifiedby,
            'post_date_verified' => $request->pcvdate
        ]);

        return redirect()->route('lookupTicketView', ['id'=> $request->ticketno]);

    }
 
    public function show($id)
    {
      $mdc = ManualDataCorrection::orderBy('created_at','desc')->first();
      return view('datacorrections.manual')->with('mdc',$mdc)->with('ticket', Ticket::find($id))->with('departments', Department::all())->with('positions', Position::all());
    }

    
    public function edit($id)
    {
        return view('datacorrections.mdcupdate')->with('mdc',ManualDataCorrection::find($id))->with('departments', Department::all())->with('positions', Position::all());

    }

    
    public function update(Request $request, $id)
    {
        $mdc = ManualDataCorrection::find($id);

         $mdc->ticket_no = $request->ticketno;
         $mdc->date_submitted = $request->datesubmitted;
         $mdc->requestor_name = $request->requestor;
         $mdc->position = $request->position;
         $mdc->department =  $request->department;
         $mdc->affected_ss = $request->affected;
         $mdc->affected_date = $request->affecteddate;
         $mdc->findings_recommendations = $request->dfindings;
         $mdc->verified_by = $request->verifiedby;
         
         if($request->verifiedbysigned != null){
            $mdc->verified_by_signed = $request->verifiedbysigned;
         }else{
            $mdc->verified_by_signed = 0;
         }

         $mdc->pre_should_be_data = $request->dshouldbe;

         if($request->preverifiedbysigned != null){
            $mdc->pre_verified_signed = $request->preverifiedbysigned;
         }else{
            $mdc->pre_verified_signed = 0;
         }
         $mdc->pre_verified_by = $request->preverifiedby;
         $mdc->pre_date_verified = $request->preverifieddate;
         $mdc->app_head_approver =  $request->hacrapprovedby;

         if($request->hacrapprovedbysigned != null){
            $mdc->app_head_approver_signed = $request->hacrapprovedbysigned;
         }else{
            $mdc->app_head_approver_signed = 0;
         }

         $mdc->app_head_approver_date = $request->hacrdate;
         $mdc->app_approver =  $request->acrapprovedby;

         if($request->acrapprovedbysigned != null){
            $mdc->app_approver_signed = $request->acrapprovedbysigned;
         }else{
            $mdc->app_approver_signed = 0;
         }


         $mdc->app_approver_date = $request->acrdate;
         $mdc->cp_request_assignedTo = $request->cprassignedto;
         $mdc->cp_date_completed = $request->cprassigneddate;
         $mdc->cp_request_reviewedBy = $request->cprreviewedby;
         $mdc->cp_date_reviewed = $request->cpdatereviewed;
         $mdc->dc_deployed_by = $request->dcdeployedby;

         if($request->dcdeployedbysigned != null){
            $mdc->dc_deployed_signed = $request->dcdeployedbysigned;
         }else{
            $mdc->dc_deployed_signed = 0;
         }

         $mdc->dc_date_deployed = $request->dcdeployeddate;
         $mdc->dc_reviewed_by = $request->dcrreviewedby;

         if($request->dcrreviewedbysigned != null){
            $mdc->dc_reviewed_signed = $request->dcrreviewedbysigned;
         }else{
            $mdc->dc_reviewed_signed =0;
         }

         $mdc->dc_date_reviewed = $request->dcrdate;
         $mdc->post_verified_by = $request->pcvverifiedby;

         if($request->pcvverifiedbysigned != null){
            $mdc->post_verified_signed = $request->pcvverifiedbysigned;
         }else{
            $mdc->post_verified_signed = 0;
         }

         $mdc->post_date_verified = $request->pcvdate;
         $mdc->posted = $request->posted;
         $mdc->save();

         return redirect()->route('mdc.printer', ['id'=>$mdc->id]);


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

}
