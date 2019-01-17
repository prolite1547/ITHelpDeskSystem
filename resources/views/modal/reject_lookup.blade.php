<div class="reject-details">
    <p class="reject-details__reason">
        {{$rejectData->reason}}
    </p>
    <div class="reject-details__flex">
        <span class="reject-details__name">{{$rejectData->getUser->full_name}}({{$rejectData->getUser->role->role}})</span> on
        <datetime class="reject-details__date">{{$rejectData->created_at}}</datetime>
    </div>
</div>
