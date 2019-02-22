@extends('layouts.dashboardLayout')
@section('title','System Data Correction')
@section('submenu')
<ul class="submenu__ul">
    <li class="submenu__li">
            <a href="{{route('datacorrectons.sdcDeployment')}}" class="submenu__a {{Route::currentRouteName() == 'datacorrectons.sdcDeployment' ? 'submenu__a--active' : ''}}">For Deployment  ({{ $forDeploymentCount }}) </a>
    </li>
    <li class="submenu__li">
    <a href="{{route('datacorrectons.sdcTreasury1')}}" class="submenu__a {{Route::currentRouteName() == 'datacorrectons.sdcTreasury1' ? 'submenu__a--active' : ''}}">Treasury I ({{ $ty1Count }})</a> 
    </li>
    <li class="submenu__li">
            <a href="{{route('datacorrectons.sdcTreasury2')}}" class="submenu__a {{Route::currentRouteName() == 'datacorrectons.sdcTreasury2' ? 'submenu__a--active' : ''}}">Treasury II  ({{ $ty2Count }})</a>
    </li>
    <li class="submenu__li">
        <a href="{{route('datacorrectons.sdcGovComp')}}" class="submenu__a {{Route::currentRouteName() == 'datacorrectons.sdcGovComp' ? 'submenu__a--active' : ''}}">Gov. Compliance  ({{ $govcompCount }})</a>
    </li>
   
    <li class="submenu__li">
        <a href="{{route('datacorrectons.sdcFinalApp')}} " class="submenu__a {{Route::currentRouteName() == 'datacorrectons.sdcFinalApp' ? 'submenu__a--active' : ''}}">Final Approver  ({{ $finalAppCount }})</a>
    </li>
    ||
    <li class="submenu__li">
            <a href="{{route('datacorrectons.sdcDraft')}}" class="submenu__a {{Route::currentRouteName() == 'datacorrectons.sdcDraft' ? 'submenu__a--active' : ''}}">Draft  ({{ $draftCount }})</a>
    </li> 
    <li class="submenu__li">
            <a href="{{route('datacorrectons.sdcDone')}} " class="submenu__a {{Route::currentRouteName() == 'datacorrectons.sdcDone' ? 'submenu__a--active' : ''}}">Done ({{ $doneCount }})</a>
    </li>
    <li class="submenu__li">
            <a href="{{route('datacorrectons.sdcRejected')}} " class="submenu__a {{Route::currentRouteName() == 'datacorrectons.sdcRejected' ? 'submenu__a--active' : ''}}">Rejected ({{ $rejectedCount }})</a>
    </li>
    <li class="submenu__li">
            <a href="{{route('datacorrectons.sdcAll')}} " class="submenu__a {{Route::currentRouteName() == 'datacorrectons.sdcAll' ? 'submenu__a--active' : ''}}">ALL ({{ $sdcCount }})</a>
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
                                <dd class="side__dd {{ in_array(Route::currentRouteName(),$dcRoutes) ? 'submenu__a--active' : ''}}"><a href="{{ route('datacorrectons.sdcDeployment') }}" style="text-decoration:none;color:white;">System Data Correction ({{ $sdcCount }})</a></dd>
                                <dd class="side__dd {{Route::currentRouteName() == 'datacorrections.manual' ? 'submenu__a--active' : ''}}"><a href="{{ route('datacorrections.manual') }}" style="text-decoration:none;color:black;">Manual Data Correction ({{ $mdcCount }})</a></dd>
                            </dl>
                        </div>
                    </aside>
                    
                </div>
                <div style="display:inline-block; float:right;">
                        <span>Search : </span><input  type="text"  id="search">
                </div>
                <div class="col-3-of-4">
                    
                    <table class="table" id="sdc-table">
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
 