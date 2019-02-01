
<script src="{{ asset('js/app_2.js') }}"></script>
<script src="{{ asset('js/jquery-3.3.1.min.js') }} "></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>


<script>
        
        var attachmentTormv =  [];

      try{
        document.querySelector('#upfile').addEventListener('change', handleFileSelect, false);
                selDiv = document.querySelector("#selectedFiles");

                function handleFileSelect(e) {
                    
                    if(!e.target.files) return;
                    
                    selDiv.innerHTML = "";
                    
                    var files = e.target.files;
                    var filesList = "";
                    for(var i=0; i<files.length; i++) {
                      var f = files[i];
                      filesList +="<li>"+ f.name +"</li>";
                    }

                    selDiv.innerHTML = filesList;
              }
       
      }catch(error){

      }
              
      
        try {
            var depID =  $('#department').find(':selected').data('id');
              $.ajax({
                  type : "POST",
                  url : "/get/positions",
                  data : { _token: '{{csrf_token()}}', department_id: depID },
                  success:function(data){
                      $('#position').html(data.data);
                      
                  }
                
              });
        }catch (error) {}

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


        $('.input-validate').on('keyup keypress', function(e){
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
              e.preventDefault();
              return false;
            }
          });

        
        //   $('.needs-validation').on('keyup keypress', function(e) {
        //   var keyCode = e.keyCode || e.which;
        //   if (keyCode === 13) { 
        //     e.preventDefault();
        //     return false;
        //   }
        // });

      

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
        
        $('.rmvAttachment').on('click',function(){
             var yesno = confirm("Are you sure you want to remove this attachment ? \n("+$(this).data('name')+")");

             if(yesno == true){
                var id = $(this).data('id');
                var att_id = $(this).data('att_id');
                var name = $(this).data('name');
                $('#'+id).remove();
                $.ajax({
                    url: '/rmv/attachment',
                    type : 'POST',
                    data : {
                      _token: '{{csrf_token()}}', id : att_id, original_name : name
                    },
                    success: function(data){
                          window.alert('Attachment has been removed');
                    }
                });
             }
        });

       
      </script>
</body>
</html>