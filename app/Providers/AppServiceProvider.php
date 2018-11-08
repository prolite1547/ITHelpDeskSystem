<?php

namespace App\Providers;

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
        $issueSelect = selectArray(1);  /*Ticket*/
        $prioSelect = selectArray(2);   /*Priority*/
        $incSelect = selectArray(3);   /*Incident category*/
        $incASelect = selectArray(4); /*A Sub category for incident*/
        $callerSelect = Caller::get()->pluck('name','id');
        View::share([
            'issueSelect' => $issueSelect,
            'prioSelect' => $prioSelect,
            'incSelect' => $incSelect,
            'incASelect' => $incASelect,
            'callerSelect' => $callerSelect
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
