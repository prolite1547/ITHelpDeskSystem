<?php

namespace App\Http\Controllers;

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

class DatatablesController extends Controller
{


    public function ajax()
    {
        return Datatables::of(User::query())->make(true);
    }

    public function tickets(Request $request,$status){
        $statuses = Category::whereGroup(5)->whereNotIn('name',['all','user'])->pluck('name')->toArray();

        $query = DB::table('tickets')
        ->join('incidents','tickets.incident_id','incidents.id')
            ->leftJoin('calls','incidents.call_id','calls.id')
            ->leftJoin('callers','calls.caller_id','callers.id')
            ->leftJoin('resolves','tickets.id','resolves.ticket_id')
            ->leftJoin('stores','callers.store_id','stores.id')
            ->leftJoin('categories as cat','incidents.category','cat.id')
            ->leftJoin('categories as status','tickets.status','status.id')
            ->leftJoin('categories as prio','tickets.priority','prio.id')
            ->leftJoin('users as assignee','tickets.assignee','assignee.id')
            ->leftJoin('users as resolver','resolves.resolved_by','resolver.id')
            ->selectRaw(
                'tickets.id,tickets.assignee,prio.name as priority,status.name as status,tickets.expiration,tickets.created_at,
                incidents.created_at as incident_created,incidents.subject,incidents.details,cat.name as category,
                CONCAT(assignee.fName," ",assignee.lName) as assignee,
                stores.store_name,
                CONCAT(resolver.fName," ",resolver.lName) as resolved_by,resolves.created_at as resolved_date'
            );

        if(in_array(strtolower($status),array_map('strtolower',$statuses),true)){
            $get_status = Category::where('name',$status)->firstOrFail();
            $query = $query->whereStatus($get_status->id);
        }elseif ($status === 'user'){
            $query = $query->where('assignee',Auth::user()->id);
        }


        $datatablesJSON = DataTables::of($query);



        return $datatablesJSON->make(true);

    }
}
