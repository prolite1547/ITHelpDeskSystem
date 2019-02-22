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
                                        <li class="ticket-content__item"><a href="#!" class="ticket-content__link ticket-content__link--extend">Extend</a></li>
                                    @endif
                                    @if((!in_array($ticket->status,[$ticket_status_arr['Fixed'],$ticket_status_arr['Closed'],$ticket_status_arr['Expired']]) && $ticket->assigneeRelation->id === Auth::id()) || $ticket->status === $ticket_status_arr['Open'])
                                        <li class="ticket-content__item"><a href="#!" class="ticket-content__link ticket-content__link--edit">Edit</a></li>
                                    @endif
                                    @if((in_array(Auth::user()->role_id,[$user_roles['tower'],$user_roles['admin']]) && in_array($ticket->status,[$ticket_status_arr['Fixed']])) && $ticket->status !== $ticket_status_arr['Open'])
                                        <li class="ticket-content__item"><a href="#!" class="ticket-content__link ticket-content__link--resolve">Resolve</a></li>
                                        <li class="ticket-content__item"><a href="#!" class="ticket-content__link ticket-content__link--reject">Reject</a></li>
                                    @endif
                                    @if(!in_array($ticket->status,[$ticket_status_arr['Fixed'],$ticket_status_arr['Closed'],$ticket_status_arr['Expired']]) && $ticket->assigneeRelation->id === Auth::id())
                                        <li class="ticket-content__item"><a href="#!" class="ticket-content__link ticket-content__link--fix">Mark as fixed..</a></li>
                                    @endif
                                    <li class="ticket-content__item"><a href="{{route('print.ticket',['id' => $ticket->id])}}" target="_blank" class="ticket-content__link ticket-content__link--print">Print</a></li>
                                    @if(in_array(Auth::user()->role_id,$higherUserGroup))
                                    <li class="ticket-content__item">
                                        <a href="#!" class="ticket-content__link" onclick="document.getElementById('ticket_delete').submit()">Delete</a>
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
                            <h3 class="heading-tertiary ticket-content__subject">{{$ticket->incident->subject}}</h3>
                        </div>
                        <p class="ticket-content__details">
                            {!!$ticket->incident->details!!}
                        </p>
                        <form class="chat">
                            <textarea name="reply" rows="3" class="chat__textarea" placeholder="Enter message here..." maxlength="1000" minlength="5" required></textarea>
                            <div class="chat__send">
                                <button class="chat__button" type="submit">Send</button>
                            </div>
                        </form>
                        <div class="ticket-content__updateBtns">
                            <div class="ticket-content__buttons u-float-r">
                                <button class="btn btn--red" data-action="cancel" id="contentEditCancel">Cancel</button>
                                <button class="btn btn--green" data-action="confirm" id="contentEditSave">Done</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <div class="thread">
                        @foreach($ticket->ticketMessages as $message)
                            <div class="message" data-id="{{$message->id}}">
                                <div class="message__img-box">
                                    <img src="{{asset("storage/profpic/".$message->user->profpic->image."")}}" alt="{{$message->user->full_name}}" class="message__img">
                                </div>
                                <div class="message__content">
                                    <div class="message__message-box">
                                        @if(Auth::id() === $message->user->id)
                                            <span class="message__close-icon">
                                        X
                                        </span>
                                        @endif
                                        <div class="message__name">{{$message->user->full_name}}</div>
                                        <div class="message__message">{!! $message->message !!}</div>
                                    </div>
                                    <span class="message__time">{{$message->created_at}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
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
                            <li class="ticket-details__item"><span class="ticket-details__field">Status:</span>
                                <span class="ticket-details__value ticket-details__value--status">{{$ticket->statusRelation->name}}</span>
                            </li>
                            <li class="ticket-details__item"><span class="ticket-details__field">Caller:</span>
                                <a href="#!" class="ticket-details__value">{{$ticket->incident->call->callerRelation->full_name}} ({{$ticket->incident->call->callerRelation->positionData->position}})</a>
                            </li>
                            <li class="ticket-details__item"><span class="ticket-details__field">Logged date:</span>
                                <span class="ticket-details__value"> {{$ticket->created_at}}</span>
                            </li>
                            <li class="ticket-details__item"><span class="ticket-details__field">Expiration date:</span>
                                <span class="ticket-details__value">{{$ticket->getOriginal('expiration')}}</span>
                            </li>
                            <li class="ticket-details__item"><span class="ticket-details__field">Logged by:</span>
                                <a href="{{route('userProfile',['id' => $ticket->incident->call->loggedBy->id])}}" class="ticket-details__value ticket-details__value--link">{{$ticket->userLogged->full_name}}</a> <span>({{$ticket->userLogged->role->role}})</span>
                            </li>
                            <li class="ticket-details__item"><span class="ticket-details__field">Priority:</span>
                                <span class="ticket-details__value ticket-details__value--{{strtolower($ticket->priorityRelation->name)}}">{{$ticket->priorityRelation->name}}</span>
                            </li>
                            <li class="ticket-details__item"><span class="ticket-details__field">Type:</span>
                                <span class="ticket-details__value">{{$ticket->typeRelation->name}}</span>
                            </li>
                            <li class="ticket-details__item"><span class="ticket-details__field">Store name:</span>
                                <a href="#!" data-store="{{$ticket->getStore->id}}" class="ticket-details__value ticket-details__value--link ticket-details__value--store">{{$ticket->getStore->store_name}}</a>
                            </li>
                            <li class="ticket-details__item"><span class="ticket-details__field">Assigned to:</span>
                                @if($ticket->assigneeRelation)
                                    <a href="{{route('userProfile',['id' => $ticket->assigneeRelation->id])}}" class="ticket-details__value ticket-details__value--link">{{$ticket->assigneeRelation->full_name}}</a> <span>({{$ticket->assigneeRelation->role->role}})</span>
                                @else
                                    None
                                @endif
                            </li>
                            <li class="ticket-details__item"><span class="ticket-details__field">Category:</span>
                                <span class="ticket-details__value">{{$ticket->incident->categoryRelation->name}}</span>
                            </li>
                            <li class="ticket-details__item"><span class="ticket-details__field">Sub-A Category:</span>
                                <span class="ticket-details__value">{{$ticket->incident->catARelation->name}} - {{$ticket->incident->catBRelation->name}}</span>
                            </li>
                            {{--<li class="ticket-details__item"><span class="ticket-details__field">Sub-B Category:</span>--}}
                            {{--<span class="ticket-details__value">&nbsp;</span>--}}
                            {{--</li>--}}

                            <li class="ticket-details__item"><span class="ticket-details__field">Data Correction:</span>

                                <span class="ticket-details__value">

                                            @if(isset($ticket->SDC->id))
                                                 <a target="_blank" class="ticket-details__value ticket-details__value--link" href="{{route('sdc.printer', ['id'=>$ticket->SDC->id])}}">{{ $ticket->SDC->sdc_no }}
                                            <?php
                                            $f_status = $ticket->SDC->forward_status;
                                            $sdc_status = $ticket->SDC->status;

                                            if($f_status == 1 &&  $sdc_status == 1){
                                                echo "(TREASURY I)";
                                            }else if($f_status == 2 &&  $sdc_status == 1){
                                                echo "(TREASURY II)";
                                            }else if($f_status == 3 &&  $sdc_status == 1){
                                                echo "(GOV. COMP)";
                                            }else if($f_status == 4 &&  $sdc_status == 1){
                                                echo "(APPROVER)";
                                            }else if($f_status == 5 &&  $sdc_status == 3){
                                                echo "(DEPLOYMENT)";
                                            }else{
                                               if($sdc_status == 0){
                                                    echo "(DRAFT)";
                                               }elseif($sdc_status == 2){
                                                    echo "(REJECTED)";
                                               }else{
                                                    echo "(DONE)";
                                               }
                                            }
                                            ?>
                                                </a>
                                    @elseif (isset($ticket->MDC->id))
                                        <a target="_blank" class="ticket-details__value ticket-details__value--link" href="{{route('mdc.printer', ['id'=>$ticket->MDC->id])}}">{{ $ticket->MDC->mdc_no }}
                                            @if($ticket->MDC->posted)(POSTED)@endif
                                                </a>
                                    @endif
                                        </span>
                            </li>

                            {{-- <li class="ticket-details__item"><span class="ticket-details__field">Data Correction:</span>
                                <span class="ticket-details__value">{{$ticket->incident->drd}}</span>
                            </li> --}}
                            <li class="ticket-details__item"><span class="ticket-details__field">Attachments:</span>
                                @if(!$ticket->incident->getFiles->isEmpty())
                                    @foreach($ticket->incident->getFiles as $file)
                                        <span class="ticket-details__value ticket-details__value--file"><a href="{{route('fileDownload',['id' => $file->id])}}" target="_blank">{{$file->original_name}}</a></span>
                                    @endforeach
                                @else
                                    <span class="ticket-details__value ticket-details__value--file">No Attachments</span>
                                @endif
                            </li>
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


