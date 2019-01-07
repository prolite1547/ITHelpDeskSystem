@extends('layouts.dashboardLayout')
@section('submenu')
<nav class="submenu">
        @section('submenu')
            <ul class="submenu__ul">
               
                <li class="submenu__li">
                        <a href="{{route('mUsersPage')}}" class="submenu__a {{Route::currentRouteName() == 'mUsersPage' ? 'submenu__a--active' : ''}}">Users <span> ({{ $usersCount }})</span></a>
                </li>
                <li class="submenu__li">
                        <a href="{{route('mCategoriesPage')}}" class="submenu__a {{Route::currentRouteName() == 'mCategoriesPage' ? 'submenu__a--active' : ''}}">Categories</a>
                </li>
            </ul>
        @show
    </nav
@endsection

@section('content')
<main>
        <div class="row">
            
            <div class="col-3-of-4">
                
            </div>
        </div>
    </main>
@endsection
 
 