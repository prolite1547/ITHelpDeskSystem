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

    public function tickets($status)
    {
        if($status === 'pos'){
            $query = DB::table('v_tickets as vt')->select('vt.id','vt.subject','vt.details','vt.status_name','vt.assignee','vt.store_name','logged_by');
        }else{
            $statuses = Status::whereNotIn('name', ['fixed','closed'])->pluck('name')->toArray();
            $query = DB::table('v_tickets as tickets')
                ->select(
                    'tickets.id', 'priority', 'status','status_name', 'expiration', 'tickets.created_at',
                    'subject', 'details', 'category',
                    'assignee',
                    'store_name',
                    'logged_by',
                    'ticket_group',
                    'extend_count'
                )
                ->when(in_array(strtolower($status), array_map('strtolower', $statuses), true), function ($query) use ($status) {
                    $get_status = Status::where('name', $status)->firstOrFail();
                    return $query->whereStatus($get_status->id);
                })
                ->when($status === 'my', function ($query) {
                    return $query->whereAssigneeId(Auth::user()->id)->where('status', '!=', 3);
                })
                ->when($status === 'fixed', function ($query) {

                    $group = Auth::user()->group;

                    $fixed_details = DB::table('fixes')->selectRaw('ticket_id,max(created_at) as fix_date,fixed_by')->groupBy('fixes.ticket_id', 'fixed_by');

                    return $query->whereStatus(4)
                        ->when($group, function ($query, $group) {
                            return $query->whereGroup($group);
                        })
                        ->leftJoinSub($fixed_details, 'fixed_details', function ($join) {
                            $join->on('tickets.id', '=', 'fixed_details.ticket_id');
                        })->leftJoin('users as fixer', 'fixed_details.fixed_by', 'fixer.id')
                        ->addSelect(DB::raw('CONCAT(fixer.fName," ",fixer.lName) as fixed_by'), 'fix_date');

                })
                ->when($status === 'closed',function ($query){
                    return $query->join('v_resolves','tickets.id','v_resolves.ticket_id')
                        ->addSelect('resolver','resolved_date');
                });
        }
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

    public function sdc()
    {
        $query = DB::table('system_data_corrections')
            ->join('tickets', 'system_data_corrections.ticket_no', 'tickets.id')
            ->leftjoin('incidents', 'tickets.incident_id', 'incidents.id')
            ->selectRaw('system_data_corrections.id,system_data_corrections.sdc_no ,tickets.id as ticket_id ,incidents.subject, system_data_corrections.requestor_name, system_data_corrections.dept_supervisor ,system_data_corrections.department, system_data_corrections.position, system_data_corrections.date_submitted, system_data_corrections.posted');
        $query = $query->orderBy('system_data_corrections.created_at', 'desc');
        $datatablesJSON = DataTables::of($query);
        return $datatablesJSON->make(true);
    }

    public function system($status)
    {


        $query = DB::table('system_data_corrections')
            ->join('tickets', 'system_data_corrections.ticket_no', 'tickets.id')
            ->leftjoin('incidents', 'tickets.incident_id', 'incidents.id')
            ->selectRaw('system_data_corrections.id,system_data_corrections.sdc_no ,tickets.id as ticket_id ,incidents.subject, system_data_corrections.requestor_name, system_data_corrections.dept_supervisor ,system_data_corrections.department, system_data_corrections.position, system_data_corrections.date_submitted, system_data_corrections.posted, system_data_corrections.status');

        switch ($status) {
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


    public function mdc()
    {
        $query = DB::table('manual_data_corrections')
            ->join('tickets', 'manual_data_corrections.ticket_no', 'tickets.id')
            ->leftjoin('incidents', 'tickets.incident_id', 'incidents.id')
            ->selectRaw('manual_data_corrections.id,manual_data_corrections.mdc_no ,tickets.id as ticket_id ,incidents.subject, manual_data_corrections.requestor_name ,manual_data_corrections.department, manual_data_corrections.position, manual_data_corrections.date_submitted, manual_data_corrections.posted');
        $query = $query->orderBy('manual_data_corrections.created_at', 'desc');
        $datatablesJSON = DataTables::of($query);
        return $datatablesJSON->make(true);
    }

    public function treasury($status)
    {
        $query = DB::table('system_data_corrections')
            ->join('tickets', 'system_data_corrections.ticket_no', 'tickets.id')
            ->leftjoin('incidents', 'tickets.incident_id', 'incidents.id')
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

        if ($status != "all") {
            if ($status == "pending") {
                $query = $query->where('system_data_corrections.status', '1');
            } elseif ($status == "done") {
                $query = $query->whereIn('system_data_corrections.status', array('2', '3', '4', '5'));
            }
        } else {
            $query = $query->whereIn('system_data_corrections.status', array('1', '2', '3'));
        }

        $datatablesJSON = DataTables::of($query);
        return $datatablesJSON->make(true);
    }

    public function govcomp($status)
    {
        $query = DB::table('system_data_corrections')
            ->join('tickets', 'system_data_corrections.ticket_no', 'tickets.id')
            ->leftjoin('incidents', 'tickets.incident_id', 'incidents.id')
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

        if ($status != "all") {
            if ($status == "pending") {
                $query = $query->where('system_data_corrections.status', '2');
            } elseif ($status == "done") {
                $query = $query->whereIn('system_data_corrections.status', array('3', '4', '5'));
            }
        } else {
            $query = $query->whereIn('system_data_corrections.status', array('2', '3'));
        }

        $datatablesJSON = DataTables::of($query);
        return $datatablesJSON->make(true);
    }


    public function approver($status)
    {
        $query = DB::table('system_data_corrections')
            ->join('tickets', 'system_data_corrections.ticket_no', 'tickets.id')
            ->leftjoin('incidents', 'tickets.incident_id', 'incidents.id')
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

        if ($status != "all") {
            if ($status == "pending") {
                $query = $query->where('system_data_corrections.status', 3);
            } elseif ($status == "done") {
                $query = $query->whereIn('system_data_corrections.status', array(4, 5));
            }
        } else {
            $query = $query->whereIn('system_data_corrections.status', array(3, 4, 5));
        }

        $datatablesJSON = DataTables::of($query);
        return $datatablesJSON->make(true);
    }

}
