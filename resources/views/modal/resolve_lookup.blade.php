
<div class="form__group">
    {!! Form::label('cause','Root Cause:',['class' => 'form__label--block']) !!}
    {!! Form::textarea('cause',$resolve->cause,['class' => 'form__input--textarea','required','id' => 'cause','readonly']) !!}
</div>
<div class="form__group">
    {!! Form::label('resolution','Resolution:',['class' => 'form__label--block']) !!}
    <div class="form__group">
        {!! Form::text('res_category',$resolve->resolveCategory->name,['placeholder' => 'Resolved through..','readonly']) !!}
    </div>
    {!! Form::textarea('resolution',$resolve->resolution,['class' => 'form__input--textarea','required','id' => 'resolution','readonly']) !!}
</div>
<div class="form__group">
    {!! Form::label('recommendation','Recommendation:',['class' => 'form__label--block']) !!}
    {!! Form::textarea('recommendation',$resolve->recommendation,['class' => 'form__input--textarea','required','id' => 'recommendation','readonly']) !!}
</div>

