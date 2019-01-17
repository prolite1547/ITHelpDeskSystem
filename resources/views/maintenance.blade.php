@extends('layouts.dashboardLayout')
@section('title','Maintenance')
@section('submenu')@endsection

@section('content')
    <main>
        <div class="plusToggleContainer">
            <div class="form-contactAdd">
                <button class="form-contactAdd__button u-margin-l " type="button"><i
                        class="fas fa-plus"></i> Add Contact Number
                </button>

                <div class="form-contactAdd__content-box u-display-n">
                    {!! Form::open(['method' => 'POST','class' => 'form','id' => 'addContact']) !!}
                    <div class="form__group">
                        {!! Form::label('store_id','Branch:',['class' => 'form__label']) !!}
                        {!! Form::select('store_id',[] ,null, ['placeholder' => '(Choose branch..)','class' => 'form__input form__input--select2','data-select' => 'contact','id' => 'contactBranchSelect','required']) !!}
                    </div>
                    <div class="form__group u-display-n" id="contactFormGroup">
                        {!! Form::label('number','#',['class' => 'form__label']) !!}
                        {!! Form::text('number',null, ['placeholder' => 'Enter number...','class' => 'form__input','required']) !!}
                        {!! Form::button('Add',['type' => 'submit','class'=>'btn','data-action' => 'addContact']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </main>
@endsection
