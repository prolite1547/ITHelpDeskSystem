<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SystemDataCorrection;
use App\ManualDataCorrection;


class PrintController extends Controller
{
    public function sdcprinter($id){
        $sdc = SystemDataCorrection::find($id);
        return view('layouts.sdcprint')->with('sdc',$sdc);
    }

    public function mdcprinter($id){
        $mdc = ManualDataCorrection::find($id);
        return view('layouts.mdcprint')->with('mdc',$mdc);

    }
}
