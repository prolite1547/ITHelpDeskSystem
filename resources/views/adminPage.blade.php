@extends('layouts.dashboardLayout')
@section('title','Report')
@section('submenu')@endsection

@section('content')
    <div class="tool">
        <div class="tool-section">
            <div class="tool-section__header">User</div>
            <div class="tool-section__action">
                <div class="tool-section__action-group">
                    <svg class="tool-section__icon">
                        <use xlink:href="{{asset('svg/sprite2.svg#icon-add-user')}}"></use>
                    </svg>
                    <a href="#!" class="tool-section__label" data-action="addUserBtn">Add User</a>
                </div>

                <div class="tool-section__action-group">
                    <svg class="tool-section__icon">
                        <use xlink:href="{{asset('svg/sprite2.svg#icon-v-card')}}"></use>
                    </svg>
                    <a href="tae/ka" class="tool-section__label">User Profile</a>
                </div>
            </div>
        </div>
    </div>
@endsection
