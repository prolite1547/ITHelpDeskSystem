<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        $issueSelect = selectArray(1);  /*Ticket*/
//        $prioSelect = selectArray(2);   /*Priority*/
//        $incSelect = selectArray(3);   /*Incident category*/
//        $incASelect = selectArray(4); /*A Sub category for incident*/

//        View::share([
//            'issueSelect' => $issueSelect,
//            'prioSelect' => $prioSelect,
//            'incSelect' => $incSelect,
//            'incASelect' => $incASelect
//        ]);
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
