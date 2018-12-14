
<script src="{{ asset('js/app_2.js') }}"></script>
<script src="{{ asset('js/jquery-3.3.1.min.js') }} "></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>


<script>
        $('#department').on('change',function(){
          var depID =  $(this).find(':selected').data('id');
            $.ajax({
                type : "POST",
                url : "/get/positions",
                data : { _token: '{{csrf_token()}}', department_id: depID },
                success:function(data){
                     $('#position').html(data.data);
                }
               
            });
        });

        

        $('.date1').datepicker({
          multidate: true
      });

          $('.needs-validation').on('keyup keypress', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) { 
            e.preventDefault();
            return false;
          }
        });

        $('input.scchk').on('change', function() {
          $('input.scchk').not(this).prop('checked', false);  
       });

      $('input.hcchk').on('change', function() {
          $('input.hcchk').not(this).prop('checked', false);  
       });

        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
          'use strict';
  
          window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            


            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                 
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }

                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
 
      </script>
</body>
</html>