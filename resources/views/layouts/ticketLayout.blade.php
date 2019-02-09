@extends('layouts.master')

@section('inside_container')
    @include('includes.header')
    <main>
        <div class="row">
            <div class="col-1-of-5">
                @include('includes.ticket_filter')
            </div>
            <div class="col-4-of-5">
                @yield('table')
            </div>
        </div>
    </main>
@endsection
