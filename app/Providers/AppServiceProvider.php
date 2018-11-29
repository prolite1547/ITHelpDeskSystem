<?php

namespace App\Providers;

use App\Category;
use App\CategoryGroup;
use App\Role;
use App\Store;
use App\Ticket;
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Caller;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $openID = Category::where('name','LIKE','Open')->first()->id;
        $ongoingID = Category::where('name','LIKE','Ongoing')->first()->id;

        $ticketOpenCount = Ticket::whereStatus($openID)->count();
        $ticketOngoingCount = Ticket::whereStatus($ongoingID)->count();

        $statusSelect = selectArray(5,CategoryGroup::class);  /*Status*/
        $issueSelect = selectArray(1,CategoryGroup::class);  /*Ticket*/
        $prioSelect = selectArray(2,CategoryGroup::class);   /*Priority*/
        $incSelect = selectArray(3,CategoryGroup::class);   /*Incident category*/
        $incASelect = selectArray(4,CategoryGroup::class); /*A Sub category for incident*/
        $incBSelect = selectArray('',CategoryGroup::class); /*B Sub category for incident*/
        $callerSelect = Caller::get()->pluck('name','id');
        $branchGroupSelect = groupListSelectArray(Store::class,'store_name','contactNumbers','id','number');
        $branchSelect = Store::all()->pluck('store_name','id')->toArray();
        $assigneeSelect = groupListSelectArray(Role::class,'role','users','id','name');



        View::share([
            'statusSelect' => $statusSelect,
            'issueSelect' => $issueSelect,
            'prioSelect' => $prioSelect,
            'incSelect' => $incSelect,
            'incASelect' => $incASelect,
            'incBSelect' => $incBSelect,
            'callerSelect' => $callerSelect,
            'branchGroupSelect' => $branchGroupSelect,
            'branchSelect' => $branchSelect,
            'assigneeSelect' => $assigneeSelect,
            'ticketOpenCount' => $ticketOpenCount,
            'ticketOngoingCount' => $ticketOngoingCount
        ]);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


}
