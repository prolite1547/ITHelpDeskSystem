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

    public function tickets($status){
        $group = getGroupIDDependingOnUser();
        $statuses = Status::whereNotIn('name',['user','fixed'])->pluck('name')->toArray();

        $extends_count = DB::table('extends')->selectRaw('ticket_id,count(ticket_id) as extend_count')->groupBy('ticket_id');

        /*DATATABLES PLUGIN INIT*/
        $query = DB::table('tickets')
        ->whereNull('deleted_at')
        ->join('incidents','tickets.incident_id','incidents.id')
            ->when(in_array(strtolower($status),array_map('strtolower',$statuses),true),function ($query) use ($status,$group){
                $get_status = Status::where('name',$status)->firstOrFail();
                return $query->whereStatus($get_status->id);
            })
            ->when($status === 'user',function ($query){
                return $query->where('assignee',Auth::user()->id)->where('status','!=',3);
            })
            ->when($status === 'fixed',function ($query) use($group){
                $fixed_details = DB::table('fixes')->selectRaw('ticket_id,max(created_at) as fix_date,fixed_by')->groupBy('fixes.ticket_id','fixed_by');

                return $query->whereStatus(4)->whereIn('group',$group)
                    ->leftJoinSub($fixed_details,'fixed_details',function ($join){
                        $join->on('tickets.id','=','fixed_details.ticket_id');
                    })->leftJoin('users as fixer','fixed_details.fixed_by','fixer.id')
                    ->addSelect(DB::raw('CONCAT(fixer.fName," ",fixer.lName) as fixed_by'),'fix_date');

            })
            ->leftJoinSub($extends_count,'extends_count',function($join){
                $join->on('tickets.id','=','extends_count.ticket_id');
            })
            ->leftJoin('stores','tickets.store','stores.id')
            ->leftJoin('ticket_groups','ticket_groups.id','tickets.group')
            ->leftJoin('calls','incidents.call_id','calls.id')
            ->leftJoin('resolves','tickets.id','resolves.ticket_id')
            ->leftJoin('categories as cat','incidents.category','cat.id')
            ->leftJoin('ticket_status as status','tickets.status','status.id')
            ->leftJoin('priorities as prio','tickets.priority','prio.id')
            ->leftJoin('users as assignee','tickets.assignee','assignee.id')
            ->leftJoin('users as resolver','resolves.resolved_by','resolver.id')
            ->selectRaw(
                'tickets.id,prio.name as priority,status.name as status,tickets.expiration,tickets.created_at,
            incidents.created_at as incident_created,incidents.subject,incidents.details,cat.name as category,
            CONCAT(assignee.fName," ",assignee.lName) as assignee,
            stores.store_name,
            CONCAT(resolver.fName," ",resolver.lName) as resolved_by,resolves.created_at as resolved_date,
            ticket_groups.name as ticket_group,
            extend_count'
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
