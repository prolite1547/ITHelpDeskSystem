<?php

namespace App\Http\Controllers;

use App\Status;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function PHPSTORM_META\type;
use Yajra\DataTables\Facades\DataTables;
use App\User;
use App\Category;
use App\Store;
use App\SystemDataCorrection;
use App\ManualDataCorrection;


class DatatablesController extends Controller
{


    public function ajax()
    {
        return Datatables::of(User::query())->make(true);
    }

    public function tickets(Request $request,$status){
        $statuses = Status::whereNotIn('name',['all','user','fixedRej'])->pluck('name')->toArray();
        $query = DB::table('tickets')
        ->join('incidents','tickets.incident_id','incidents.id')
            ->when(in_array(strtolower($status),array_map('strtolower',$statuses),true),function ($query) use ($status){
                $get_status = Status::where('name',$status)->firstOrFail();
                return $query->whereStatus($get_status->id);
            })
            ->when($status === 'user',function ($query){
                return $query->where('assignee',Auth::user()->id)->where('status','!=',3);
            })
            ->when($status === 'fixedRej',function ($query){
                return $query->whereStatus(4);

            })
            ->leftJoin('stores','tickets.store','stores.id')
            ->leftJoin('calls','incidents.call_id','calls.id')
            ->leftJoin('resolves','tickets.id','resolves.ticket_id')
            ->leftJoin('categories as cat','incidents.category','cat.id')
            ->leftJoin('ticket_status as status','tickets.status','status.id')
            ->leftJoin('priorities as prio','tickets.priority','prio.id')
            ->leftJoin('users as assignee','tickets.assignee','assignee.id')
            ->leftJoin('users as resolver','resolves.resolved_by','resolver.id')
            ->selectRaw(
                'tickets.id,tickets.assignee,prio.name as priority,status.name as status,tickets.expiration,tickets.fixed_date,tickets.created_at,
                incidents.created_at as incident_created,incidents.subject,incidents.details,cat.name as category,
                CONCAT(assignee.fName," ",assignee.lName) as assignee,
                stores.store_name,
                CONCAT(resolver.fName," ",resolver.lName) as resolved_by,resolves.created_at as resolved_date'
            );

        $datatablesJSON = DataTables::of($query);



        return $datatablesJSON->make(true);

    }

    // public function sdc(){
    //    $query = DB::table('system_data_corrections')
    //    ->join('tickets', 'system_data_corrections.ticket_no', 'tickets.id')
    //    ->leftjoin('incidents', 'tickets.incident_id','incidents.id')
    //    ->selectRaw('system_data_corrections.id,system_data_corrections.sdc_no ,tickets.id as ticket_id ,incidents.subject, system_data_corrections.requestor_name, system_data_corrections.dept_supervisor ,system_data_corrections.department, system_data_corrections.position, system_data_corrections.date_submitted, system_data_corrections.posted');
    //    $datatablesJSON = DataTables::of($query);
    //    return $datatablesJSON->make(true);
    // }

    public function sdc(){
        $query = DB::table('system_data_corrections')
        ->join('tickets', 'system_data_corrections.ticket_no', 'tickets.id')
        ->leftjoin('incidents', 'tickets.incident_id','incidents.id')
        ->selectRaw('system_data_corrections.id,system_data_corrections.sdc_no ,tickets.id as ticket_id ,incidents.subject, system_data_corrections.requestor_name, system_data_corrections.dept_supervisor ,system_data_corrections.department, system_data_corrections.position, system_data_corrections.date_submitted, system_data_corrections.posted');
        $query = $query->orderBy('system_data_corrections.created_at', 'desc');
        $datatablesJSON = DataTables::of($query);
        return $datatablesJSON->make(true);
     }
     
     public function system($status){

       
        $query = DB::table('system_data_corrections')
        ->join('tickets', 'system_data_corrections.ticket_no', 'tickets.id')
        ->leftjoin('incidents', 'tickets.incident_id','incidents.id')
        ->selectRaw('system_data_corrections.id,system_data_corrections.sdc_no ,tickets.id as ticket_id ,incidents.subject, system_data_corrections.requestor_name, system_data_corrections.dept_supervisor ,system_data_corrections.department, system_data_corrections.position, system_data_corrections.date_submitted, system_data_corrections.posted, system_data_corrections.status');
        
        switch($status){
            case "approved":
                $query = $query->where('system_data_corrections.status', '4');
            break;
            case "saved":
                $query = $query->where('system_data_corrections.status', '0');
            break;
            case "posted":
                 $query = $query->where('system_data_corrections.status', '1');
            break;
            case "ongoing":
                 $query = $query->where('system_data_corrections.status', '2');
            break;
            case "forapproval":
                $query = $query->where('system_data_corrections.status', '3');
            break;
            case "done":
                 $query = $query->where('system_data_corrections.status', '5');
            break;

        }
        $query = $query->orderBy('system_data_corrections.created_at', 'desc');
        $datatablesJSON = DataTables::of($query);
        return $datatablesJSON->make(true);
     }
     


    public function mdc(){
        $query = DB::table('manual_data_corrections')
        ->join('tickets', 'manual_data_corrections.ticket_no', 'tickets.id')
        ->leftjoin('incidents', 'tickets.incident_id','incidents.id')
        ->selectRaw('manual_data_corrections.id,manual_data_corrections.mdc_no ,tickets.id as ticket_id ,incidents.subject, manual_data_corrections.requestor_name ,manual_data_corrections.department, manual_data_corrections.position, manual_data_corrections.date_submitted, manual_data_corrections.posted');
        $query = $query->orderBy('manual_data_corrections.created_at', 'desc');
        $datatablesJSON = DataTables::of($query);
        return $datatablesJSON->make(true);
     }

     public function treasury($status){
        $query = DB::table('system_data_corrections')
        ->join('tickets', 'system_data_corrections.ticket_no', 'tickets.id')
        ->leftjoin('incidents', 'tickets.incident_id','incidents.id')
        ->selectRaw('system_data_corrections.id,
        system_data_corrections.sdc_no,
        tickets.id as ticket_id,
        incidents.subject, 
        system_data_corrections.requestor_name,
        system_data_corrections.dept_supervisor,
        system_data_corrections.department,
        system_data_corrections.position,
        system_data_corrections.date_submitted,
        system_data_corrections.posted,
        system_data_corrections.status');
        
        if($status != "all"){
           if($status == "pending"){
                $query = $query->where('system_data_corrections.status', '1');
           }elseif($status == "done"){
                $query = $query->whereIn('system_data_corrections.status', array('2','3','4','5'));
           }
        }else{
            $query = $query->whereIn('system_data_corrections.status', array('1','2','3'));
        }

        $datatablesJSON = DataTables::of($query);
        return $datatablesJSON->make(true);
     }

     public function govcomp($status){
        $query = DB::table('system_data_corrections')
        ->join('tickets', 'system_data_corrections.ticket_no', 'tickets.id')
        ->leftjoin('incidents', 'tickets.incident_id','incidents.id')
        ->selectRaw('system_data_corrections.id,
        system_data_corrections.sdc_no,
        tickets.id as ticket_id,
        incidents.subject, 
        system_data_corrections.requestor_name,
        system_data_corrections.dept_supervisor,
        system_data_corrections.department,
        system_data_corrections.position,
        system_data_corrections.date_submitted,
        system_data_corrections.posted,
        system_data_corrections.status');
        
        if($status != "all"){
           if($status == "pending"){
                $query = $query->where('system_data_corrections.status', '2');
           }elseif($status == "done"){
                $query = $query->whereIn('system_data_corrections.status',  array('3','4','5'));
           }
        }else{
            $query = $query->whereIn('system_data_corrections.status', array('2','3'));
        }

        $datatablesJSON = DataTables::of($query);
        return $datatablesJSON->make(true);
     }


     public function approver($status){
        $query = DB::table('system_data_corrections')
        ->join('tickets', 'system_data_corrections.ticket_no', 'tickets.id')
        ->leftjoin('incidents', 'tickets.incident_id','incidents.id')
        ->selectRaw('system_data_corrections.id,
        system_data_corrections.sdc_no,
        tickets.id as ticket_id,
        incidents.subject, 
        system_data_corrections.requestor_name,
        system_data_corrections.dept_supervisor,
        system_data_corrections.department,
        system_data_corrections.position,
        system_data_corrections.date_submitted,
        system_data_corrections.posted,
        system_data_corrections.status');
        
        if($status != "all"){
           if($status == "pending"){
                $query = $query->where('system_data_corrections.status', 3);
           }elseif($status == "done"){
                $query = $query->whereIn('system_data_corrections.status',  array(4,5));
           }
        }else{
            $query = $query->whereIn('system_data_corrections.status', array(3,4,5));
        }

        $datatablesJSON = DataTables::of($query);
        return $datatablesJSON->make(true);
     }
}
