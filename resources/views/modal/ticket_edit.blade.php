<div class="ticket-details__content">
    <span class="ticket-details__id">Ticket ID: #{{$ticket->id}}</span>
    {{--{!! Form::open(['route' => ['editTicket', $user]]) !!}--}}

    <ul class="ticket-details__list">
        @if($ticket->assigneeRelation->id === Auth::id())
        {{--<li class="ticket-details__item"><span class="ticket-details__field">Status:</span>--}}
            {{--{!! Form::select('status', $statusSelect, $ticket->statusRelation->id, ['placeholder' => '(select priority)','class' => 'ticket-details__select','required']) !!}--}}
        {{--</li>--}}
        <li class="ticket-details__item"><span class="ticket-details__field">Caller:</span>
            <a href="#!" class="ticket-details__value">{{$ticket->incident->call->callerRelation->full_name}}</a>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Logged date:</span>
            <span class="ticket-details__value"> {{$ticket->created_at}}</span>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Expiration date:</span>
            <span class="ticket-details__value">{{$ticket->getOriginal('expiration')}}</span>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Logged by:</span>
            <a href="#!" class="ticket-details__value ticket-details__value--link">{{$ticket->userLogged->full_name}}</a>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Priority:</span>
            {!! Form::select('priority', $prioSelect,$ticket->priorityRelation->id, ['placeholder' => '(select priority)','class' => 'ticket-details__select','required']) !!}
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Type:</span>
            <span class="ticket-details__value">{{$ticket->typeRelation->name}}</span>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Store name:</span>
            <a href="#!" class="ticket-details__value ticket-details__value--link">{{$ticket->getStore->store_name}}</a>
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Assigne to:</span>
            {!! Form::select('assignee',$assigneeSelect, $ticket->assigneeRelation->id, ['placeholder' => '(assign to)','class' => 'ticket-details__select','required']) !!}
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Category:</span>
            {!! Form::select('category', $typeSelect, $ticket->incident->categoryRelation->id, ['placeholder' => '(select category)','class' => 'ticket-details__select','required']) !!}
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Sub-B Category:</span>
            {!! Form::select('catB', $incBSelect, $ticket->incident->catBRelation->id, ['placeholder' => '(select sub-B)','class' => 'ticket-details__select','required']) !!}
        </li>
        <li class="ticket-details__item"><span class="ticket-details__field">Attachments:</span>
            @if(!$ticket->incident->getFiles->isEmpty())
                @foreach($ticket->incident->getFiles as $file)
                    <span class="capsule" data-id="{{$file->id}}">
                        <a href="javascript:void(0);" class="capsule__text">{{$file->original_name}}</a>
                        <i class="fas fa-times capsule__close"></i>
                    </span>
                @endforeach
            @else
                <span class="ticket-details__value ticket-details__value--file">No Attachments</span>
            @endif
        </li>
    </ul>
    @else
        <li class="ticket-details__item"><span class="ticket-details__field">Assigne to:</span>
            {!! Form::select('assignee',$assigneeSelect, $ticket->assigneeRelation->id, ['placeholder' => '(assign to)','class' => 'ticket-details__select','required']) !!}
        </li>
    @endif
    {!! Form::close() !!}
    <div class="">
        <div class="ticket-content__buttons u-float-r">
            <button class="btn btn--red" data-action="cancel">Cancel</button>
            <button class="btn btn--green" data-action="confirm">Done</button>
        </div>
    </div>
</div>


