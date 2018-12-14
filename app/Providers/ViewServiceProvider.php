<?php

namespace App\Providers;

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

            $resolutionOptions = selectArray(8,CategoryGroup::class);  /*Resolve*/

            $view->with([
                'resolutionOptions' => $resolutionOptions
            ]);
        });

        view()->composer(['ticket.add_ticket','modal.ticket_edit','includes.ticket_filter'],function ($view) {

            $statusSelect = selectArray(5,CategoryGroup::class);  /*Status*/
            $issueSelect = selectArray(1,CategoryGroup::class);  /*Ticket*/
            $prioSelect = selectArray(2,CategoryGroup::class);   /*Priority*/
            $typeSelect = selectArray(3,CategoryGroup::class);   /*Incident category*/
            $incASelect = selectArray(4,CategoryGroup::class); /*A Sub category for incident*/
            $incBSelect = selectArray('',CategoryGroup::class); /*B Sub category for incident*/
            $callerSelect = Caller::get()->pluck('name','id');
            $branchGroupSelect = groupListSelectArray(Store::class,'store_name','contactNumbers','id','number');
            $branchSelect = Store::all()->pluck('store_name','id')->toArray();
            $assigneeSelect = groupListSelectArray(Role::class,'role','users','id','name');


            $view->with([
                'statusSelect' => $statusSelect,
                'issueSelect' => $issueSelect,
                'prioSelect' => $prioSelect,
                'typeSelect' => $typeSelect,
                'incASelect' => $incASelect,
                'incBSelect' => $incBSelect,
                'callerSelect' => $callerSelect,
                'branchGroupSelect' => $branchGroupSelect,
                'branchSelect' => $branchSelect,
                'assigneeSelect' => $assigneeSelect,
            ]);
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
