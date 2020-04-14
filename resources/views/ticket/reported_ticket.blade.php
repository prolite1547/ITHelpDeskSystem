@extends('layouts.dashboardLayout')
@section('title','Report Issue')
@section('submenu')@endsection
@section('content')
    <main>
        <div class="window">
            <div class="window__title-box">
                <h3 class="heading-tertiary">Add Ticket Reported</h3>
            </div>
            <div class="window__content u-width-50" style="display:block !important;">
                {!! Form::open(array('route'=>'addTicketFromReport', 'method'=> 'PATCH', 'id'=>"addReportedTicket")) !!}
                
                <div class="form__group">
                   <span class="header-title">TICKET # {{ $ticket->id }} - {{ strtoupper($ticket->store->store_name) }}</span>
                   <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                </div>

                <div class="form__group">
                    <span> {{ strtoupper($ticket->issue->incident->caller->full_name) }}</span><br>
                    <span> {{  $ticket->issue->incident->caller->position->position }}</span>
                </div>

                <div class="form__group">
                    {!! Form::label('subject','Subject :',['class' => 'form__label form__label--block'])!!}
                    {!! Form::text('subject',$ticket->issue->subject,['class' => 'form__input form__input--100w','placeholder' => 'Subject','readonly','minlength' => '10']) !!}
                </div>
                <div class="form__group">
                    {!! Form::textarea('details',$ticket->issue->details,['rows' => '5','class' => 'form__input u-width-full','placeholder' => 'details...','readonly','minlength' => '10']) !!}
                </div>
                <div class="form__group">
                    @if ($ticket->issue->getFiles)
                        <label for="">Attachments:</label> &nbsp;
                    @endif
                    @foreach($ticket->issue->getFiles as $file)
                    <span class="file-links"><a
                            href="{{route('fileDownload',['id' => $file->id])}}"
                            target="_blank">{{$file->original_name}}</a></span>
                     @endforeach
                </div>

                
              
                <div class="form__group">
                    {!! Form::text('type',1,['class' => 'form__input','hidden','required']) !!}
                    {!! Form::label('priority','Priority:',['class' => 'form__label'])!!}
                    {!! Form::select('priority', $prioSelect, null, ['placeholder' => '(select priority)','class' => 'form__input','required']) !!}
                    {{--  {!! Form::select('group', $groupSelect, null, ['placeholder' => '(select group)','class' => 'form__input','required']) !!}  --}}
                </div>
                <div class="form__group form-addTicketDetails__category-inputs">
                    {!! Form::select('category', $typeSelect, null, ['placeholder' => '(select category)','class' => 'form__input','required']) !!}
                    {!! Form::select('catA', $categoryASelect, null, ['placeholder' => '(select sub-A)','class' => 'form__input categoryASelect form__input--select2','required']) !!}
                    {!! Form::select('catB',[], null, ['placeholder' => '(select sub-B)','class' => 'form__input categoryBSelect form__input--select2','required']) !!}
                    {!! Form::select('catC', $CategoryCSelect, null, ['placeholder' => '(select sub-C)','class' => 'form__input categoryCSelect form__input--select2']) !!}
                </div>
                <div class="form__group">
                    <input type="hidden" name="group" value = null id="group" required>
                </div>
                
                <div class="form__group">
                    {!! Form::label('assignee','Assign to user:',['class' => 'form__label'])!!}
                    {!! Form::select('assignee', $selfOption + $assigneeSelect, null, ['placeholder' => '(assign to)','class' => 'form__input form__input--select2 assigneeSelect ','required','id' => 'assigneeSelect']) !!}
                </div>

                <div class="form__group">
                    {!! Form::button('Add Ticket',['class' => 'btn btn--blue','type' => 'submit','id'=>'addReportedTicket']) !!}
                </div>

                {!! Form::close() !!}
                
            </div>
        </div>
        
      
    </main>
@endsection