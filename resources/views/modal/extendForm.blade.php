<div class="extend-form">
    {{Form::open(['id' => 'extend-form','route' => ['addExtend',$id],'method' => 'POST'])}}
        <div class="form__group">
            {{Form::textarea('details',null,['class' => 'form__textarea','rows' => '10','placeholder' => 'Enter details for extension...','required'])}}
        </div>
        <div class="form__group">
            {{Form::select('duration',[],null,['class' => 'extend-form__duration','placeholder' => '(select duration...)','required'])}}
        </div>

        {!! Form::button('Extend',['class' => 'btn btn--blue','type' => 'submit']) !!}
    {{Form::close()}}
</div>
