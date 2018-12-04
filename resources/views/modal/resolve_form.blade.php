{!! Form::open(['method' => 'POST','class'=>'form-resolve']) !!}
    <div class="form__group">
        {!! Form::label('cause','Root Cause:',['class' => 'form__label--block']) !!}
        {!! Form::textarea('cause',null,['class' => 'form__input--textarea','required','id' => 'cause']) !!}
    </div>
    <div class="form__group">
        {!! Form::label('resolution','Resolution:',['class' => 'form__label--block']) !!}
            <div class="form__group">
                {!! Form::select('res_category',$resolutionOptions,null,['placeholder' => 'Resolved through..']) !!}
            </div>
        {!! Form::textarea('resolution',null,['class' => 'form__input--textarea','required','id' => 'resolution']) !!}
    </div>
    <div class="form__group">
        {!! Form::label('recommendation','Recommendation:',['class' => 'form__label--block']) !!}
        {!! Form::textarea('recommendation',null,['class' => 'form__input--textarea','required','id' => 'recommendation']) !!}
    </div>
    <div class="u-float-r">
        {!! Form::button('Cancel',['type' => 'button','class' => 'btn btn--red','data-action' => 'cancel']) !!}
        {!! Form::button('Resolve',['type' => 'submit','class' => 'btn btn--blue','data-action' => 'resolved']) !!}
    </div>
{!! Form::close() !!}
