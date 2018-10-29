@extends('layouts.dashboardLayout')
@section('title','Add Ticket')
@section('submenu')@endsection
@section('dashboardContent')
    <div class="window">
        <div class="window__title-box">
            <h3 class="heading-tertiary">New Ticket</h3>
        </div>
        <div class="window__content">
            {!! Form::open(['method' => 'POST','class' => 'form']) !!}
            <div class="form__group">
                {!! Form::label('caller','Caller :',['class' => 'form__label'])!!}
                {!! Form::text('caller',null,['class' => 'form__input','placeholder' => 'caller name']) !!}
            </div>
            <div class="form__group">
                {!! Form::label('callerNum','Caller #:',['class' => 'form__label']) !!}
                {!! Form::text('callerNum',null,['class' => 'form__input','placeholder' => 'caller number']) !!}
            </div>
            <div class="form__group">
                {!! Form::label('subject','Subject :',['class' => 'form__label form__label--block'])!!}
                {!! Form::text('subject',null,['class' => 'form__input form__input--100w','placeholder' => 'Subject']) !!}
            </div>
            <div class="form__group">
                {!! Form::textarea('details',null,['rows' => '5','class' => 'form__input','placeholder' => 'details...']) !!}
            </div>
            <div class="form__group">
                {!! Form::label('type','Type:',['class' => 'form__label'])!!}
                {!! Form::select('type', $issueSelect, null, ['placeholder' => '(select type)','class' => 'form__input']) !!}
                {!! Form::label('priority','Priority:',['class' => 'form__label'])!!}
                {!! Form::select('priority', $prioSelect, null, ['placeholder' => '(select priority)','class' => 'form__input']) !!}
            </div>
            <div class="form__group">
                {!! Form::select('category', $incSelect, null, ['placeholder' => '(select category)','class' => 'form__input']) !!}

                {!! Form::select('categoryA', $incASelect, null, ['placeholder' => '(select sub-A)','class' => 'form__input']) !!}

                {!! Form::select('categoryB', ['inc' => 'Incident', 'req' => 'Request'], null, ['placeholder' => '(select sub-B)','class' => 'form__input']) !!}

            </div>
            <div class="form__group">
                {!! Form::select('assigned', ['inc' => 'Incident', 'req' => 'Request'], null, ['placeholder' => '(assign to)','class' => 'form__input']) !!}
            </div>
            {!! Form::button('submit',['class' => 'btn btn--blue','type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
