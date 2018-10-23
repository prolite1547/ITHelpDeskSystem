@extends('layouts.master')

@section('content')
    @include('includes.header')

    <div class="container-dashboard">
        @yield('dashboardContent')
    </div>
@endsection
