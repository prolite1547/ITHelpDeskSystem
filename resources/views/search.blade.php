@extends('layouts.dashboardLayout')
@section('title','Search Results')
@section('submenu')@endsection

@section('content')
    <main>
        <div class="search">
            <h1 class="search__header">Search Results:</h1>
            <div class="search__results">
                @if($ticket)
                    <a class="search__item" href="{{route('lookupTicketView',['id' => $ticket->id])}}">
                        <div class="search__label">Ticket #{{$ticket->id}}</div>
                        <div class="search__details">
                        {{$ticket->incident->details}}
                        </div>
                    </a>
                @else
                    <h1 class="search__error">No Search Results Found</h1>
                @endif
            </div>
            </div>
        </div>
    </main>
@endsection
