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
        @endsection
    </nav
@endsection

@section('content')
   <main>
       <div class="row">
            
            <div class="row">
                
                <div class="col-3-of-4">
                        <table class="table" id="users-table">
                                <thead class="table__thead">
                                <th class="table__th">Fullname</th>
                                <th class="table__th">Username</th>
                                <th class="table__th">Email</th>
                                <th class="table__th">Password</th>
                                <th class="table__th">Store</th>
                                <th class="table__th">Position</th>
                                <th class="table__th">Role</th>
                                </thead>
                                <tbody class="table__tbody">
                    
                                </tbody><tbody class="table__tbody">
                                       
                                </tbody>
                            </table>   
                </div>
                <div class="col-1-of-4">
                    @include('includes.mactions')
                </div>
                            
            </div>
        </div>
         
   </main>
@endsection
 