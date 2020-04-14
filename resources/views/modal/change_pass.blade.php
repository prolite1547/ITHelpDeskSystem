<main>
           
           {!! Form::open(['id'=>'form_changepass', 'data-id'=>""]) !!}
                {!! Form::hidden('user_id', Auth::user()->id , []) !!}
                <div class="form__group">
                    <label for="old_pass" class="form__label" style="width: 100%;">Old Password : </label>
                    <input type="password"   name="old_pass" class="form__input" id="old_pass" style='width: 100%;'>
                </div>
                <div class="form__group">
                        <label for="new_pass" class="form__label" style="width: 100%;">New Password : </label>
                        <input type="password" name="new_pass" class="form__input" id="new_pass" style='width: 100%;'>
                </div>
                <div class="form__group">
                        <label for="rnew_pass" class="form__label" style="width: 100%;">Confirm Password : </label>
                        <input type="password"   name="rnew_pass" class="form__input" id="rnew_pass" style='width: 100%;'>
                </div>
                <input type="submit" value="Confirm" id="confirm-changepass" class="btn btn--red">
          {!! Form::close() !!}
          
  
</main>