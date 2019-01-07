<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
   
    public function musers()
    {
        return view('maintenance.musers');
    }

    public function mcategories()
    {
        return view('maintenance.mcategories');
    }

    
}
