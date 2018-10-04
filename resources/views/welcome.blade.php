@extends('layouts.master')

    @section('title','Login')

    @section('content')
        <div class="container container--login">
            <div class="banner">&nbsp;</div>
            <div class="login">
                <div class="u-center-text u-margin-bottom-small">
                    <h2 class="heading-secondary">
                        IT &dash; Monitoring
                    </h2>
                </div>
                <div class="login__form">

                    {!! Form::open(['method' => 'POST','route' => 'login', 'class' => 'form']) !!}
                    <div class="form__group form__group--login">
                        <i class="form__icon fas fa-user"></i>
                        {!! Form::text('uname','',['class'=>'form__input', 'placeholder' => 'username', 'id' => 'uname', 'required']) !!}
                    </div>

                    <div class="form__group form__group--login">
                        <i class="form__icon fas fa-ellipsis-h"></i>
                        {!! Form::password('password',['class'=>'form__input', 'placeholder' => 'password', 'id' => 'password', 'required']) !!}
                    </div>

                    <div class="form-group u-margin-top-xsmall">
                        {!! Form::button('Login',['type' => 'submit','class' => 'btn btn--blue u-width-full']) !!}
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    @endsection




