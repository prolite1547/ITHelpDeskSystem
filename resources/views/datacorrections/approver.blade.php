@extends('layouts.dashboardLayout')
@section('title','System Data Correction')
@section('submenu')
<ul class="submenu__ul"> 
    <li class="submenu__li">
    <a href="{{route('datacorrectons.approverPENDING')}}" class="submenu__a {{Route::currentRouteName() == 'datacorrectons.approverPENDING' ? 'submenu__a--active' : ''}}">Pending  <span>({{ $pendingCount }})</span></a>
    </li>
   
    <li class="submenu__li">
            <a href="{{route('datacorrectons.approverDONE')}}" class="submenu__a {{Route::currentRouteName() == 'datacorrectons.approverDONE' ? 'submenu__a--active' : ''}}">Done  <span>({{ $doneCount }})</span></a>
    </li>
    
    <li class="submenu__li">
            <a href="{{route('datacorrectons.approverALL')}}" class="submenu__a {{Route::currentRouteName() == 'datacorrectons.approverALL' ? 'submenu__a--active' : ''}}">All <span>({{ $allCount }})</span></a>
    </li>
</ul>
@endsection
@section('content')
    <main>
            <div class="row" >
                <div class="col-1-of-4">
                    <aside class="side">
                        <div class="side__title">
                            <h3 class="heading-tertiary">Data Corrections</h3>
                             
                        </div>
                        <div class="side__content">
                            <dl class="side__dl" >
                                <dt class="side__dt">All types</span></dt>
                                    <dd class="side__dd">System Data Corrections </dd>
                                </dl>
                        </div>
                    </aside>
                    
                </div>
                <div class="col-3-of-4">
                    <table class="table" id="app-table">
                        <thead class="table__thead">
                        <th class="table__th">Subject</th>
                        <th class="table__th">Requestor</th>
                        <th class="table__th">Department Supervisor</th>
                        <th class="table__th">Department</th>
                        <th class="table__th">Position</th>
                        <th class="table__th">Date Submitted</th>
                        </thead>
                        <tbody class="table__tbody">
                
                        </tbody><tbody class="table__tbody">
                
                        </tbody>
                    </table>
                </div>
            </div>
            
    </main>
@endsection
 