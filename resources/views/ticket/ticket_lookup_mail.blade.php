@extends('layouts.dashboardLayout')
@section('title','Ticket #'.$ticket->id)
@section('content')
    <main>
        <div class="row">
            <div class="col-3-of-4">
                <div class="group">
                    <div class="ticket-content">
                        <div class="ticket-content__more-dropdown-container">
                            <div class="ticket-content__more-dropdown">
                                <span class="ticket-content__more">More...</span>
                                <ul class="ticket-content__list">
                                    @if($ticket->status === $ticket_status_arr['Expired'] &&  in_array(Auth::user()->role_id,$higherUserGroup))
                                        <li class="ticket-content__item"><a href="javascript:void(0);" class="ticket-content__link ticket-content__link--extend">Extend</a></li>
                                    @endif
                                    @if((!in_array($ticket->status,[$ticket_status_arr['Fixed'],$ticket_status_arr['Closed'],$ticket_status_arr['Expired']]) && $ticket->assigneeRelation->id === Auth::id()) || $ticket->status === $ticket_status_arr['Open'])
                                        <li class="ticket-content__item"><a href="javascript:void(0);" class="ticket-content__link ticket-content__link--edit">Edit</a></li>
                                    @endif
                                    @if((in_array(Auth::user()->role_id,[$user_roles['tower'],$user_roles['admin']]) && in_array($ticket->status,[$ticket_status_arr['Fixed']])) && $ticket->status !== $ticket_status_arr['Open'])
                                        <li class="ticket-content__item"><a href="javascript:void(0);" class="ticket-content__link ticket-content__link--resolve">Resolve</a></li>
                                        <li class="ticket-content__item"><a href="javascript:void(0);" class="ticket-content__link ticket-content__link--reject">Reject</a></li>
                                    @endif
                                    @if(!in_array($ticket->status,[$ticket_status_arr['Fixed'],$ticket_status_arr['Closed'],$ticket_status_arr['Expired']]) && $ticket->assigneeRelation->id === Auth::id())
                                        <li class="ticket-content__item"><a href="javascript:void(0);" class="ticket-content__link ticket-content__link--fix">Mark as fixed..</a></li>
                                    @endif
                                    <li class="ticket-content__item"><a href="{{route('print.ticket',['id' => $ticket->id])}}" target="_blank" class="ticket-content__link ticket-content__link--print">Print</a></li>
                                    @if(in_array(Auth::user()->role_id,$higherUserGroup))
                                        <li class="ticket-content__item">
                                            <a href="javascript:void(0);" class="ticket-content__link" onclick="document.getElementById('ticket_delete').submit()">Delete</a>
                                            <form action="{{route('ticketDelete',['id' => $ticket->id])}}" method="POST" id="ticket_delete">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE" >
                                            </form>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div>
                            <h3 class="heading-tertiary ticket-content__subject">{{$ticket->issue->subject}}</h3>
                        </div>
                        <p class="ticket-content__details">
                            {!!$ticket->issue->details!!}
                        </p>
                        @if($ticket->status !== $ticket_status_arr['Expired'])
                            <form class="chat">
                                <textarea name="reply" rows="3" class="chat__textarea" placeholder="Enter message here..." maxlength="1000" minlength="5" required></textarea>
                                <div class="chat__send">
                                    <button class="chat__button" type="submit">Send</button>
                                </div>
                            </form>
                        @endif
                        <div class="ticket-content__updateBtns">
                            <div class="ticket-content__buttons u-float-r">
                                <button class="btn btn--red" data-action="cancel" id="contentEditCancel">Cancel</button>
                                <button class="btn btn--green" data-action="confirm" id="contentEditSave">Done</button>
                            </div>
                        </div>
                    </div>
                </div>
                @if( isset($ticket->issue->incident_id) && is_null($ticket->inciden->connection_id) )

                @elseif(isset($ticket->issue->connection_id) && is_null($ticket->inciden->call_id))
                    @include('includes.ticket_lookup.messages')
                @endif
            </div>
            <div class="col-1-of-4">
                <div class="ticket-details">
                    <div class="ticket-details__title-box">
                        <div class="ticket-details__title">
                            <h4 class="heading-quaternary">Details</h4>
                        </div>
                        @if((!in_array($ticket->status,[$ticket_status_arr['Fixed'],$ticket_status_arr['Closed'],$ticket_status_arr['Expired']]) && ($ticket->assigneeRelation->id === Auth::id()) || in_array(Auth::user()->role->id,$higherUserGroup)))
                            <div class="ticket-details__icon-box">
                                @if($ticket->assigneeRelation->id === Auth::id())
                                    <i class="fas fa-plus ticket-details__icon ticket-details__icon--add" title="Add Files"></i>
                                @endif
                                <i class="far fa-edit ticket-details__icon ticket-details__icon--edit" title="Edit Details"></i>
                            </div>
                        @endif
                    </div>
                    <div class="ticket-details__content">
                        <span class="ticket-details__id">Ticket ID: #{{$ticket->id}}</span>
                        <ul class="ticket-details__list">

                        </ul>
                        <button class="btn u-margin-top-xsmall {{$ticket->status !== $ticket_status_arr['Closed'] ? 'u-display-n' : ''}}" data-action="viewRslveDtls">Resolve Details</button>
                        <button class="btn u-margin-top-xsmall {{$ticket->status !== $ticket_status_arr['Rejected'] ? 'u-display-n' : ''}}" data-action="viewRjctDtls">Reject Details</button>
                    </div>

                    @if ((!$ticket->SDC && !$ticket->MDC) && $ticket->status !== $ticket_status_arr['Closed'])
                        <div class="ticket-details__title-box">
                            <div class="ticket-details__title">
                                <h4 class="heading-quaternary">Create/Add Data Correction</h4>
                            </div>
                        </div>
                        <div class="ticket-details__content">
                            <a class="btn btn--blue" href="{{ route('sdc.show', ['id'=>$ticket->id]) }}">System Data Correct</A>
                            <a class="btn btn--red" href= "{{ route('mdc.show', ['id'=>$ticket->id]) }}">Manual Data Correct</a>
                        </div>
                    @endif
                </div>


            </div>
        </div>
    </main>
@endsection


