<div class="row">
    <div class="col-3-of-4">
        <div class="group">
            <div class="ticket-content">
                <div class="ticket-content__more-dropdown-container">
                    <div class="ticket-content__more-dropdown">
                        <span class="ticket-content__more">More...</span>
                        <ul class="ticket-content__list">
                            <li class="ticket-content__item"><a href="javascript:void(0);" class="ticket-content__link ticket-content__link--edit">Extend</a></li>
                            <li class="ticket-content__item"><a href="{{route('print.ticket',['id' => $ticket->id])}}" target="_blank" class="ticket-content__link ticket-content__link--print">Print</a></li>
                        </ul>
                    </div>
                </div>
                <div>
                    <h3 class="heading-tertiary ticket-content__subject">{{$ticket->issue->subject}}</h3>
                </div>
                <p class="ticket-content__details">
                    {!!$ticket->issue->details!!}
                </p>
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
            </div>
            <div class="ticket-details__content">
                <span class="ticket-details__id">Ticket ID: #{{$ticket->id}}</span>
                <ul class="ticket-details__list">
                    <li class="ticket-details__item"><span class="ticket-details__field">Status:</span>
                        <span class="ticket-details__value ticket-details__value--status">{{$ticket->statusRelation->name}}</span>
                    </li>
                    <li class="ticket-details__item"><span class="ticket-details__field">Caller:</span>
                        <a href="javascript:void(0);" class="ticket-details__value">{{$ticket->issue->incident->caller->full_name}} ({{$ticket->issue->incident->caller->positionData->position}})</a>
                    </li>
                    <li class="ticket-details__item"><span class="ticket-details__field">Logged date:</span>
                        <span class="ticket-details__value"> {{$ticket->created_at}}</span>
                    </li>
                    <li class="ticket-details__item"><span class="ticket-details__field">Expiration date:</span>
                        <span class="ticket-details__value">{{$ticket->getOriginal('expiration')}}</span>
                    </li>
                    <li class="ticket-details__item"><span class="ticket-details__field">Logged by:</span>
                        <a href="{{route('userProfile',['id' => $ticket->issue->incident->loggedBy->id])}}" class="ticket-details__value ticket-details__value--link">{{$ticket->userLogged->full_name}}</a> <span>({{$ticket->userLogged->role->role}})</span>
                    </li>
                    <li class="ticket-details__item"><span class="ticket-details__field">Priority:</span>
                        <span class="ticket-details__value ticket-details__value--{{strtolower($ticket->priorityRelation->name)}}">{{$ticket->priorityRelation->name}}</span>
                    </li>
                    <li class="ticket-details__item"><span class="ticket-details__field">Type:</span>
                        <span class="ticket-details__value">{{$ticket->typeRelation->name}}</span>
                    </li>
                    <li class="ticket-details__item"><span class="ticket-details__field">Store name:</span>
                        <a href="javascript:void(0);" data-store="{{$ticket->storeid}}" class="ticket-details__value ticket-details__value--link ticket-details__value--store">{{$ticket->storestore_name}}</a>
                    </li>
                    <li class="ticket-details__item"><span class="ticket-details__field">Assigned to:</span>
                        @if($ticket->assigneeRelation)
                            <a href="{{route('userProfile',['id' => $ticket->assigneeRelation->id])}}" class="ticket-details__value ticket-details__value--link">{{$ticket->assigneeRelation->full_name}}</a> <span>({{$ticket->assigneeRelation->role->role}})</span>
                        @else
                            None
                        @endif
                    </li>
                    <li class="ticket-details__item"><span class="ticket-details__field">Category:</span>
                        <span class="ticket-details__value">{{$ticket->issue->categoryRelation->name}}</span>
                    </li>
                    <li class="ticket-details__item"><span class="ticket-details__field">Sub-A Category:</span>
                        <span class="ticket-details__value">{{$ticket->issue->catARelation->name}} - {{$ticket->issue->catBRelation->name}}</span>
                    </li>
                    {{--<li class="ticket-details__item"><span class="ticket-details__field">Sub-B Category:</span>--}}
                    {{--<span class="ticket-details__value">&nbsp;</span>--}}
                    {{--</li>--}}

                    <li class="ticket-details__item"><span class="ticket-details__field">Data Correction:</span>

                        <span class="ticket-details__value">

                                                @if(isset($ticket->SDC->id))
                                <a target="_blank" class="ticket-details__value ticket-details__value--link" href="{{route('sdc.printer', ['id'=>$ticket->SDC->id])}}">{{ $ticket->SDC->sdc_no }}
                                    <?php
                                    $status = $ticket->SDC->status;
                                    if($status == 1){
                                        echo "(POSTED)";
                                    }else if($status == 2){
                                        echo "(ON GOING)";
                                    }else if($status == 3){
                                        echo "(FOR APPROVAL)";
                                    }else if($status == 4){
                                        echo "(APPROVED)";
                                    }else if($status == 5){
                                        echo "(DONE)";
                                    }else{
                                        echo "(SAVED)";
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
                        <span class="ticket-details__value">{{$ticket->issue->drd}}</span>
                    </li> --}}
                    <li class="ticket-details__item"><span class="ticket-details__field">Attachments:</span>
                        @if(!$ticket->issue->getFiles->isEmpty())
                            @foreach($ticket->issue->getFiles as $file)
                                <span class="ticket-details__value ticket-details__value--file"><a href="{{route('fileDownload',['id' => $file->id])}}" target="_blank">{{$file->original_name}}</a></span>
                            @endforeach
                        @else
                            <span class="ticket-details__value ticket-details__value--file">No Attachments</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>


    </div>
</div>
