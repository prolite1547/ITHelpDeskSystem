@extends('layouts.dashboardLayout')
@section('title','Report Issue')
@section('submenu')@endsection
@section('content')
    <main>
        <div class="window">
            <div class="window__title-box">
                <h3 class="heading-tertiary">Report an Issue</h3>
            </div>
            <div class="window__content u-width-50" style="display:block !important;">
                
            
                {!! Form::open(array('method'=>'POST', 'route'=>'addDeptReport', 'class'=>'addDeptReportForm','files' => true)) !!}
                    
                        <div class="form__group">
                            {!! Form::label('subject','Subject :',['class' => 'form__label form__label--block'])!!}
                            {!! Form::text('subject',old('subject'),['class' => 'form__input form__input--100w','placeholder' => 'Subject','required','minlength'=>'10']) !!}
                        </div>
                        <div class="form__group">
                            {!! Form::textarea('details',null,['rows' => '5','class' => 'form__input u-width-full','placeholder' => 'details...','required','minlength'=>'10']) !!}
                        </div>

                        <div class="form__group">
                            {!! Form::label('group','Group :',['class' => 'form__label form__label--block'])!!}
                            {!! Form::select('group', $groupSelect, null,  ['placeholder'=>'(select ticket group)','class'=> 'form__input--select2 u-width-full', 'required']) !!}
                        </div>

                        <div class="form__group">
                            {{!! Form::file('attachments[]', array('multiple'))  !!}}
                        </div>

                        <div class="form__group">
                            {!! Form::button('Submit Report',['class' => 'btn btn--blue','type' => 'submit']) !!}
                        </div>

                     

                 {!! Form::close() !!}
                 
            </div>
        </div>
 
      
    </main>
@endsection