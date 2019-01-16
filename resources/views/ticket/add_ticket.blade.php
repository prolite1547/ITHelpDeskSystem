@extends('layouts.dashboardLayout')
@section('title','Add Ticket')
@section('submenu')@endsection
@section('content')
    <main>
        <div class="window">
                <div class="window__title-box">
                    <h3 class="heading-tertiary">New Ticket</h3>
                </div>
                <div class="window__menu">
                    <label id="incidentForm" class="window__item">
                        Incident
                    </label>
                    <label id="PLDTForm" class="window__item">
                        PLDT
                    </label>
                    {{--<li class="window__item window__item--active"><a href="#!" class="window__link">Incident</a></li>--}}
                    {{--<li class="window__item"><a href="#!" class="window__link">PLDT</a></li>--}}
                </div>
            <div class="window__content" id="incidentFormContainer">
                <div class="row">
                    <div class="col-1-of-2">
                        <div class="formColumn">
                            {!! Form::open(['method' => 'POST','route' => 'addTicket','id' => 'form-addTicket']) !!}
                            <div class="form__group">
                                {!! Form::select('store', [], null, ['placeholder' => '(reported by)','class' => 'form__input','required','id' => 'ticketBranchSelect']) !!}
                            </div>
                            <div class="form__group">
                                <fieldset class="fieldset">
                                    <legend class="fieldset__legend">Caller Details</legend>
                                    <div class="fieldset__flex">
                                        <div class="fieldset__left">
                                            {!! Form::select('position', [], null, ['placeholder' => '(position)','class' => 'form__input','required','id' => 'ticketPositionSelect']) !!}
                                        </div>
                                        <div class="fieldset__right">
                                            <div class="form__group">
                                                {!! Form::label('fName','First Name :',['class' => 'form__label'])!!}
                                                {!! Form::text('fName',null,['class' => 'form__input','placeholder' => 'first','required']) !!}
                                            </div>
                                            <div class="form__group">
                                                {!! Form::label('mName','Middle Name :',['class' => 'form__label'])!!}
                                                {!! Form::text('mName',null,['class' => 'form__input','placeholder' => 'middle','required']) !!}
                                            </div>
                                            <div class="form__group">
                                                {!! Form::label('lName','Last Name :',['class' => 'form__label'])!!}
                                                {!! Form::text('lName',null,['class' => 'form__input','placeholder' => 'last','required']) !!}
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>
                            </div>
                            {!! Form::button('Add Ticket',['class' => 'btn btn--blue','type' => 'submit','id'=>'ticketAdd']) !!}
                            {!! Form::close() !!}

                            {!! Form::open(['method'=>'PATCH','route' => 'addTicketDetails','class'=>'form-addTicketDetails u-display-n','enctype'=>'multipart/form-data']) !!}
                                {{Form::hidden('_method','PATCH')}}
                            <label class="form-addTicketDetails__ticket">Ticket #: <input name="ticket_id" type="text" value="1234" readonly class="form-addTicketDetails__ticket-value"></label>
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
                                {{--{!! Form::label('type','Type:',['class' => 'form__label'])!!}--}}
                                {{--{!! Form::select('type', $issueSelect, null, ['placeholder' => '(select type)','class' => 'form__input','required']) !!}--}}
                                {!! Form::text('type',1,['class' => 'form__input','hidden','required']) !!}
                                {!! Form::label('priority','Priority:',['class' => 'form__label'])!!}
                                {!! Form::select('priority', $prioSelect, null, ['placeholder' => '(select priority)','class' => 'form__input','required']) !!}
                            </div>
                            <div class="form__group">
                                {!! Form::select('category', $typeSelect, null, ['placeholder' => '(select category)','class' => 'form__input','required']) !!}
                                {!! Form::select('catB', $categoryBGroupSelect, null, ['placeholder' => '(select sub-B)','class' => 'form__input','required']) !!}
                                {!! Form::text('expiration', null, ['hidden','class' => 'form__input']) !!}

                            </div>
                            <div class="form__group">
                                {!! Form::label('assignee','Assign to user:',['class' => 'form__label'])!!}
                                {!! Form::select('assignee', $selfOption + $assigneeSelect, null, ['placeholder' => '(assign to)','class' => 'form__input form__input--select2','required','id' => 'assigneeSelect']) !!}
                            </div>
                            {!! Form::button('Bind Details',['class' => 'btn btn--blue','type' => 'submit','id'=>'ticketAdd']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="col-1-of-2 maintenance-column">
                        <div class="form-branchAdd">
                            <button class="form-branchAdd__button u-margin-l " type="button"><i class="fas fa-plus"></i>
                                Add Branch
                            </button>

                            <div class="form-branchAdd__content-box u-display-n">
                                {!! Form::open(['method' => 'POST','class' => 'form','id' => 'addBranch']) !!}
                                <div class="form__group">
                                    {!! Form::label('store_name','Name :',['class' => 'form__label'])!!}
                                    {!! Form::text('store_name',null,['class' => 'form__input','placeholder' => 'branch name','required']) !!}
                                </div>
                                {!! Form::button('Add',['type' => 'submit','class'=>'btn','data-action' => 'addBranch']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="form-positionAdd">
                            <button class="form-positionAdd__button u-margin-l " type="button"><i class="fas fa-plus"></i>
                                Add Position
                            </button>

                            <div class="form-positionAdd__content-box u-display-n">
                                {!! Form::open(['method' => 'POST','class' => 'form','id' => 'addBranch']) !!}
                                <div class="form__group">
                                    {!! Form::label('name','Position:',['class' => 'form__label'])!!}
                                    {!! Form::text('name',null,['class' => 'form__input','placeholder' => 'position','required']) !!}
                                </div>
                                {!! Form::button('Add',['type' => 'submit','class'=>'btn','data-action' => 'addBranch']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
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

            {{--PLDT FORM--}}
            <div class="window__content" id="PLDTFormContainer">
                {{Form::open(array('class' => 'form-email','id' => 'addPLDTIssue'))}}
                    {{Form::text('to',null,array('placeholder' => 'To','class'=> 'form-email__input form-email__input--text','required'))}}
                    {{Form::text('subject',null,array('placeholder' => 'Subject','class'=> 'form-email__input form-email__input--text','required'))}}
                    {{Form::textarea('details',null,array('class' => 'form-email__input form-email__input--textarea','required'))}}
                    {{Form::button('Send',array('type' => 'submit','class' => 'btn btn--blue','data-action' => 'addPLDTIssue'))}}
                {{Form::close()}}
            </div>
        </div>
    </main>
@endsection
