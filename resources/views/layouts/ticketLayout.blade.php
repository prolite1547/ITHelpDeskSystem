@extends('layouts.master')

@section('inside_container')
    @include('includes.header')
    <main>
        <div class="row">
            <div class="col-1-of-4">
                @include('includes.ticket_filter')
            </div>
            <div class="col-3-of-4">
                @yield('table')
            </div>
        </div>
    </main>
@endsection
