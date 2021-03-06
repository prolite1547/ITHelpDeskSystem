<div class="form-container">
{{Form::open(['class'=>'form-addUser','id' => 'addUser'])}}
    <div class="form__group">
        {{Form::label('fName','First Name:',['class' => 'form__label'])}}
        {{Form::text('fName',null,['class'=> 'form__input-text','placeholder' => 'first name','required'])}}
    </div>
    <div class="form__group">
        {{Form::label('mName','Middle Name:',['class' => 'form__label'])}}
        {{Form::text('mName',null,['class'=> 'form__input-text','placeholder' => 'middle name','required'])}}
    </div>
    <div class="form__group">
        {{Form::label('lName','Last Name:',['class' => 'form__label'])}}
        {{Form::text('lName',null,['class'=> 'form__input-text','placeholder' => 'last name','required'])}}
    </div>
    <div class="form__group">
        {{Form::select('store_id',$branchSelect,null,['class'=>'form__input-select form__input--select2','placeholder' => '(choose store)','required'])}}
        {{Form::select('role_id',$rolesSelect,null,['class'=>'form__input-select form__input--select2','placeholder' => '(choose role)','required'])}}
        {{Form::select('position_id',$positionsSelect,null,['class'=>'form__input-select form__input--select2','placeholder' => '(choose position)','required'])}}
        {{Form::select('department_id',$departmentSelect,null,['class'=>'form__input-select form__input--select2','placeholder' => '(choose department)','required'])}}
    </div>
    <div class="form__group">
        {{Form::button('Cancel',['class' => 'btn btn--red','data-action' => 'closeModal'])}}
        {{Form::button('Add User',['class' => 'btn btn--blue','type' => 'submit'])}}
    </div>
{{Form::close()}}
</div>
