<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{asset('images/tab-logo.png')}}" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">
    <title>Print</title>
    <style>

        html {
            font-size: 62.5%;
            font-family: 'Lato', sans-serif;
            line-height: 1.7;
        }

        :root {
            --color-grey: rgba(196, 196, 196, 0.61);
        }

        *,
        *::after,
        *::before {
            padding: 0;
            margin: 0;
            box-sizing: inherit;
        }

        body{
            box-sizing: border-box;
        }

        .container {
            padding: 1rem;
            display: flex;
            flex-flow: column;
        }

        .print {
            font-size: 1.4rem;
            border: 1px solid var(--color-grey);
            padding: 2rem;
        }

        .print__header {
        }

        .print__group {
            display: flex;
            align-items: center;
            height: 3rem;
        }

        .print__group:not(:last-child) {
            border-bottom: 1px solid var(--color-grey);
        }

        .print__label {
            font-weight: 700;
            flex: 0 0 15rem;
        }

        .messages{
            margin-top: 2rem;
            padding: 2rem;
            border: 1px solid var(--color-grey);
        }

        .messages__header {
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--color-grey);
        }

        .messages__left {
            margin-right: 5px;
        }

        .messages__item {
           display: flex;
            height: 10rem;
            align-items: center;
        }

        .messages__img-container{
            height: 50px;
            width: 50px;
        }

        .messages__img{
            width: 100%;
        }

        .messages__item:not(:last-child) {
            border-bottom: 1px solid var(--color-grey);
        }

        .messages__name {
            font-size: 1.4rem;
            font-weight: 900;
        }

        .messages__date {
            font-style: italic;
        }

        .messages__icon-time{
            margin-left: 1rem;
        }
        .messages__icon-time {
            width: 1rem;
            height: 1rem;
        }

        .messages__message {
            font-weight: 700;
            word-break: break-word;
        }

        .print-btn {
            font-size: 2rem;
            padding: .5rem 1rem;
            color: white;
            background-color: #1b4b72;
            border-radius: .4rem;
            position: fixed;
            top: 3rem;
            right: 10%;
            cursor: pointer;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.5);
        }

        .print-btn:active {
            transform: translateY(2px);
            box-shadow: 0 .2rem 1rem rgba(0,0,0,.5);
        }

        @media print {
            .print-btn {
                visibility: hidden;
            }
        }

    </style>
</head>
<body>

    <span class="print-btn">Print</span>
    <div class="container">
        <div class="print">
            <div class="print__group">
                <h2 class="print__header">Ticket ID: {{$ticket->id}}</h2>
            </div>
            <div class="print__group">
                <div class="print__label">Subject:</div>
                <div class="print__value">{{$ticket->issue->subject}}</div>
            </div>
            <div class="print__group">
                <div class="print__label">Details:</div>
                <div class="print__value">{{$ticket->issue->details}}</div>
            </div>
            <div class="print__group">
                <div class="print__label">Contact #:</div>
                <div class="print__value">{{$ticket->issue->incident->contact->store->store_name}} - {{$ticket->issue->incident->contact->number}}</div>
            </div>
            <div class="print__group">
                <div class="print__label">Caller:</div>
                <div class="print__value">{{$ticket->issue->incident->caller->full_name}}</div>
            </div>
            <div class="print__group">
                <div class="print__label">Logged Date:</div>
                <div class="print__value">{{$ticket->created_at}}</div>
            </div>
            <div class="print__group">
                <div class="print__label">Logged By:</div>
                <div class="print__value">{{$ticket->issue->incident->loggedBy->full_name}} <span>({{$ticket->issue->incident->loggedBy->role->role}})</span>}</div>
            </div>
            <div class="print__group">
                <div class="print__label">Expiration Date:</div>
                <div class="print__value">{{$ticket->getOriginal('expiration')}} ({{$ticket->expiration}})</div>
            </div>
            <div class="print__group">
                <div class="print__label">Status:</div>
                <div class="print__value">{{$ticket->statusRelation->name}}</div>
            </div>
            <div class="print__group">
                <div class="print__label">Priority:</div>
                <div class="print__value">{{$ticket->priorityRelation->name}}</div>
            </div>
            <div class="print__group">
                <div class="print__label">Type:</div>
                <div class="print__value">{{$ticket->typeRelation->name}}</div>
            </div>
            <div class="print__group">
                <div class="print__label">Assigned To:</div>
                <div class="print__value">{{$ticket->assigneeRelation->full_name}} <span>({{$ticket->assigneeRelation->role->role}})</span></div>
            </div>
            @if($ticket->status === 3)
            <div class="print__group">
                <div class="print__label">Resolved By:</div>
                <div class="print__value">{{$ticket->resolve->resolvedBy->full_name}} <span>({{$ticket->resolve->resolvedBy->role->role}})</span></div>
            </div>
            <div class="print__group">
                <div class="print__label">Resolved Date:</div>
                <div class="print__value">{{$ticket->resolve->created_at}}</div>
            </div>
            @endif
            <div class="print__group">
                <div class="print__label">Category:</div>
                <div class="print__value">{{$ticket->issue->categoryRelation->name}} > {{$ticket->issue->catARelation->name}} > {{$ticket->issue->catBRelation->name}}</div>
            </div>
            <div class="print__group">
                <div class="print__label">Data Correction:</div>
                <div class="print__value">
                    @if(isset($ticket->SDC->id))
                        {{ $ticket->SDC->sdc_no }}@if($ticket->SDC->posted)(POSTED)@endif
                    @elseif (isset($ticket->MDC->id))
                       {{ $ticket->MDC->mdc_no }}@if($ticket->MDC->posted)(POSTED)@endif
                    @endif
                </div>
            </div>
            <div class="print__group">
                <div class="print__label">Attachments:</div>
                <div class="print__value">
                    @if(!$ticket->issue->getFiles->isEmpty())
                        @foreach($ticket->issue->getFiles as $file)
                            <span class="ticket-details__value ticket-details__value--file"><a href="{{route('fileDownload',['id' => $file->id])}}" target="_blank">{{$file->original_name}}</a></span>
                        @endforeach
                    @else
                        <span class="ticket-details__value ticket-details__value--file">No Attachments</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="messages">
            <h1 class="messages__header">
                Conversations
            </h1>

            <div class="messages__list">
                    @forelse($ticket->ticketMessages as $message)
                        <div class="messages__item">
                            <div class="messages__left">
                                <div class="messages__img-container">
                                    <img class="messages__img" src="{{asset("storage/profpic/".$message->user->profpic->image."")}}" alt="{{$message->user->full_name}}">
                                </div>
                            </div>
                            <div class="messages__right">
                                <div class="messages__name">{{$message->user->full_name}}</div>
                                <blockquote class="messages__message">"{{$message->message}}"</blockquote>
                                <div class="messages__date-group">
                                    <datetime class="messages__date">{{$message->getOriginal('created_at')}}</datetime>
                                    <svg class="messages__icon-time">
                                        <use xlink:href="{{asset('svg/sprite2.svg#icon-hour-glass')}}"></use>
                                    </svg>
                                    {{$message->created_at}}
                                </div>
                            </div>
                        </div>
                    @empty
                        <h2 class="message__empty">No Conversations</h2>
                    @endforelse
            </div>
        </div>
    </div>

    <script>
        document.querySelector('.print-btn').addEventListener('click',() => {
           window.print();
        });
    </script>
</body>
</html>
