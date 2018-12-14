<aside class="side">
    <div class="side__title">
        <h3 class="heading-tertiary">Ticket types</h3>
        <svg class="icon" id="ticketFilter">
            <use xlink:href="{{asset('svg/sprite.svg#icon-filter')}}"></use>
        </svg>
    </div>
    <div class="side__content">
        <div class="filter u-display-n">
            {{Form::open(['class' => 'form-ticketFilter'])}}
            {!! Form::select('category',$typeSelect,null,['placeholder' => '(select category...)','required']) !!}
            <div class="form__group">
                {{Form::button('Filter',['class' => 'btn','type' => 'submit'])}}
            </div>
            {{Form::close()}}
            <svg class="filter__icon">
                <use xlink:href="{{asset('svg/sprite.svg#icon-caret-up')}}"></use>
            </svg>
        </div>


        <dl class="side__dl">
            <dt class="side__dt">All types <span class="side__count">({{$ticketCount}})</span></dt>
            <dd class="side__dd">Incident <span class="side__count">({{$incident}})</span></dd>
            <dd class="side__dd">Request <span class="side__count">({{$request}})</span></dd>
        </dl>
    </div>
</aside>
