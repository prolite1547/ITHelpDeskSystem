<?php

namespace App\Providers;

use App\CategoryA;
use App\CategoryB;
use App\Position;
use App\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Caller;
use App\Category;
use App\CategoryGroup;
use App\Role;
use App\Store;
use App\Ticket;
use App\User;
use App\SystemDataCorrection;
use App\ManualDataCorrection;
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
            $openID = Status::where('name','LIKE','Open')->first()->id;
            $ongoingID =  Status::where('name','LIKE','Ongoing')->first()->id;
            $closedID =  Status::where('name','LIKE','Closed')->first()->id;
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
                'ticketRoutes' => ['openTickets','myTickets','ongoingTickets','closedTickets','allTickets'],
                'dcRoutes' => ['datacorrections.system', 'datacorrections.manual']
            ]);
        });


        view()->composer('modal.resolve_form',function ($view){

            $resolutionOptions = DB::table('resolve_categories')->pluck('name','id')->toArray();  /*Resolve*/

            $view->with([
                'resolutionOptions' => $resolutionOptions
            ]);
        });

        view()->composer(['ticket.add_ticket','modal.ticket_edit','modal.user_add'],function ($view) {

            $statusSelect = DB::table('ticket_status')->pluck('name','id')->toArray();  /*Status*/
            /*$issueSelect = selectArray(1,CategoryGroup::class,'id','name');*/  /*Ticket*/
            $prioSelect = DB::table('priorities')->pluck('name','id')->toArray();   /*Priority*/
            $typeSelect = DB::table('categories')->pluck('name','id')->toArray();   /*Incident category*/
            $incBSelect = DB::table('category_b')->pluck('name','id')->toArray(); /*A Sub category for incident*/
//            $incBSelect = selectArray('',CategoryGroup::class,'id','name'); /*B Sub category for incident*/
            $rolesSelect = selectArray('',Role::class,'id','role'); /*Roles*/
            $positionsSelect = selectArray('',Position::class,'id','position'); /*Roles*/
            $callerSelect = Caller::get()->pluck('name','id');
            $branchGroupSelect = groupListSelectArray(Store::class,'store_name','contactNumbers','id','number');
            $categoryBGroupSelect = groupListSelectArray(CategoryA::class,'name','subCategories','id','name');
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
                'positionsSelect',
                'categoryBGroupSelect'
            ));
        });


        view()->composer('includes.ticket_filter',function ($view) {

            $categoryFilter = DB::table('categories')->pluck('name','name');
            $statusFilter = DB::table('ticket_status')->pluck('name','name');
            $storeFilter = Store::pluck('store_name','store_name');

            $view->with(compact('categoryFilter','statusFilter','storeFilter'));
        });

        view()->composer('datacorrections.systemdcs',function($view){
           $sdcCount = SystemDataCorrection::all()->count();
           $mdcCount = ManualDataCorrection::all()->count();
           $view->with(['sdcCount'=> $sdcCount, 'mdcCount'=>$mdcCount]);
        });
       
        
        view()->composer('datacorrections.manualdcs',function($view){
            $mdcCount = ManualDataCorrection::all()->count();
            $sdcCount = SystemDataCorrection::all()->count();
            $view->with(['mdcCount'=>$mdcCount, 'sdcCount'=>$sdcCount]);
         });

         view()->composer('datacorrections.datacorrections',function($view){
            $mdcCount = ManualDataCorrection::all()->count();
            $sdcCount = SystemDataCorrection::all()->count();
            $view->with(['mdcCount'=>$mdcCount, 'sdcCount'=>$sdcCount]);
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
