<?php

namespace App\Providers;

use App\CategoryA;
use App\CategoryB;
use App\Department;
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

        view()->composer('*',function($view){

            $ticket_status_arr = Status::all(['id','name'])->pluck('id','name')->toArray();


            $user_roles = array('admin'=> 4,'user'=> 3,'1support'=> 1,'tower'=> 2);
            $higherUserGroup = array($user_roles['admin'],$user_roles['tower']);
            $view->with(compact(
                'ticket_status_arr',
                'user_roles',
                    'higherUserGroup'
                )
            );
        });

        view()->composer(['includes.header', 'ticket.ticket_lookup'], function ($view) {
            $userID = Auth::id();
            $notificationContent = getNotificationContent($userID);
            $dcRoutes = ['datacorrections.system', 'datacorrections.manual', 'datacorrectons.sdcSave', 'datacorrectons.sdcPosted', 'datacorrectons.sdcOngoing', 'datacorrectons.sdcForApproval', 'datacorrectons.sdcApproved', 'datacorrectons.sdcDone'];
            $ticketRoutes = ['openTickets', 'myTickets', 'ongoingTickets', 'closedTickets', 'allTickets'];
            $tyRoutes = ['datacorrectons.treasuryALL', 'datacorrectons.treasuryDONE', 'datacorrectons.treasuryPENDING'];
            $gcRoutes = ['datacorrectons.govcompALL', 'datacorrectons.govcompDONE', 'datacorrectons.govcompPENDING'];
            $appRoutes = ['datacorrectons.approverALL', 'datacorrectons.approverDONE', 'datacorrectons.approverPENDING'];

            $ticketCounts = getNumberOfTicketsOnASpecStatus();
            $ticketUserTicketsCount = Ticket::whereAssignee($userID)->where('status','!=',3)->count();
            $view->with(compact(
                'ticketCounts',
                'ticketUserTicketsCount',
                'ticketRoutes',
                'dcRoutes',
                'notificationContent',
                'tyRoutes',
                'dcRoutes',
                'gcRoutes',
                'appRoutes'
            ));
        });


        view()->composer('modal.fix_form', function ($view) {

            $resolutionOptions = DB::table('resolve_categories')->pluck('name', 'id')->toArray();  /*Resolve*/

            $view->with([
                'resolutionOptions' => $resolutionOptions
            ]);
        });

        view()->composer(['ticket.add_ticket', 'modal.ticket_edit', 'modal.user_add', 'ticket.incomplete'], function ($view) {
            $selfOption = [null => 'None', Auth::id() => 'Self'];
            $statusSelect = DB::table('ticket_status')->pluck('name', 'id')->toArray();  /*Status*/
            $prioSelect = DB::table('priorities')->pluck('name', 'id')->toArray();   /*Priority*/
            $typeSelect = DB::table('categories')->where('name','!=','Connection')->pluck('name', 'id')->toArray();   /*Incident category*/
            $incBSelect = DB::table('category_b')->whereNotIn('id',[16,17,18])->pluck('name', 'id')->toArray(); /*A Sub category for incident*/
            $groupSelect = DB::table('ticket_groups')->pluck('name', 'id')->toArray(); /*TICKET_GROUP*/
            $rolesSelect = selectArray('', Role::class, 'id', 'role'); /*Roles*/
            $positionsSelect = selectArray('', Position::class, 'id', 'position'); /*Roles*/
            $departmentSelect = selectArray('', Department::class, 'id', 'department'); /*Roles*/
            $callerSelect = Caller::get()->pluck('name', 'id');
            $categoryBGroupSelect = groupListSelectArray(CategoryA::class, 'name', 'subCategories', 'id', 'name',array('column' => 'id','values' => [6]));
            $categoryCGroupSelect = groupListSelectArray(CategoryB::class, 'name', 'subCategories', 'id', 'name');
            $branchSelect = Store::all()->pluck('store_name', 'id')->toArray();
            $assigneeSelect = groupListSelectArray(Role::class, 'role', 'users', 'id', 'full_name');

            $view->with(compact(
                'statusSelect',
                'prioSelect',
                'typeSelect',
                'incBSelect',
                'callerSelect',
                'branchSelect',
                'assigneeSelect',
                'rolesSelect',
                'positionsSelect',
                'departmentSelect',
                'categoryBGroupSelect',
                'selfOption',
                'groupSelect',
                'categoryCGroupSelect'
            ));
        });


        view()->composer('includes.ticket_filter', function ($view) {

            $categoryFilter = DB::table('categories')->pluck('name', 'name');
            $statusFilter = DB::table('ticket_status')->pluck('name', 'name');
            $storeFilter = Store::pluck('store_name', 'store_name');

            $view->with(compact('categoryFilter', 'statusFilter', 'storeFilter'));
        });

        view()->composer('datacorrections.systemdcs',function($view){
           $sdcCount = SystemDataCorrection::all()->count();
           $mdcCount = ManualDataCorrection::all()->count();
           $savedCount = SystemDataCorrection::where('status','=',0)->count();
           $postedCount = SystemDataCorrection::where('status','=',1)->count();
           $ongoingCount = SystemDataCorrection::where('status', '=', 2)->count();
           $forApprovalCount = SystemDataCorrection::where('status', '=', 3)->count();
           $approvedCount = SystemDataCorrection::where('status', '=', 4)->count();
           $doneCount = SystemDataCorrection::where('status', '=', 5)->count();
           

           $view->with(['sdcCount'=> $sdcCount, 'mdcCount'=>$mdcCount, 'savedCount'=>$savedCount ,'postedCount'=>$postedCount, 'ongoingCount'=>$ongoingCount, 'forApprovalCount'=>$forApprovalCount, 'approvedCount'=>$approvedCount, 'doneCount'=>$doneCount,
           'dcRoutes' => ['datacorrections.system','datacorrectons.sdcSave', 'datacorrectons.sdcPosted', 'datacorrectons.sdcOngoing', 'datacorrectons.sdcForApproval', 'datacorrectons.sdcApproved', 'datacorrectons.sdcDone']
           ]);
        });


        view()->composer('datacorrections.manualdcs', function ($view) {
            $mdcCount = ManualDataCorrection::all()->count();
            $sdcCount = SystemDataCorrection::all()->count();
            $view->with(['mdcCount' => $mdcCount, 'sdcCount' => $sdcCount]);
        });

        view()->composer('datacorrections.datacorrections', function ($view) {
            $mdcCount = ManualDataCorrection::all()->count();
            $sdcCount = SystemDataCorrection::all()->count();
            $view->with(['mdcCount'=>$mdcCount, 'sdcCount'=>$sdcCount]);
         });



         view()->composer('datacorrections.govcomp',function($view){
            $pendingCount = SystemDataCorrection::where('status',2)->count();
            $doneCount = SystemDataCorrection::whereIn('status', array(3,4,5))->count();
            $allCount = SystemDataCorrection::whereIn('status', array(2,3,4,5))->count();
            $view->with(['pendingCount'=>$pendingCount, 'doneCount'=>$doneCount, 'allCount'=> $allCount]);
         });


         view()->composer('datacorrections.approver',function($view){
            $pendingCount = SystemDataCorrection::where('status',3)->count();
            $doneCount = SystemDataCorrection::whereIn('status', array(4,5))->count();
            $allCount = SystemDataCorrection::whereIn('status', array(3,4,5))->count();
            $view->with(['pendingCount'=>$pendingCount, 'doneCount'=>$doneCount, 'allCount'=> $allCount]);
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
