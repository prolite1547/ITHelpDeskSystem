@extends('layouts.dashboardLayout')
@section('title','Dashboard')
@section('submenu')@endsection

@section('content')
    <div class="iframe-container" style="width: 100%;height: 100vh;">
        <iframe src="{{ route('reports.charts') }}" frameborder="0" frameborder="0" width="100%" height="100%" scrolling="yes"></iframe>
    </div>
@endsection
