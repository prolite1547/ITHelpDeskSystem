<main>
        <h1>Item Update</h1>
        {!! Form::open(['method'=>'POST','route'=>'update.itemcanvass' ,'id'=>'frmUpdateitem2Canvass']) !!}
        
        <div class="row">
                 <fieldset style="padding: 10px;">
                        <legend><b>Canvass details</b></legend>
                        {!! Form::hidden('id', $canvass->id, []) !!}
                        <div class="form__group">
                                {!! Form::label('c_storename','Store name :',['class' => 'form__label'])!!}
                                {!! Form::text('c_storename', $canvass->c_storename, ['class'=> 'form__input', 'style'=> 'width: 100%;', 'id'=> 'c_storename','required']) !!}
                        </div> 
                        <div class="div-withrow">
                                <div class="row">
                                        <div class="col-1-of-2">
                                                <div class="form__group">
                                                        {!! Form::label('c_serial_no','Serial No :',['class' => 'form__label', 'style'=>'width: 100%;'])!!}
                                                        {!! Form::text('c_serial_no', $canvass->c_serial_no, ['class' => 'form__input', 'style'=>'width: 100%;','id'=> 'c_serial_no']) !!}
                                                </div>
                                        </div>
                                        <div class="col-1-of-2">
                                                <div class="form__group">
                                                        {!! Form::label('c_itemdesc','Item Description :',['class' => 'form__label', 'style'=>'width: 100%;'])!!}
                                                        {!! Form::text('c_itemdesc', $canvass->c_itemdesc, ['class' => 'form__input', 'style'=>'width: 100%;','id'=> 'c_itemdesc', 'required']) !!}
                                                </div>
                                        </div>
                                </div>
                        </div>
                        
                        <div class="div-withrow">
                               <div class="row">
                                        <div class="col-1-of-2">
                                                <div class="form__group">
                                                        {!! Form::label('c_qty','Qty :',['class' => 'form__label'])!!}
                                                        {!! Form::number('c_qty', $canvass->c_qty, ['class' => 'form__input', 'style'=>'width: 100%;', 'id'=>'c_qty', 'required']) !!}     
                                                </div>
                                        </div>
                                        <div class="col-1-of-2">
                                                <div class="form__group">
                                                        {!! Form::label('c_price','Price :',['class' => 'form__label'])!!}
                                                        {!! Form::number('c_price', $canvass->c_price, ['class' => 'form__input', 'style'=>'width: 100%;', 'id'=>'c_price', 'required']) !!}     
                                                </div>
                                         </div>
                               </div>
                        </div>
                       
                        <div class="div-withrow" style="margin-bottom: 2px;">
                                <div class="row">
                                        <div class="col-1-of-2">
                                                        <div class="form__group">
                                                                {!! Form::label('purchase_date','Purchase date :',['class' => 'form__label'])!!}
                                                                {!! Form::date('purchase_date', $canvass->purchase_date, ['class' => 'form__input', 'style'=>'width: 100%;', 'id'=>'purchase_date']) !!}     
                                                        </div>
                                        </div>
                                        <div class="col-1-of-2">
                                                        <div class="form__group">
                                                                {!! Form::label('date_installed','Date installed :',['class' => 'form__label'])!!}
                                                                {!! Form::date('date_installed', $canvass->date_installed, ['class' => 'form__input', 'style'=>'width: 100%;', 'id'=>'install_date']) !!}     
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
                                                                                {!! Form::hidden('is_approved', $canvass->is_approved, ['id'=>'is_approved']) !!}
                                                                                {!! Form::label('approval_id','Approval Type :',['class' => 'form__label'])!!}
                                                                                {!! Form::select('approval_id', $canvass_approval, $canvass->approval_id, ['class'=>'form__input','id'=>'approval_id', 'style'=>'width: 100%;','placeholder'=> '(select approval)']) !!}
                                                                        </div>
                                                                 
                                                        </div>
                                                        <div class="col-1-of-2">
                                                                

                                                                        <div class="form__group">
                                                                                
                                                                                {!! Form::label('appcode','Approval Code :',['class' => 'form__label'])!!}
                                                                                {!! Form::text('app_code', $canvass->app_code, ['class'=>'form__input', 'id'=>'appcode', 'style'=>'width: 100%;']) !!}
                                                                                
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
                                            {!! Form::select('workstation_id', $workstations, $canvass->item->workstation_id, ['placeholder'=>'(select workstation)','class'=>'form__input', 'id'=>'wks_id', 'style'=>'width: 100%;', 'required']) !!}
                                    </div>
                                    <div class="form__group">
                                            {!! Form::label('item_id','Item Description :',['class' => 'form__label'])!!}
                                            {!! Form::select('item_id', $items, $canvass->item->id, ['class'=>'form__input','id'=>'items', 'style'=>'width: 100%;', 'required']) !!}
                                    </div>
                                    <div class="form__group">
                                                {!! Form::label('serial_no','Serial No :',['class' => 'form__label', 'style'=>'width: 100%;'])!!}
                                                {!! Form::text('serial_no', $canvass->item->serial_no, ['class' => 'form__input','id'=>'serial_no', 'style'=>'width: 100%;', 'readonly']) !!}
                                     </div>
                             </fieldset>
                             <button class="btn btn--blue" style='margin-top: 5px;float:right;' type="submit" data-action="updateitemcanvass">Save Changes</button>
                </div>
                 
           
</main>