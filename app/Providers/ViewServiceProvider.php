<?php

namespace App\Providers;

use App\Position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Caller;
use App\Category;
use App\CategoryGroup;
use App\Role;
use App\Store;
use App\Ticket;
use App\User;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        view()->composer(['includes.header','ticket.ticket_lookup'],function($view) {
            $openID = Category::where('name','LIKE','Open')->first()->id;
            $ongoingID = Category::where('name','LIKE','Ongoing')->first()->id;
            $closedID = Category::where('name','LIKE','Closed')->first()->id;
            $userID = Auth::id();


            $ticketOpenCount = Ticket::whereStatus($openID)->count();
            $ticketOngoingCount = Ticket::whereStatus($ongoingID)->count();
            $ticketClosedCount = Ticket::whereStatus($closedID)->count();
            $ticketUserTicketsCount = Ticket::whereAssignee($userID)->count();
            $ticketCount = Ticket::all()->count();
            $view->with([
                'ticketOpenCount' => $ticketOpenCount,
                'ticketOngoingCount' => $ticketOngoingCount,
                'ticketClosedCount' => $ticketClosedCount,
                'ticketCount' => $ticketCount,
                'ticketUserTicketsCount' => $ticketUserTicketsCount,
                'closedID' => $closedID,
                'ticketRoutes' => ['openTickets','myTickets','ongoingTickets','closedTickets','allTickets']
            ]);
        });


        view()->composer('modal.resolve_form',function ($view){

            $resolutionOptions = selectArray(8,CategoryGroup::class,'id','name');  /*Resolve*/

            $view->with([
                'resolutionOptions' => $resolutionOptions
            ]);
        });

        view()->composer(['ticket.add_ticket','modal.ticket_edit','modal.user_add'],function ($view) {

            $statusSelect = selectArray(5,CategoryGroup::class,'id','name');  /*Status*/
            $issueSelect = selectArray(1,CategoryGroup::class,'id','name');  /*Ticket*/
            $prioSelect = selectArray(2,CategoryGroup::class,'id','name');   /*Priority*/
            $typeSelect = selectArray(3,CategoryGroup::class,'id','name');   /*Incident category*/
            $incASelect = selectArray(4,CategoryGroup::class,'id','name'); /*A Sub category for incident*/
//            $incBSelect = selectArray('',CategoryGroup::class,'id','name'); /*B Sub category for incident*/
            $rolesSelect = selectArray('',Role::class,'id','role'); /*Roles*/
            $positionsSelect = selectArray('',Position::class,'id','position'); /*Roles*/
            $callerSelect = Caller::get()->pluck('name','id');
            $branchGroupSelect = groupListSelectArray(Store::class,'store_name','contactNumbers','id','number');
            $branchSelect = Store::all()->pluck('store_name','id')->toArray();
            $assigneeSelect = groupListSelectArray(Role::class,'role','users','id','full_name');


            $view->with(compact(
                'statusSelect',
                'issueSelect' ,
                'prioSelect' ,
                'typeSelect',
                'incASelect' ,
                'incBSelect' ,
                'callerSelect' ,
                'branchGroupSelect',
                'branchSelect',
                'assigneeSelect',
                'rolesSelect',
                'positionsSelect'
            ));
        });


        view()->composer('includes.ticket_filter',function ($view) {

            $categoryFilter = Category::whereGroup(3)->pluck('name','name');
            $statusFilter = Category::whereGroup(5)->pluck('name','name');
            $storeFilter = Store::pluck('store_name','store_name');

            $view->with(compact('categoryFilter','statusFilter','storeFilter'));
        });

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
