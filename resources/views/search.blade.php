@extends('layouts.dashboardLayout')
@section('title','Search Results')
@section('submenu')@endsection

@section('content')
    <main>
        <div class="search">
            <h1 class="search__header">Search Results:</h1>
            <div class="search__results">
                @forelse($search_results as $results)
                    <a class="search__item" href="{{route('lookupTicketView',['id' => $results->id])}}">
                        <div class="search__label">Ticket #{{$results->id}}</div>
                        <div class="search__details">
                        {{$results->details}}
                        </div>
                    </a>
                @empty
                    <h1 class="search__error">No Search Results Found</h1>
                @endforelse
            </div>
            </div>
        </div>
    </main>
@endsection
