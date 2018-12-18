@extends('layouts.dashboardLayout')
@section('title','Add Ticket')
@section('submenu')@endsection
@section('content')
    <main>
        <div class="window">
            <div class="window__title-box">
                <h3 class="heading-tertiary">New Ticket</h3>
            </div>
            <div class="window__content">
                <div class="row">
                    <div class="col-1-of-2">
                        {!! Form::open(['method' => 'POST','route' => 'addTicket','class' => 'form-addTicket','enctype'=>'multipart/form-data']) !!}
                        <div class="form__group">
                            {!! Form::select('caller_id', [], null, ['placeholder' => '(caller)','class' => 'form__input form__input--select2','required','id' => 'caller_id']) !!}
                            {!! Form::select('contact_id', [], null, ['placeholder' => '(number used)','class' => 'form__input form__input--select2','required','id' => 'contact_id']) !!}
                        </div>

                        <div class="form__group">
                            {!! Form::label('subject','Subject :',['class' => 'form__label form__label--block'])!!}
                            {!! Form::text('subject',old('subject'),['class' => 'form__input form__input--100w','placeholder' => 'Subject','required']) !!}
                        </div>
                        <div class="form__group">
                            {!! Form::textarea('details',null,['rows' => '5','class' => 'form__input u-width-full','placeholder' => 'details...','required']) !!}
                        </div>
                        <div class="form__group">

                            {{ Form::file('attachments[]', array('multiple'))  }}
                        </div>

                        <div class="form__group">
                            {!! Form::label('type','Type:',['class' => 'form__label'])!!}
                            {!! Form::select('type', $issueSelect, null, ['placeholder' => '(select type)','class' => 'form__input','required']) !!}
                            {!! Form::label('priority','Priority:',['class' => 'form__label'])!!}
                            {!! Form::select('priority', $prioSelect, null, ['placeholder' => '(select priority)','class' => 'form__input','required']) !!}
                        </div>
                        <div class="form__group">
                            {!! Form::select('category', $typeSelect, null, ['placeholder' => '(select category)','class' => 'form__input','required']) !!}

                            {!! Form::select('catA', $incASelect, null, ['placeholder' => '(select sub-A)','class' => 'form__input','required']) !!}

                            {!! Form::select('catB', ['inc' => 'Incident', 'req' => 'Request'], null, ['placeholder' => '(select sub-B)','class' => 'form__input']) !!}
                            {!! Form::text('expiration', null, ['hidden','class' => 'form__input']) !!}

                        </div>
                        <div class="form__group">
                            {!! Form::label('drd','Drd :',['class' => 'form__label'])!!}
                            {!! Form::checkbox('drd',1,false,['class' => 'form__input form__input--checkbox']) !!}
                        </div>
                        <div class="form__group">
                            {!! Form::label('assignee','Assign to user:',['class' => 'form__label'])!!}
                            {!! Form::select('assignee', $selfOption + $assigneeSelect, null, ['placeholder' => '(assign to)','class' => 'form__input','required']) !!}
                        </div>
                        {!! Form::button('submit',['class' => 'btn btn--blue','type' => 'submit','id'=>'ticketAdd']) !!}
                        {!! Form::close() !!}
                    </div>
                    <div class="col-1-of-2">
                        <div class="form-callerAdd">
                            <button class="form-callerAdd__button u-margin-l" type="button"><i class="fas fa-plus"></i> Add Caller</button>

                            <div class="form-callerAdd__content-box u-display-n">
                                {!! Form::open(['method' => 'POST','class' => 'form','id' => 'addCaller']) !!}
                                <div class="form__group">
                                    {!! Form::label('name','Name :',['class' => 'form__label'])!!}
                                    {!! Form::text('name',null,['class' => 'form__input','placeholder' => 'caller name']) !!}
                                </div>
                                <div class="form__group">
                                    {!! Form::label('store_id','Branch:',['class' => 'form__label']) !!}
                                    {!! Form::select('store_id', [], null, ['placeholder' => '(Choose branch..)','class' => 'form__input form__input--select2','data-select' => 'store','id' => 'callerBranchSelect' ]) !!}
                                </div>
                                {!! Form::button('Add',['type'=>'submit','class'=>'btn','data-action' => 'addCaller']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="form-branchAdd">
                            <button class="form-branchAdd__button u-margin-l " type="button"><i class="fas fa-plus"></i> Add Branch</button>

                            <div class="form-branchAdd__content-box u-display-n">
                                {!! Form::open(['method' => 'POST','class' => 'form','id' => 'addBranch']) !!}
                                <div class="form__group">
                                    {!! Form::label('store_name','Name :',['class' => 'form__label'])!!}
                                    {!! Form::text('store_name',null,['class' => 'form__input','placeholder' => 'branch name']) !!}
                                </div>
                                {!! Form::button('Add',['type' => 'submit','class'=>'btn','data-action' => 'addBranch']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="form-contactAdd">
                            <button class="form-contactAdd__button u-margin-l " type="button"><i class="fas fa-plus"></i> Add Contact Number</button>

                            <div class="form-contactAdd__content-box u-display-n">
                                {!! Form::open(['method' => 'POST','class' => 'form','id' => 'addContact']) !!}
                                <div class="form__group">
                                    {!! Form::label('store_id','Branch:',['class' => 'form__label']) !!}
                                    {!! Form::select('store_id',[] ,null, ['placeholder' => '(Choose branch..)','class' => 'form__input form__input--select2','data-select' => 'contact','id' => 'contactBranchSelect']) !!}
                                </div>
                                <div class="form__group u-display-n" id="contactFormGroup">
                                    {!! Form::label('number','#',['class' => 'form__label']) !!}
                                    {!! Form::text('number',null, ['placeholder' => 'Enter number...','class' => 'form__input ']) !!}
                                    {!! Form::button('Add',['type' => 'submit','class'=>'btn','data-action' => 'addContact']) !!}
                                </div>

                                {!! Form::close() !!}
                            </div>
                        </div>

                    @if ($errors->any())
                            <div class="alert alert-danger"
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection
