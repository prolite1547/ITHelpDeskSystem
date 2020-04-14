<div class="group" data-thread="chat">
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


<div class="group u-display-n" data-thread="reply">
    <div class="thread">
        <svg class="thread__refresh" data-ticket="{{ $ticket->id }}" data-issue="{{ $ticket->issue->incident_id }}" data-refresh="conIssue"><use xlink:href="{{asset('svg/sprite2.svg#icon-cw')}}"></use></svg>
        @foreach($ticket->connectionIssueMailReplies as $replies)
            <div class="message" data-id="{{$replies->id}}">
                <div class="message__content">
                    <div class="message__message-box">
                        <div class="message__name">{{$replies->from['full']}}</div>
                        <div class="message__message">{!! $replies->html_body !!}</div>
                        <div class="message__flex message__flex--sb">
                            <span class="message__time">{{$replies->reply_date}}</span>
                            <div>
                                @if($replies->hasAttachments !== 0)
                                    <span class="message__attachment-count">{{$replies->hasAttachments}}📎</span>
                                @endif
                                <a class="message__conversation" href="{{route('replyConversation',['id' => $replies->id])}}" title="View conversation" target="_blank">👁️‍🗨️</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


