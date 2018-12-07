@extends('layouts.dashboardLayout')
@section('title','Profile')
@section('submenu')@endsection
@section('content')
    <main>
        <div class="row">
            <div class="col-1-of-4">
                <div class="user">
                    <div class="user__img-box">
                        <img src="{{asset("storage/profpic/".$user->profpic->image."")}}" alt="" class="user__img">
                        <div class="user__edit">
                            <label>
                                <i class="far fa-edit" title="Edit Profile Picture"></i>
                                <input type="file" id="profImage" name="profImage" style="display: none;" accept="image/*">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3-of-4">
                    <h2 class="heading-secondary">{{$user->name}}</h2>
            </div>
        </div>
    </main>
@endsection

