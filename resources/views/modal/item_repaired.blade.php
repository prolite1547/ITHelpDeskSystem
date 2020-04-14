
@can('addRepair', $ticket)
{!! Form::open(['method'=>'POST', 'id'=>'frmAddToList', 'route'=>'add.repaired']) !!}
<div class="row" style="margin-bottom: 10px !important;">
    <div class="col-1-of-2">
             {!! Form::hidden('ticket_id', $ticket_id ,null) !!}
            <div class="form__group">
                    {!! Form::label('serial_no','Serial No :',['class' => 'form__label'])!!}
                    {!! Form::text('serial_no', null ,['class' => 'form__input','placeholder' => ' ','minlength' => 2, 'style'=>'width:100%;', 'id'=>'serial_no', 'disabled']) !!}
            </div>
            <div class="form__group">
                    {!! Form::label('workstation_id','Workstation :',['class' => 'form__label'])!!}
                    {!! Form::select('workstation_id',$workstations, null, ['placeholder' => '(select workstation)','class' => 'form__input','id' => 'workstation_id','required', 'style'=>'width:100%;']) !!}
            </div>

            <div class="form__group">
                        {!! Form::label('item_id','Item Description :',['class' => 'form__label'])!!}
                        {!! Form::select('item_id', [], null, ['placeholder' => '(select item)','class' => 'form__input','id' => 'item_description','required', 'style'=>'width:100%;']) !!}
                </div>
    </div>

    <div class="col-1-of-2">
            <div class="form__group">
                    {!! Form::label('date_repaired','Date repaired :',['class' => 'form__label'])!!}
                    {!! Form::date('date_repaired', null, ['class' => 'form__input','placeholder' => ' ','required', 'style'=>'width:100%;']) !!}
                    
            </div>

            <div class="form__group">
                        {!! Form::label('reason','Reason for repair :',['class' => 'form__label'])!!}
                        {!! Form::textarea('reason', null, ['class' => 'form__input','required', 'style'=>'width:100%;','rows' => 2, 'cols' => 2]) !!}
            </div>

            <div class="form__group" style="margin-top:20px;">
                 <button type="submit" class="btn btn--blue" style="float:right;" data-action="addtorepairlist">Add to List</button>
            </div>
    </div>
</div>
@endcan

<table class="table" id="itemrepaired-table">
        <thead class="table__thead">
            <th class="table__th">Workstation</th>
            <th class="table__th">Serial No.</th>
            <th class="table__th">Item Description</th>
            <th class="table__th">Category</th>
            <th class="table__th">Date Repaired</th>
            <th class="table__th">Reason</th>
        </thead>
        <tbody class="table__tbody">
        </tbody>
</table>

