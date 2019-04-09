<div class="treasury-lookup">
    <div class="row-flex row-flex--jc-sb row-flex--wrap">
        <span class="ticket-details__id treasury-lookup__tcketId">Ticket ID: #{{$ticket->id}}</span>
        <div class="treasury-lookup__content">
            <label for="subject" class="treasury-lookup__label">Subject</label>
            <textarea name="subject" class="treasury-lookup__value" id="subject" readonly>{{$ticket->issue->subject}}</textarea>
            <label for="subject" class="treasury-lookup__label">Details</label>
            <textarea name="details" class="treasury-lookup__value" id="details" readonly>{{$ticket->issue->details}}</textarea>
        </div>
        <div class="treasury-lookup__details">
            <ul class="ticket-details__list">
                @if($ticket->extended->count() > 0)
                    <li class="ticket-details__item"><span class="ticket-details__field">Times Extended:</span>
                        <a href=""
                           class="ticket-details__value ticket-details__value--link ticket-details__value--extend">{{$ticket->extended->count()}}
                            - Click for details!</a>
                    </li>
                @endif
                <li class="ticket-details__item"><span class="ticket-details__field">Status:</span>
                    <span
                        class="ticket-details__value ticket-details__value--status">{{$ticket->statusRelation->name}}</span>
                </li>
                <li class="ticket-details__item"><span class="ticket-details__field">Caller:</span>
                    <a href="javascript:void(0);"
                       class="ticket-details__value">{{$ticket->issue->incident->caller->full_name}}
                        ({{$ticket->issue->incident->caller->position->position}})</a>
                </li>
                <li class="ticket-details__item"><span class="ticket-details__field">Logged date:</span>
                    <span class="ticket-details__value"> {{$ticket->created_at}}</span>
                </li>
                <li class="ticket-details__item"><span class="ticket-details__field">Expiration date:</span>
                    <span class="ticket-details__value">{{$ticket->getOriginal('expiration')}}</span>
                </li>
                <li class="ticket-details__item"><span class="ticket-details__field">Logged by:</span>
                    <a href="javascript:void(0);"
                       class="ticket-details__value ticket-details__value--link">{{$ticket->userLogged->full_name}}</a>
                    <span>({{$ticket->userLogged->role->role}})</span>
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
                        <a href="javascript:void(0);"
                           class="ticket-details__value ticket-details__value--link">{{$ticket->assigneeRelation->full_name}}</a>
                        <span>({{$ticket->assigneeRelation->role->role}})</span>
                    @else
                        None
                    @endif
                </li>
                <li class="ticket-details__item"><span class="ticket-details__field">Category:</span>
                    <span class="ticket-details__value">{{$ticket->issue->categoryRelation->name}} - {{$ticket->issue->catARelation->name}} - {{$ticket->issue->catBRelation->name}}</span>
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
                    <span class="ticket-details__value">{{$ticket->issue->drd}}</span>
                </li> --}}
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
            <button
                class="btn u-margin-top-xsmall {{!in_array($ticket->status,[$ticket_status_arr['Closed'],$ticket_status_arr['Fixed']]) ? 'u-display-n' : ''}}"
                data-action="viewFixDtls">Fix Details
            </button>
            <button
                class="btn u-margin-top-xsmall {{$ticket->status !== $ticket_status_arr['Rejected'] ? 'u-display-n' : ''}}"
                data-action="viewRjctDtls">Reject Details
            </button>
        </div>

    </div>
</div>
