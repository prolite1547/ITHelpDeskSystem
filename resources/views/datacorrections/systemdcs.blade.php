@extends('layouts.dashboardLayout')
@section('title','System Data Correction')
@section('submenu')
<ul class="submenu__ul">
    <li class="submenu__li">
            <a href="{{route('datacorrectons.sdcApproved')}}" class="submenu__a {{Route::currentRouteName() == 'datacorrectons.sdcApproved' ? 'submenu__a--active' : ''}}">Approved</a>
    </li>
    <li class="submenu__li">
            <a href="{{route('datacorrectons.sdcSave')}}" class="submenu__a {{Route::currentRouteName() == 'datacorrectons.sdcSave' ? 'submenu__a--active' : ''}}">Saved</a>
    </li>     
    <li class="submenu__li">
            <a href="{{route('datacorrectons.sdcPosted')}}" class="submenu__a {{Route::currentRouteName() == 'datacorrectons.sdcPosted' ? 'submenu__a--active' : ''}}">Posted</a>
    </li>
    <li class="submenu__li">
            <a href="{{route('datacorrectons.sdcOngoing')}}" class="submenu__a {{Route::currentRouteName() == 'datacorrectons.sdcOngoing' ? 'submenu__a--active' : ''}}">Ongoing</a>
    </li>
    <li class="submenu__li">
        <a href="{{route('datacorrectons.sdcForApproval')}}" class="submenu__a {{Route::currentRouteName() == 'datacorrectons.sdcForApproval' ? 'submenu__a--active' : ''}}">For Approval</a>
    </li>
   
    <li class="submenu__li">
        <a href="{{route('datacorrectons.sdcDone')}} " class="submenu__a {{Route::currentRouteName() == 'datacorrectons.sdcDone' ? 'submenu__a--active' : ''}}">Done</a>
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
                                <dd class="side__dd {{ in_array(Route::currentRouteName(),$dcRoutes) ? 'selecteddc--active' : ''}}"><a href="{{ route('datacorrectons.sdcApproved') }}" style="text-decoration:none;color:white;">System Data Correction ({{ $sdcCount }})</a></dd>
                                <dd class="side__dd {{Route::currentRouteName() == 'datacorrections.manual' ? 'selecteddc--active' : ''}}"><a href="{{ route('datacorrections.manual') }}" style="text-decoration:none;color:black;">Manual Data Correction ({{ $mdcCount }})</a></dd>
                            </dl>
                        </div>
                    </aside>
                    
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
 