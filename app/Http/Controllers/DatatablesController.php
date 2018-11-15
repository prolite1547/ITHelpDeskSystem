<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
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

    public function tickets($status){

        $get_status = Category::where('name',$status)->firstOrFail();

        $model = Ticket::with('incident','incident.call.contact.store','priorityRelation','assigneeRelation')
            ->where('tickets.status','=',$get_status->id);

        $datatablesJSON = DataTables::of($model)
            ->addColumn('subject_display', function ($data){
                return "
                        <a href='".\route('lookupTicketView',['id' => $data->id])."' class='table__subject'>{$data->incident->subject}</a>
                        <span class='table__info'>Ticket #: {$data->id}</span>
                        <span class='table__info'>Category: {$data->incident->categoryRelation->name}</span>
                        ";
            })
            ->addColumn('action',function ($data){
                return "
                        <div class='menu'>
                            <ul class='menu__list u-display-n'>
                                <li class='menu__item'><a href='#!' class='menu__link'>Print</a></li>
                                <li class='menu__item'><a href='#!' class='menu__link'>Delete</a></li>
                                <li class='menu__item'><a href='#!' class='menu__link'>Mark as resolved</a></li>
                            </ul>
                            <input type='checkbox' class='menu__checkbox'>
                        </div>   
                        ";
            })
            ->addColumn('priority',function ($data){
                return "<span class='u-bold u-".strtolower($data->priorityRelation->name)."'>".$data->priorityRelation->name."</span>";
            })
            ->addColumn('status',function ($data){

                return $data->statusRelation->name;
            })
            ->editColumn('store_name',function ($data){

                return $data->incident->call->contact->store->store_name;
            })
            ->rawColumns(['subject_display','action','priority']);

        if($status === 'ongoing'){
            $datatablesJSON = $datatablesJSON->addColumn('assignee',function ($data){

                return $data->assigneeRelation->name;
            });
        }

        return $datatablesJSON->make(true);
;
    }
}
