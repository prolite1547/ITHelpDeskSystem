<div class="resolve-details">
<div class="form__group">
    {!! Form::label('cause','Root Cause:',['class' => 'form__label--block']) !!}
    {!! Form::textarea('cause',$fix->cause,['class' => 'form__input--textarea','required','id' => 'cause','readonly']) !!}
</div>
<div class="form__group">
    {!! Form::label('resolution','Resolution:',['class' => 'form__label--block']) !!}
    <div class="form__group">
        {!! Form::text('res_category',$fix->resolveCategory->name,['placeholder' => 'Resolved through..','readonly']) !!}
    </div>
    {!! Form::textarea('resolution',$fix->resolution,['class' => 'form__input--textarea','required','id' => 'resolution','readonly']) !!}
</div>
<div class="form__group">
    {!! Form::label('recommendation','Recommendation:',['class' => 'form__label--block']) !!}
    {!! Form::textarea('recommendation',$fix->recommendation,['class' => 'form__input--textarea','required','id' => 'recommendation','readonly']) !!}
</div>
    <div class="resolve__group">
        {{Form::label('fixed_by','Fixed By:',['form__label'])}}
        {{Form::text('fixed_by',$fix->fixedBy->full_name .' - ' .$fix->fixedBy->role->role,['class' => 'form__input form__input--readonly','readonly'])}}
        {{Form::label('created_at','Fix Date:',['form__label'])}}
        {{Form::text('created_at',$fix->created_at,['class' => 'form__input form__input--readonly','readonly'])}}
    </div>
    @can('resolveReject',$ticket)
    <div class="form__group">
        <button type="button" class="btn btn--red" data-action="showRejectForm">Reject</button>
        <button type="button" class="btn btn--blue" data-action="resolveTicket">Resolve</button>
    </div>
    @endcan
</div>
