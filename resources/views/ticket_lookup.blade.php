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
                        <h3 class="heading-tertiary">Accounting printer won't print</h3>
                    </div>
                    <p class="ticket-content__details">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, accusamus eos explicabo illo laudantium repellat voluptatibus. Architecto consequatur cumque dolorum ducimus esse fuga illum, nam nobis non nostrum nulla quasi?
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
                            <span class="ticket-details__id">Ticket ID: #12345</span>
                            <ul class="ticket-details__list">
                                <li class="ticket-details__item"><span class="ticket-details__field">Status:</span> <a
                                        href="#!" class="ticket-details__value ticket-details__value--status">Open</a></li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Origin:</span> <a
                                        href="#!" class="ticket-details__value">Call</a></li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Caller:</span> <a
                                        href="#!" class="ticket-details__value">Malu Pet</a></li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Logged date:</span><a
                                        href="#!" class="ticket-details__value"> September 9,2018</a></li>
                                <li class="ticket-details__item"><span
                                        class="ticket-details__field">Expiration date:</span>
                                    <a href="#!" class="ticket-details__value">September 10,201</a>8
                                </li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Logged by:</span>
                                    <a href="#!" class="ticket-details__value ticket-details__value--link">John Edward R. Labor</a></li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Priority:</span> <a
                                        href="#!" class="ticket-details__value ticket-details__value--normal">Normal</a></li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Type:</span> <a
                                        href="#!" class="ticket-details__value">Incident</a></li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Store name:</span>
                                    <a href="#!" class="ticket-details__value ticket-details__value--link">Citihardware Matina</a></li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Assigned to:</span>
                                </li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Category:</span> <a
                                        href="#!" class="ticket-details__value">Hardware</a></li>
                                <li class="ticket-details__item"><span
                                        class="ticket-details__field">Sub-A Category:</span><a
                                        href="#!" class="ticket-details__value"></a></li>
                                <li class="ticket-details__item"><span
                                        class="ticket-details__field">Sub-B Category:</span><a
                                        href="#!" class="ticket-details__value"></a></li>
                                <li class="ticket-details__item"><span
                                        class="ticket-details__field">Data Correction:</span>
                                    <a href="#!" class="ticket-details__value">n/a</a></li>
                                <li class="ticket-details__item"><span class="ticket-details__field">Attachment:</span>
                                    <a href="#!" class="ticket-details__value">Empty</a></li>
                            </ul>
                        </div>
                </div>
        </div>
    </div>
@endsection
