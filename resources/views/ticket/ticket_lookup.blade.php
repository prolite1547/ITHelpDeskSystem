@extends('layouts.dashboardLayout')
@section('title','Ticket #'.$ticket->id)
@section('content')
    <main>
        <div class="row">
            <div class="col-3-of-4">
                <div class="group">
                    @include('includes.ticket_lookup.content')
                </div>

                    @include('includes.ticket_lookup.messages')
            </div>
            <div class="col-1-of-4">
                <div class="ticket-details">
                    @if( isset($ticket->incident->call_id) && is_null($ticket->incident->connection_id) )
                        @include('includes.ticket_lookup.defaulltDetails')
                    @elseif( isset($ticket->incident->connection_id) && is_null($ticket->incident->call_id) )
                        @include('includes.ticket_lookup.conIssueDetails')
                    @else
                        NOT FOUND
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection


