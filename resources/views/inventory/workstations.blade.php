@extends('layouts.dashboardLayout')
@section('title','Workstations')
<nav class="submenu">
    @section('submenu')
    <ul class="submenu__ul">
       
    </ul>
@show
</nav

@section('content')
     <main>
        <div class="row" >
            <div class="col-1-of-4">
                <aside class="side">
                    <div class="side__title">
                        <h3 class="heading-tertiary">Workstations</h3>
                    </div>
                    <div class="side__content">
                        <dl class="side__dl" >
                            <dt class="side__dt">Filter By :</span></dt>
                            {!! Form::open(['class'=>'formFilterWorkstations']) !!}
                            <div class="form-ticketFilter__group">
                                    {!! Form::label(2,'Store:',['class' => 'form-ticketFilter__label']) !!}
                                    {!! Form::select(2,$branchFilter,null,['placeholder' => '(select store...)','class' => 'form-ticketFilter__input', 'style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-ticketFilter__group">
                                    {!! Form::label(0,'Workstation:',['class' => 'form-ticketFilter__label']) !!}
                                    {!! Form::select(0,$workstationsFilter,null,['placeholder' => '(select workstation...)','class' => 'form-ticketFilter__input', 'style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-ticketFilter__group">
                                    {!! Form::label(3,'Department:',['class' => 'form-ticketFilter__label']) !!}
                                    {!! Form::select(3,$departmentFilter,null,['placeholder' => '(select workstation...)','class' => 'form-ticketFilter__input', 'style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-ticketFilter__group" style="float: right;margin: 5px;">
                                    {{Form::button('Clear Filters',['class' => 'btn btn--red','type' => 'button','id' => 'clearFilter'])}}
                                    {{Form::button('Filter',['class' => 'btn btn--blue','type' => 'submit','id' => 'filterTicketBtn'])}}
                            </div>
                        
                         {!! Form::close() !!}
                        
                            {{--  <dt class="side__dt">
                                {!! Form::select('workstation', $workstations, null, ['class'=>'form__input']) !!}
                            </dt>  --}}
                        </dl>
                    </div>
                </aside>
            </div>
            <div class="col-3-of-4">
                <button class="btn btn--red" id="add_ws" data-action="add-ws" style="margin-bottom: 10px;">Add new workstation</button>
                <table class="table no-footer" role="grid" id="inv-table">
                    <thead class="table__thead">
                        <th class="table__th">Workstation</th>
                        <th class="table__th">Parts/Composition</th>
                        <th class="table__th">Store</th>
                        <th class="table__th">Department</th>
                        <th class="table__th">Action</th>
                    </thead>
                    <tbody class="table__tbody">
                    </tbody>
                </table>
            </div>
        </div>
     </main>
@endsection