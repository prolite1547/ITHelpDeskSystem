<div class="ticket-details__title-box">
    <div class="ticket-details__title">
        <h4 class="heading-quaternary">Details</h4>
    </div>
    @can('update',$ticket)
        <div class="ticket-details__icon-box">
            @if($ticket->assigneeRelation->id === Auth::id())
                <i class="fas fa-plus ticket-details__icon ticket-details__icon--add" title="Add Files"></i>
            @endif
            <i class="far fa-edit ticket-details__icon ticket-details__icon--edit" title="Edit Details"></i>
        </div>
    @endcan
</div>
<div class="ticket-details__content">
    <span class="ticket-details__id">Ticket ID: #{{$ticket->id}}</span>
    <ul class="ticket-details__list">
        @if($ticket->extended->count() > 0)
            <li class="ticket-details__item"><span class="ticket-details__field">Times Extended:</span>
                <a href=""
                   class="ticket-details__value ticket-details__value--link ticket-details__value--extend">{{$ticket->extended->count()}}
                    - Click for details!</a>
            </li>
        @endif
        <li class="ticket-details__item"><span class="ticket-details__field">Status:</span>
            <span class="ticket-details__value ticket-details__value--status">{{$ticket->statusRelation->name}}</span>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Caller:</span>
            <a href="javascript:void(0);"
               class="ticket-details__value">{{$ticket->incident->call->callerRelation->full_name}}
                ({{$ticket->incident->call->callerRelation->position->position}})</a>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Logged date:</span>
            <span class="ticket-details__value"> {{$ticket->created_at}}</span>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Expiration date:</span>
            <span class="ticket-details__value">{{$ticket->getOriginal('expiration')}}</span>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Logged by:</span>
            <a href="{{route('userProfile',['id' => $ticket->incident->call->loggedBy->id])}}"
               class="ticket-details__value ticket-details__value--link">{{$ticket->userLogged->full_name}}</a> <span>({{$ticket->userLogged->role->role}})</span>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Priority:</span>
            <span
                class="ticket-details__value ticket-details__value--{{strtolower($ticket->priorityRelation->name)}}">{{$ticket->priorityRelation->name}}</span>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Type:</span>
            <span class="ticket-details__value">{{$ticket->typeRelation->name}}</span>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Store name:</span>
            <a href="javascript:void(0);" data-store="{{$ticket->getStore->id}}"
               class="ticket-details__value ticket-details__value--link ticket-details__value--store">{{$ticket->getStore->store_name}}</a>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Assigned to:</span>
            @if($ticket->assigneeRelation)
                <a href="{{route('userProfile',['id' => $ticket->assigneeRelation->id])}}"
                   class="ticket-details__value ticket-details__value--link">{{$ticket->assigneeRelation->full_name}}</a>
                <span>({{$ticket->assigneeRelation->role->role}})</span>
            @else
                None
            @endif
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Category:</span>
            <span class="ticket-details__value">{{$ticket->incident->categoryRelation->name}} - {{$ticket->incident->catARelation->name}} - {{$ticket->incident->catBRelation->name}}</span>
        </li>
        {{--<li class="ticket-details__item"><span class="ticket-details__field">Sub-B Category:</span>--}}
        {{--<span class="ticket-details__value">&nbsp;</span>--}}
        {{--</li>--}}

        <li class="ticket-details__item"><span class="ticket-details__field">Data Correction:</span>

            <span class="ticket-details__value">

                                                @if(isset($ticket->SDC->id))
                    <a target="_blank" class="ticket-details__value ticket-details__value--link"
                       href="{{route('sdc.printer', ['id'=>$ticket->SDC->id])}}">{{ $ticket->SDC->sdc_no }}
                        <?php
                        $status = $ticket->SDC->status;
                        if ($status == 1) {
                            echo "(POSTED)";
                        } else if ($status == 2) {
                            echo "(ON GOING)";
                        } else if ($status == 3) {
                            echo "(FOR APPROVAL)";
                        } else if ($status == 4) {
                            echo "(APPROVED)";
                        } else if ($status == 5) {
                            echo "(DONE)";
                        } else {
                            echo "(SAVED)";
                        }
                        ?>
                                                </a>
                @elseif (isset($ticket->MDC->id))
                    <a target="_blank" class="ticket-details__value ticket-details__value--link"
                       href="{{route('mdc.printer', ['id'=>$ticket->MDC->id])}}">{{ $ticket->MDC->mdc_no }}
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
                    <span class="ticket-details__value ticket-details__value--file"><a
                            href="{{route('fileDownload',['id' => $file->id])}}"
                            target="_blank">{{$file->original_name}}</a></span>
                @endforeach
            @else
                <span class="ticket-details__value ticket-details__value--file">No Attachments</span>
            @endif
        </li>
    </ul>
    <button class="btn u-margin-top-xsmall {{!in_array($ticket->status,[$ticket_status_arr['Closed'],$ticket_status_arr['Fixed']]) ? 'u-display-n' : ''}}"
            data-action="viewFixDtls">Fix Details
    </button>
    <button class="btn u-margin-top-xsmall {{$ticket->status !== $ticket_status_arr['Rejected'] ? 'u-display-n' : ''}}"
            data-action="viewRjctDtls">Reject Details
    </button>
</div>

@if ((!$ticket->SDC && !$ticket->MDC) && $ticket->status !== $ticket_status_arr['Closed'])
    <div class="ticket-details__title-box">
        <div class="ticket-details__title">
            <h4 class="heading-quaternary">Create/Add Data Correction</h4>
        </div>
    </div>
    <div class="ticket-details__content">
        <a class="btn btn--blue" href="{{ route('sdc.show', ['id'=>$ticket->id]) }}">System Data Correct</A>
        <a class="btn btn--red" href="{{ route('mdc.show', ['id'=>$ticket->id]) }}">Manual Data Correct</a>
    </div>
@endif
