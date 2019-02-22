<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DCController extends Controller
{  

   public function __construct()
   {
       $this->middleware('auth');
   }
     public function index(){
         return view('datacorrections.datacorrections');
     }

     public function system(){
        return view('datacorrections.systemdcs');
     }

     public function manual(){
        return view('datacorrections.manualdcs');
     }

     public function treasury_pending(){
        return view('datacorrections.treasury');
     }

     public function treasury_all(){
        return view('datacorrections.treasury');
     }

     public function treasury_done(){
         return view('datacorrections.treasury');
     }



     public function treasury2_pending(){
      return view('datacorrections.treasury2');
   }

   public function treasury2_all(){
      return view('datacorrections.treasury2');
   }

   public function treasury2_done(){
       return view('datacorrections.treasury2');
   }


     public function govcomp_all(){
         return view('datacorrections.govcomp');
     }

      public function govcomp_done(){
         return view('datacorrections.govcomp');
        
     }
      public function govcomp_pending(){
         return view('datacorrections.govcomp');
     }

     public function approver_all(){
        return view('datacorrections.approver');
     }

     public function approver_pending(){
        return view('datacorrections.approver');
     }

     public function approver_done(){
        return view('datacorrections.approver');
     }

     public function sdc_route(){
        return view('datacorrections.systemdcs');
     }

     


}
