<div class="extend-details">
    @foreach($ticket_extensions as $extend)
    <div class="extend-details__item">
        <div class="extend-details__header">
            Extended by <strong class="extend-details__person">{{$extend->extendedBy->full_name}}</strong> on <i class="extend-details__date">{{$extend->created_at}}</i>
        </div>
        <div class="extend-details__details">
            {{$extend->details}}
        </div>
    </div>
    @endforeach
</div>
