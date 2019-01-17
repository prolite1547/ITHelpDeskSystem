@extends('layouts.dashboardLayout')
@section('title','System Data Correction')
@section('submenu')
<ul class="submenu__ul"> 
    <li class="submenu__li">
    <a href="{{route('datacorrectons.govcompPENDING')}}" class="submenu__a {{Route::currentRouteName() == 'datacorrectons.govcompPENDING' ? 'submenu__a--active' : ''}}">Pending  ({{ $pendingCount }}) </a>
    </li>
    <li class="submenu__li">
    <a href="{{route('datacorrectons.govcompDONE')}}" class="submenu__a {{Route::currentRouteName() == 'datacorrectons.govcompDONE' ? 'submenu__a--active' : ''}}">Done  ({{ $doneCount }})</a>
    </li>
    <li class="submenu__li">
            <a href="{{route('datacorrectons.govcompALL')}}" class="submenu__a {{Route::currentRouteName() == 'datacorrectons.govcompALL' ? 'submenu__a--active' : ''}}">ALL  ({{ $allCount }})</a>
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
                    <table class="table" id="gc-table">
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
 