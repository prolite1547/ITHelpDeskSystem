<div class="form-container">
{{Form::open(['class'=>'form form-addUser'])}}
    <div class="form__group">
        {{Form::label('fName','First Name:',['class' => 'form__label','placeholder' => 'first name'])}}
        {{Form::text('fName',null,['class'=> 'form__input-text'])}}
        {{Form::label('mName','Middle Name:',['class' => 'form__label','placeholder' => 'middle name'])}}
        {{Form::text('mName',null,['class'=> 'form__input-text'])}}
        {{Form::label('lName','Last Name:',['class' => 'form__label','placeholder' => 'last name'])}}
        {{Form::text('lName',null,['class'=> 'form__input-text'])}}
    </div>
    <div class="form__group">
        {{Form::select('store_id',[],null,['class'=>'form__input-select','placeholder' => '(choose store)'])}}
        {{Form::select('role_id',[],null,['class'=>'form__input-select','placeholder' => '(choose role)'])}}
        {{Form::select('position_id',[],null,['class'=>'form__input-select','placeholder' => '(choose position)'])}}
    </div>
    <div class="form__group">
        {{Form::button('Cancel',['class' => 'btn btn--red'])}}
        {{Form::button('Add User',['class' => 'btn btn--blue'])}}
    </div>
{{Form::close()}}
</div>
