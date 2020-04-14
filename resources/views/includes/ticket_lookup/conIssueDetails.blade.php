<div class="ticket-details__title-box">
    <div class="ticket-details__title">
        <h4 class="heading-quaternary">Details</h4>
    </div>
    {{--@if((!in_array($ticket->status,[$ticket_status_arr['Fixed'],$ticket_status_arr['Closed'],$ticket_status_arr['Expired']]) && ($ticket->assigneeRelation->id === Auth::id()) || in_array(Auth::user()->role->id,$higherUserGroup)))--}}
        {{--<div class="ticket-details__icon-box">--}}
            {{--@if($ticket->assigneeRelation->id === Auth::id())--}}
                {{--<i class="fas fa-plus ticket-details__icon ticket-details__icon--add" title="Add Files"></i>--}}
            {{--@endif--}}
            {{--<i class="far fa-edit ticket-details__icon ticket-details__icon--edit" title="Edit Details"></i>--}}
        {{--</div>--}}
    {{--@endif--}}
</div>
<div class="ticket-details__content" id="emails-tocc" data-telco="{{ $telco->id }}">
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
        <li class="ticket-details__item"><span class="ticket-details__field">Company:</span>
            <span class="ticket-details__value ticket-details__value">{{$telco->name}}</span>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Sent To:</span>
            <a href="javascript:void(0);" class="ticket-details__value">{{$ticket->issue->incident->to}}</a>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">CC:</span>
            <a href="javascript:void(0);" class="ticket-details__value">{{$ticket->issue->incident->cc}}</a>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Contact Person:</span>
            <a href="javascript:void(0);"
               class="ticket-details__value">{{$ticket->issue->incident->contact_person}}</a>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Contact Number:</span>
            <a href="javascript:void(0);"
               class="ticket-details__value">{{$ticket->issue->incident->contact_number}}</a>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Logged date:</span>
            <span class="ticket-details__value"> {{$ticket->created_at}}</span>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Expiration date:</span>
            <span class="ticket-details__value">{{$ticket->getOriginal('expiration')}}</span>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Priority:</span>
            <span
                class="ticket-details__value ticket-details__value--{{strtolower($ticket->priorityRelation->name)}}">{{$ticket->priorityRelation->name}}</span>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Type:</span>
            <span class="ticket-details__value">{{$ticket->typeRelation->name}}</span>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Store name:</span>
            <a href="javascript:void(0);" data-store="{{$ticket->storeid}}"
               class="ticket-details__value ticket-details__value--link ticket-details__value--store">{{$ticket->storestore_name}}</a>
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
            <span class="ticket-details__value">{{$ticket->issue->catARelation->name}} - {{$ticket->issue->catBRelation->name}} - {{$ticket->issue->catCRelation->name}}</span>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Attachments:</span>
            @if(!$ticket->issue->getFiles->isEmpty())
                @foreach($ticket->issue->getFiles as $file)
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

