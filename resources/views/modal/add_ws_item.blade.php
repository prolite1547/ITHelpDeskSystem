<main>
        <h2 style="margin-bottom: 10px;">{{ $workstation->ws_description }} | Adding new item</h2>
        {!! Form::open(['method'=> 'POST','route'=>'add.itemws','id'=>'frmAddItemWs']) !!}
        {!! Form::hidden('workstation_id', $wid, null) !!}
        <div class="form__group"  >
            {!! Form::label('serial_no','Serial No :',['class' => 'form__label'])!!}
            {!! Form::text('serial_no', null ,['class' => 'form__input','placeholder' => ' ','minlength' => 2, 'style'=>'width:100%;']) !!}
        </div>
        <div class="form__group">
            {!! Form::label('item_description','Item Description :',['class' => 'form__label'])!!}
            {!! Form::textarea('item_description', null ,['class' => 'form__input','placeholder' => ' ','required','minlength' => 2, 'style'=>'width:100%;']) !!}
        </div>
        <div class="form__group">
            {!! Form::label('itemcateg_id','Category :',['class' => 'form__label'])!!}
            {!! Form::select('itemcateg_id', $itemCategSelect, null, ['placeholder' => '(select category)','class' => 'form__input','required', 'style'=>'width:100%;']) !!}
        </div>

        <div class="form__group">
            
            {!! Form::label('date_used', 'Date Used :', ['class' => 'form__label']) !!}
            {!! Form::date('date_used', null, ['class' => 'form__input','placeholder' => ' ','required', 'style'=>'width:100%;']) !!}
        </div>
        {!! Form::button('Submit',['type' => 'submit','class'=>'btn btn--blue','data-action' => 'add-new-item', 'id' => 'addWsItem']) !!}
        
        {!! Form::close() !!}
 </main>