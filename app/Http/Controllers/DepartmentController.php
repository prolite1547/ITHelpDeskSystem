<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\StoreDepartment;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','check.role']);
    }

    public function create(StoreDepartment $request){
        Department::create($request->except('_token'));
    }
}
