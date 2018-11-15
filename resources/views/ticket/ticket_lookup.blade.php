@extends('layouts.dashboardLayout')
@section('title','#123455')
@section('dashboardContent')
    <div class="row">
        <div class="col-3-of-4">
            <div class="group">
                <div class="ticket-content">
                    <div class="ticket-content__more-dropdown">
                        <span class="ticket-content__more">More...</span>
                        <ul class="ticket-content__list">
                            <li class="ticket-content__item"><a href="#!" class="ticket-content__link">Print</a></li>
                            <li class="ticket-content__item"><a href="#!" class="ticket-content__link">Delete</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="heading-tertiary">{{$ticket->incident->subject}}</h3>
                    </div>
                    <p class="ticket-content__details">
                        {{$ticket->incident->details}}
                    </p>
                    <textarea name="reply" id="" rows="5" class="ticket-content__reply" placeholder="Enter message here..."></textarea>
                </div>
            </div>

            <div class="group">
                <div class="thread">
                    <div class="message">
                        <div class="message__img-box">
                            <img src="{{asset('images/users/user-1.jpeg')}}" alt="John Edward R. Labor" class="message__img">
                        </div>
                        <div class="message__content">
                            <div class="message__message-box">
                                <div class="message__name">John Edward R. Labor</div>
                                <div class="message__message">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aperiam minus nisi repudiandae.</div>
                            </div>
                            <span class="message__time">3 minutes ago...</span>
                        </div>

                    </div>
                    <div class="message">
                        <div class="message__img-box">
                            <img src="{{asset('images/users/user-1.jpeg')}}" alt="John Edward R. Labor" class="message__img">
                        </div>
                        <div class="message__content">
                            <div class="message__message-box">
                                <div class="message__name">John Edward R. Labor</div>
                                <div class="message__message">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aperiam minus nisi repudiandae. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque deserunt error eveniet excepturi expedita inventore necessitatibus nihil quam quia rem. </div>
                            </div>
                            <span class="message__time">3 minutes ago...</span>
                        </div>

                    </div>
                    <div class="message">
                        <div class="message__img-box">
                            <img src="{{asset('images/users/user-1.jpeg')}}" alt="John Edward R. Labor" class="message__img">
                        </div>
                        <div class="message__content">
                            <div class="message__message-box">
                                <div class="message__name">John Edward R. Labor</div>
                                <div class="message__message">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aperiam minus nisi repudiandae.</div>
                            </div>
                            <span class="message__time">3 minutes ago...</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-1-of-4">
                <div class="ticket-details">
                        <div class="ticket-details__title-box">
                            <div class="ticket-details__title">
                                <h4 class="heading-quaternary">Details</h4>
                            </div>
                            <div class="ticket-details__icon">
                                <i class="far fa-edit"></i>
                            </div>
                        </div>
                        <div class="ticket-details__content">
                            <span class="ticket-details__id">Ticket ID: #{{$ticket->id}}</span>
                            <ul class="ticket-details__list">
                                <li class="ticket-details__item"><span class="ticket-details__field">Status:</span> <a
                                        href="#!" class="ticket-details__value ticket-details__value--status">{{$ticket->statusRelation->name}}</a></li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Origin:</span> <a
                                        href="#!" class="ticket-details__value">Call</a></li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Caller:</span> <a
                                        href="#!" class="ticket-details__value">{{$ticket->incident->call->callerRelation->name}}</a></li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Logged date:</span><a
                                        href="#!" class="ticket-details__value"> {{$ticket->created_at}}</a></li>
                                <li class="ticket-details__item"><span
                                        class="ticket-details__field">Expiration date:</span>
                                    <a href="#!" class="ticket-details__value">{{$ticket->expiration}}</a>8
                                </li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Logged by:</span>
                                    <a href="#!" class="ticket-details__value ticket-details__value--link">{{$ticket->incident->call->loggedBy->name}}</a></li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Priority:</span> <a
                                        href="#!" class="ticket-details__value ticket-details__value--{{strtolower($ticket->priorityRelation->name)}}">{{$ticket->priorityRelation->name}}</a></li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Type:</span> <a
                                        href="#!" class="ticket-details__value">{{$ticket->typeRelation->name}}</a></li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Store name:</span>
                                    <a href="#!" class="ticket-details__value ticket-details__value--link">{{$ticket->incident->call->contact->store->store_name}}</a></li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Assigned to:</span>
                                    <a href="#!" class="ticket-details__value ticket-details__value--link">@if(!is_null($ticket->assigneeRelation)){{$ticket->assigneeRelation->name}}@endif</a>
                                </li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Category:</span> <a
                                        href="#!" class="ticket-details__value">{{$ticket->incident->categoryRelation->name}}</a></li>
                                <li class="ticket-details__item"><span
                                        class="ticket-details__field">Sub-A Category:</span><a
                                        href="#!" class="ticket-details__value">&nbsp;{{$ticket->incident->catARelation->name}}</a></li>
                                <li class="ticket-details__item"><span
                                        class="ticket-details__field">Sub-B Category:</span><a
                                        href="#!" class="ticket-details__value">&nbsp;</a></li>
                                <li class="ticket-details__item"><span
                                        class="ticket-details__field">Data Correction:</span>
                                    <a href="#!" class="ticket-details__value">{{$ticket->incident->drd}}</a></li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Attachment:</span>
                                    <a href="#!" class="ticket-details__value">Empty</a></li>
                            </ul>
                        </div>
                </div>
        </div>
    </div>
@endsection
