<main>
        <div class="row">
                {!! Form::open(['method'=>'POST', 'route'=>'add.ws', 'id'=>'addWks']) !!}
                <h2 style="margin-bottom: 10px;">Adding new workstation</h2>
                <div class="form__group">
                        {!! Form::label('ws_description','Workstation :',['class' => 'form__label'])!!}
                        {!! Form::text('ws_description', null ,['class' => 'form__input','placeholder' => ' ','required','minlength' => 2, 'style'=>'width:100%;']) !!}
                </div>
                <div class="form__group">
                        {!! Form::label('store_id','Store :',['class' => 'form__label'])!!}
                        {!! Form::select('store_id', $branchSelect, null, ['placeholder' => '(select store)','class' => 'form__input   ','required', 'style'=>'width:100%;']) !!}
                </div>
                <div class="form__group">
                        {!! Form::label('department_id','Department :',['class' => 'form__label'])!!}
                        {!! Form::select('department_id', $departmentSelect, null, ['placeholder' => '(select department)','class' => 'form__input', 'style'=>'width:100%;']) !!}
                </div>
                {!! Form::button('Submit',['type' => 'submit','class'=>'btn btn--blue','data-action' => 'add-new-ws']) !!}
        </div>
</main>