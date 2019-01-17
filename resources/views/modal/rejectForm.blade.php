<div class="reject">
    {{Form::open(array('route' => ['ticketReject',$id],'method' => 'POST','class'=>'reject__form'))}}
    {{Form::textarea('reason',null,array('class' => 'reject__reason','placeholder' => 'reject reason...','required','minlength' => '5','maxlength' => '150'))}}
    {{Form::button('Reject',array('class' => 'btn btn--blue','data-action' => 'reject-ticket','type' => 'submit'))}}
</div>
