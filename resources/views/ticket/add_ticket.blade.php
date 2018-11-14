@extends('layouts.dashboardLayout')
@section('title','Add Ticket')
@section('submenu')@endsection
@section('dashboardContent')
    <div class="window">
        <div class="window__title-box">
            <h3 class="heading-tertiary">New Ticket</h3>
        </div>
        <div class="window__content">
            <div class="row">
                <div class="col-1-of-2">
                    {!! Form::open(['method' => 'POST','route' => 'addTicket','class' => 'form']) !!}
                    <div class="form__group">
                        {!! Form::select('caller_id', $callerSelect, null, ['placeholder' => '(caller)','class' => 'form__input form__input--select2','required']) !!}
                        {!! Form::select('number', $branchGroupSelect, null, ['placeholder' => '(number used)','class' => 'form__input form__input--select2','required']) !!}
                    </div>

                    <div class="form__group">
                        {!! Form::label('subject','Subject :',['class' => 'form__label form__label--block'])!!}
                        {!! Form::text('subject',old('subject'),['class' => 'form__input form__input--100w','placeholder' => 'Subject','required']) !!}
                    </div>
                    <div class="form__group">
                        {!! Form::textarea('details',null,['rows' => '5','class' => 'form__input u-width-full','placeholder' => 'details...','required']) !!}
                    </div>
                    <div class="form__group">
                        {!! Form::label('type','Type:',['class' => 'form__label'])!!}
                        {!! Form::select('type', $issueSelect, null, ['placeholder' => '(select type)','class' => 'form__input','required']) !!}
                        {!! Form::label('priority','Priority:',['class' => 'form__label'])!!}
                        {!! Form::select('priority', $prioSelect, null, ['placeholder' => '(select priority)','class' => 'form__input','required']) !!}
                    </div>
                    <div class="form__group">
                        {!! Form::select('category', $incSelect, null, ['placeholder' => '(select category)','class' => 'form__input','required']) !!}

                        {!! Form::select('categoryA', $incASelect, null, ['placeholder' => '(select sub-A)','class' => 'form__input','required']) !!}

                        {!! Form::select('categoryB', ['inc' => 'Incident', 'req' => 'Request'], null, ['placeholder' => '(select sub-B)','class' => 'form__input']) !!}

                    </div>
                    <div class="form__group">
                        {!! Form::select('assigned', array_merge($selfOption,$assigneeSelect), null, ['placeholder' => '(assign to)','class' => 'form__input']) !!}
                    </div>
                    {!! Form::button('submit',['class' => 'btn btn--blue','type' => 'submit']) !!}
                    {!! Form::close() !!}
                </div>
                <div class="col-1-of-2">
                    <div class="form-callerAdd">
                        <button class="form-callerAdd__button u-margin-l" type="button"><i class="fas fa-plus"></i> Add Caller</button>

                        <div class="form-callerAdd__content-box u-display-n">
                            {!! Form::open(['method' => 'POST','class' => 'form']) !!}
                            <div class="form__group">
                                {!! Form::label('caller','Name :',['class' => 'form__label'])!!}
                                {!! Form::text('caller',null,['class' => 'form__input','placeholder' => 'caller name']) !!}
                            </div>
                            <div class="form__group">
                                {!! Form::label('callerNum','Branch:',['class' => 'form__label']) !!}
                                {!! Form::select('caller', $branchSelect, null, ['placeholder' => '(Choose branch..)','class' => 'form__input form__input--select2']) !!}
                            </div>
                            <button class="btn" type="submit">Add</button>
                            {!! Form::close() !!}
                        </div>
                    </div>

                    <div class="form-branchAdd">
                        <button class="form-branchAdd__button u-margin-l " type="button"><i class="fas fa-plus"></i> Add Branch</button>

                        <div class="form-branchAdd__content-box u-display-n">
                            {!! Form::open(['method' => 'POST','class' => 'form']) !!}
                            <div class="form__group">
                                {!! Form::label('caller','Name :',['class' => 'form__label'])!!}
                                {!! Form::text('caller',null,['class' => 'form__input','placeholder' => 'branch name']) !!}
                            </div>
                            <button class="btn" type="submit">Add</button>
                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
