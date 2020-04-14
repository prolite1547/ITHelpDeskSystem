  
{{-- <button class="btn" style="float:right;" data-tid="{{ $tid }}" data-action="refreshTable">Refresh table</button> --}}
@if (!isset($canvass_form->posted) && $posted != 1)
    <button class="btn btn--red" style="float:right;" data-tid="{{ $tid }}" data-action="addNewcItem">Add new item</button>
@endif
<table class="table" id="canvass-table" data-posted="{{ $posted }}">
    <thead class="table__thead">
        <th class="table__th">Store name</th>
        <th class="table__th">Item Description</th>
        <th class="table__th">Qty</th>
        <th class="table__th">Price</th>
        <th class="table__th">Approved</th>
        <th class="table__th">Approval type</th>
        <th class="table__th">Code</th>
        <th class="table__th">Purchase Date</th>
        <th class="table__th">Date Installed</th>
        <th class="table__th">Actions</th>
    </thead>
    <tbody class="table__tbody">
    </tbody>
</table>


{!! Form::open(['method'=> 'POST', 'route'=>'post.canvass', 'files'=>true, 'id'=> 'frmPostCanvass']) !!}

{!! Form::hidden('ticket_id', $tid , []) !!}
{!! Form::hidden('posted', true, []) !!}


<div class="div-row">
    <div class="row">
        <div class="col-1-of-2">
            <div class="form__group">
                    {!! Form::label('remarks','Remarks :',['class' => 'form__label'])!!}
                    @if (isset($canvass_form->posted))
                         {!! Form::textarea('remarks', $canvass_form->remarks, ['class' => 'form__input', 'style'=>'width:100%;','rows' => 2, 'cols' => 2, 'disabled']) !!}
                    @else 
                         {!! Form::textarea('remarks',null, ['class' => 'form__input', 'style'=>'width:100%;','rows' => 2, 'cols' => 2, '']) !!}
                    @endif
                    
            </div>
        </div>  
        
        <div class="col-1-of-2">
            <div class="form__group">
                    {!! Form::label('purpose','Purpose :',['class' => 'form__label'])!!}
                    @if (isset($canvass_form->posted))
                          {!! Form::textarea('purpose', $canvass_form->purpose, ['class' => 'form__input', 'style'=>'width:100%;','rows' => 2, 'cols' => 2, 'disabled']) !!}
                    @else
                         {!! Form::textarea('purpose', null, ['class' => 'form__input', 'style'=>'width:100%;','rows' => 2, 'cols' => 2, '']) !!}
                    @endif
            </div>
        </div>
    </div>
</div>

<div class="div-row">
    <div class="row">
        @if (!isset($canvass_form->posted))
            @if ($posted != 1)
            <div class="col-1-of-2">
                <div class="form__group">
                    {!! Form::label('upfile','Attach File :',['class' => 'form__label'])!!}
                    {!! Form::file('upfile[]', ['id'=>'upfile','class'=>'form__input', 'style'=>'width: 100%;', 'multiple'=>true]) !!}
                </div>
            </div>
            @endif
        @else
            <div class="col-1-of-2">
                <div class="form__group">
                    
                    {!! Form::label('attachments','Attachments :',['class' => 'form__label'])!!}
                    <ul id="attachments attachments" style="text-decoration: none;">

                        @foreach ($canvass_form->canvass_attachments as $item)
                                  <li><a href="{{ route('download.catt', ['id'=> $item->id]) }}"><span style="background: #b2bec3;color:black;">{{ $item->original_name }}</span></a></li>
                        @endforeach
                        
                        @if (count($canvass_form->canvass_attachments) <= 0)
                        <li><span style="color:black;">No attachments</span> </li>
                        @endif
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>

 
@if (!isset($canvass_form->posted) && $posted != 1)
    <div class="form__group" style="float:right;">
        <button class="btn btn--blue" type="submit" id="postCanvass" data-action="postCanvass">Post Canvass</button>
    </div>
@endif