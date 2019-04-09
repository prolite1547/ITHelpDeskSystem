<div class="ticket-content">
    <div class="ticket-content__more-dropdown-container">
        <div class="ticket-content__more-dropdown">
            <span class="ticket-content__more">More...</span>
            <ul class="ticket-content__list">
                @can('extend',$ticket)
                    <li class="ticket-content__item"><a href="javascript:void(0);" class="ticket-content__link ticket-content__link--extend">Extend</a></li>
                @endcan
                @can('update',$ticket)
                    @if(is_null($ticket->incident->connection_id))
                     <li class="ticket-content__item"><a href="javascript:void(0);" class="ticket-content__link ticket-content__link--edit">Edit</a></li>
                    @endif
                @endif
                {{--@if((in_array(Auth::user()->role_id,[$user_roles['tower'],$user_roles['admin']]) && in_array($ticket->status,[$ticket_status_arr['Fixed']])) && $ticket->status !== $ticket_status_arr['Open'])--}}
                    {{--<li class="ticket-content__item"><a href="javascript:void(0);" class="ticket-content__link ticket-content__link--resolve">Resolve</a></li>--}}
                    {{--<li class="ticket-content__item"><a href="javascript:void(0);" class="ticket-content__link ticket-content__link--reject">Reject</a></li>--}}
                {{--@endif--}}
                <?php $onTicketCount = 0; 
                      $sdcStatusDone = true;
                ?>

                @if (isset($sdc))
                    @if ($sdc->status != 4)
                        <?php $sdcStatusDone = false;?>
                    @endif
                @endif

                @if (isset($cTicket))
                        @foreach ($cTicket as $tcket)
                                 @if ($tcket->status != 3)
                                        <?php $onTicketCount+=1; ?>
                                 @endif
                        @endforeach
                @endif
                
                @if(!in_array($ticket->status,[$ticket_status_arr['Fixed'],$ticket_status_arr['Closed'],$ticket_status_arr['Expired']]) && $ticket->assigneeRelation->id === Auth::id() && $onTicketCount == 0 && $sdcStatusDone)

                    <li class="ticket-content__item"><a href="javascript:void(0);" class="ticket-content__link ticket-content__link--fix">Mark as fixed..</a></li>

                @endif
              
                {{-- @can('markAsFix',$ticket)
                    <li class="ticket-content__item"><a href="javascript:void(0);" class="ticket-content__link ticket-content__link--fix">Mark as fixed..</a></li>
                @endcan --}}
                <li class="ticket-content__item"><a href="{{route('print.ticket',['id' => $ticket->id])}}" target="_blank" class="ticket-content__link ticket-content__link--print">Print</a></li>
                @can('delete', App\Ticket::class)
                    <li class="ticket-content__item">
                        <a href="javascript:void(0);" class="ticket-content__link" onclick="document.getElementById('ticket_delete').submit()">Delete</a>
                        <form action="{{route('ticketDelete',['id' => $ticket->id])}}" method="POST" id="ticket_delete">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE" >
                        </form>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
    <div>
        <h3 class="heading-tertiary ticket-content__subject">{{$ticket->incident->subject}}</h3>
    </div>
    <p class="ticket-content__details">
        {!!$ticket->incident->details!!}
    </p>
    @if($ticket->status !== $ticket_status_arr['Expired'])
        <form class="chat" data-form="chat" enctype="multipart/form-data">
            <ul class="chat__menu">
                <li class="chat__item" data-form="chat">Chat</li>
                <li class="chat__item u-display-n" data-form="reply">Reply</li>
            </ul>
            <div class="form__group u-display-n">
                <label for="to" class="chat__label">To:</label>
                <input type="email" name="to" class="chat__text" multiple required>
            </div>
            <div class="form__group-flex">
                <textarea name="reply" rows="3" class="chat__textarea" placeholder="Enter message here..." maxlength="1000" minlength="5" required></textarea>
                <input value="Send" class="chat__button" type="submit" name="chat__button">
            </div>
            <input type="file" class="chat__attachment u-display-n" name="reply_attachments[]" multiple>
        </form>
    @endif
    <div class="ticket-content__updateBtns">
        <div class="ticket-content__buttons u-float-r">
            <button class="btn btn--red" data-action="cancel" id="contentEditCancel">Cancel</button>
            <button class="btn btn--green" data-action="confirm" id="contentEditSave">Done</button>
        </div>
    </div>
</div>
