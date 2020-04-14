<?php

namespace App\Http\Controllers;
use App\Workstation;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(){
        return view('inventory.workstations');
    }
 
}
