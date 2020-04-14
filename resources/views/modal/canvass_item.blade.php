<main>
        <h1>Add new Item</h1>
        {!! Form::open(['method'=>'POST','route'=>'add.tocanvass' ,'id'=>'frmAdditem2Canvass']) !!}
        
        <div class="row">
                 <fieldset style="padding: 10px;">
                        <legend><b>Canvass details</b></legend>
                        {!! Form::hidden('ticket_id', $ticket_id, []) !!}
                        <div class="form__group">
                                {!! Form::label('c_storename','Store name :',['class' => 'form__label'])!!}
                                {!! Form::text('c_storename', null, ['class'=> 'form__input', 'style'=> 'width: 100%;', 'id'=> 'c_storename','required']) !!}
                        </div> 
                        <div class="div-withrow">
                                <div class="row">
                                        <div class="col-1-of-2">
                                                <div class="form__group">
                                                        {!! Form::label('c_serial_no','Serial No :',['class' => 'form__label', 'style'=>'width: 100%;'])!!}
                                                        {!! Form::text('c_serial_no', null, ['class' => 'form__input', 'style'=>'width: 100%;','id'=> 'c_itemdesc']) !!}
                                                </div>
                                        </div>
                                        <div class="col-1-of-2">
                                                <div class="form__group">
                                                        {!! Form::label('c_itemdesc','Item Description :',['class' => 'form__label', 'style'=>'width: 100%;'])!!}
                                                        {!! Form::text('c_itemdesc', null, ['class' => 'form__input', 'style'=>'width: 100%;','id'=> 'c_itemdesc', 'required']) !!}
                                                </div>
                                        </div>
                                </div>
                        </div>
                        <div class="div-withrow">
                               <div class="row">
                                        <div class="col-1-of-2">
                                                <div class="form__group">
                                                        {!! Form::label('c_qty','Qty :',['class' => 'form__label'])!!}
                                                        {!! Form::number('c_qty', null, ['class' => 'form__input', 'style'=>'width: 100%;', 'id'=>'c_qty' , 'required']) !!}     
                                                </div>
                                        </div>
                                        <div class="col-1-of-2">
                                                <div class="form__group">
                                                        {!! Form::label('c_price','Price :',['class' => 'form__label'])!!}
                                                        {!! Form::number('c_price', null, ['class' => 'form__input', 'style'=>'width: 100%;', 'id'=>'c_price' , 'required']) !!}     
                                                </div>
                                         </div>
                               </div>
                        </div>
                       
                        <div class="div-withrow" style="margin-bottom: 2px;">
                                <div class="row">
                                        <div class="col-1-of-2">
                                                        <div class="form__group">
                                                                {!! Form::label('purchase_date','Purchase date :',['class' => 'form__label'])!!}
                                                                {!! Form::date('purchase_date', null, ['class' => 'form__input', 'style'=>'width: 100%;', 'id'=>'purchase_date']) !!}     
                                                        </div>
                                        </div>
                                        <div class="col-1-of-2">
                                                        <div class="form__group">
                                                                {!! Form::label('date_installed','Date installed :',['class' => 'form__label'])!!}
                                                                {!! Form::date('date_installed', null, ['class' => 'form__input', 'style'=>'width: 100%;', 'id'=>'install_date']) !!}     
                                                        </div>
                                        </div>
                                </div>
                        </div>

                     

                        <div class="div-withrow">
                             <fieldset style="padding: 5px;">
                                    <legend><b>If Approved</b></legend>
                                        <div class="row">
                                                        <div class="col-1-of-2">
                                                               
                                                                        <div class="form__group">
                                                                                {!! Form::hidden('is_approved', 0, ['id'=>'is_approved']) !!}
                                                                                {!! Form::label('approval_id','Approval Type :',['class' => 'form__label'])!!}
                                                                                {!! Form::select('approval_id', $canvass_approval, null, ['class'=>'form__input','id'=>'approval_id', 'style'=>'width: 100%;','placeholder'=> '(select approval)']) !!}
                                                                        </div>
                                                                 
                                                        </div>
                                                        <div class="col-1-of-2">
                                                                

                                                                        <div class="form__group">
                                                                                
                                                                                {!! Form::label('appcode','Approval Code :',['class' => 'form__label'])!!}
                                                                                {!! Form::text('app_code', null, ['class'=>'form__input', 'id'=>'appcode', 'style'=>'width: 100%;']) !!}
                                                                                
                                                                        </div>
                                                                 
                                                        </div>
                                        </div>
                             </fieldset>
                        </div>
                 </fieldset>
             
                        <fieldset style="padding: 10px;">
                                <legend><b>Replacement for</b></legend>
                                    
                                    <div class="form__group">
                                            {!! Form::label('workstation_id','Workstation :',['class' => 'form__label'])!!}
                                            {!! Form::select('workstation_id', $workstations, null, ['placeholder'=>'(select workstation)','class'=>'form__input', 'id'=>'wks_id', 'style'=>'width: 100%;', 'required']) !!}
                                    </div>
                                    <div class="form__group">
                                            {!! Form::label('item_id','Item Description :',['class' => 'form__label'])!!}
                                            {!! Form::select('item_id', [], null, ['class'=>'form__input','id'=>'items', 'style'=>'width: 100%;', 'required']) !!}
                                    </div>
                                    <div class="form__group">
                                                {!! Form::label('serial_no','Serial No :',['class' => 'form__label', 'style'=>'width: 100%;'])!!}
                                                {!! Form::text('serial_no', null, ['class' => 'form__input','id'=>'serial_no', 'style'=>'width: 100%;', 'readonly', 'required']) !!}
                                     </div>
                             </fieldset>
                             <button class="btn btn--blue" style='margin-top: 5px;float:right;' type="submit" data-action="addtocanvass">Add to Canvass</button>
                </div>
                 
           
</main>