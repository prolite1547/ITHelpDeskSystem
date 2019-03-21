{!! Form::open(['method' => 'POST','class'=>'form-fix']) !!}
    <div class="form__group">
        {!! Form::label('cause','Root Cause:',['class' => 'form__label--block']) !!}
        {!! Form::textarea('cause',null,['class' => 'form__input--textarea','required','id' => 'cause','minlength' => 5,'maxlength' => 500]) !!}
    </div>
    <div class="form__group">
        {!! Form::label('resolution','Resolution:',['class' => 'form__label--block']) !!}
            <div class="form__group">
                {!! Form::select('fix_category',$resolutionOptions,null,['placeholder' => 'Resolved through..','required','minlength' => 5,'maxlength' => 500]) !!}
            </div>
        {!! Form::textarea('resolution',null,['class' => 'form__input--textarea','required','id' => 'resolution','minlength' => 5,'maxlength' => 500]) !!}
    </div>
    <div class="form__group">
        {!! Form::label('recommendation','Recommendation:',['class' => 'form__label--block']) !!}
        {!! Form::textarea('recommendation',null,['class' => 'form__input--textarea','required','id' => 'recommendation','minlength' => 5,'maxlength' => 500]) !!}
    </div>
    <div class="u-float-r">
        {!! Form::button('Cancel',['type' => 'button','class' => 'btn btn--red','data-action' => 'cancel']) !!}
        {!! Form::button('Fix',['type' => 'submit','class' => 'btn btn--blue','data-action' => 'fix']) !!}
    </div>
{!! Form::close() !!}
