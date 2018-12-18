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
            <div class="form-ticketFilter__group">
                {!! Form::label(0,'Ticket #:',['class' => 'form-ticketFilter__label']) !!}
                {!! Form::text(0,null,['placeholder' => 'ticket #','class' => 'form-ticketFilter__input']) !!}
            </div>
            <div class="form-ticketFilter__group">
                {!! Form::label(0,'Category:',['class' => 'form-ticketFilter__label']) !!}
                {!! Form::select(1,$categoryFilter,null,['placeholder' => '(select category...)','class' => 'form-ticketFilter__input']) !!}
            </div>
            <div class="form-ticketFilter__group">
                {!! Form::label(0,'Priority:',['class' => 'form-ticketFilter__label']) !!}
                {!! Form::select(3,$statusFilter,null,['placeholder' => '(select priority...)','class' => 'form-ticketFilter__input']) !!}
            </div>
            <div class="form-ticketFilter__group">
                {!! Form::label(0,'Store:',['class' => 'form-ticketFilter__label']) !!}
                {!! Form::select(4,$storeFilter,null,['placeholder' => '(select store...)','class' => 'form-ticketFilter__input']) !!}
            </div>
            <div class="form-ticketFilter__group">
                {{Form::button('Filter',['class' => 'btn btn--blue','type' => 'submit','id' => 'filterTicketBtn'])}}
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
