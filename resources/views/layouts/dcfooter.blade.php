
<script src="{{ asset('js/app_2.js') }}"></script>
<script src="{{ asset('js/jquery-3.3.1.min.js') }} "></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>


<script>
        
        var attachmentTormv =  [];

        function isEmptyOrSpaces(str){
          return str === null || str.match(/^ *$/) !== null;
      }

      function showRejectButton(){
          $('.show-reject').hide();
          $('.submit-reject').fadeIn();

          $('html, body').animate({
         scrollTop: $(".submit-reject").offset().top
         });
      }

      function closeRejection(){
        $('.show-reject').fadeIn();
        $('.submit-reject').hide();
        $('html, body').animate({
         scrollTop: $(".show-reject").offset().top
         });
      }

      function submitRejection(btn){  
          var sdcno = $(btn).data('sdcno');
          var userid = $(btn).data('userid');
          var fstatus = $(btn).data('fstatus');
          var content = $('#rejectreason').val();
          
          // reject/sdc
          if(!isEmptyOrSpaces(content)){
              $.ajax({
                    type : "POST",
                    url : "/reject/sdc",
                    data : { 
                      _token: '{{csrf_token()}}', 
                      sdcno: sdcno, 
                      rejector: userid, 
                      forward_status: fstatus, 
                      content:content 
                    },
                    success:function(data){
                      window.history.back()
                    }
                    
                  
                });
          }else{
              alert("Empty field");
          }
           
      }

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

      try{
        document.querySelector('#upfile1').addEventListener('change', handleFileSelect, false);
                selDiv = document.querySelector("#selectedFiles1");

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
            var position = $('#position').data('position');
              $.ajax({
                  type : "POST",
                  url : "/get/positions",
                  data : { _token: '{{csrf_token()}}', department_id: depID, pos:position },
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

        $('.confirmation').on('click',function(e){
          e.preventDefault();
          swal({
                title: "Are you sure?",
                text: "You are about to submit this data correction!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((confirmed) => {
                if (confirmed) {
                  $('#confirmSubmit').click();
                  
                }  
              });
 
        });


        $('.confirmation1').on('click',function(e){
          e.preventDefault();
          swal({
                title: "Are you sure?",
                text: "You are about to approve this data correction!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((confirmed) => {
                if (confirmed) {
                  $('#confirmApprove').click();
                  
                }  
              });
 
        });

        $('.confirmation2').on('click',function(e){
          e.preventDefault();
          swal({
                title: "Are you sure?",
                text: "You are about to post this data correction!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((confirmed) => {
                if (confirmed) {
                  $('#confirmPost').click();
                  
                }  
              });
 
        });

        $('.confirmation3').on('click',function(e){
          e.preventDefault();
          swal({
                title: "Are you sure?",
                text: "You are about to mark this data correction as done!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((confirmed) => {
                if (confirmed) {
                  $('#confirmDone').click();
                  
                }  
              });
 
        });

        $('.confirmation4').on('click',function(e){
          e.preventDefault();
          swal({
                title: "Are you sure?",
                text: "You are about to reject this data correction!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((confirmed) => {
                if (confirmed) {
                  $('#confirmReject').click();
                  
                }  
              });
 
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


        $('.rmvAttachment1').on('click',function(){
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

        try {
            $('#app_group').on('change',function(){
               var group = $(this).val();
                $.ajax({
                  url:"/group/selection",
                  type: "POST",
                  data: {
                    _token: '{{csrf_token()}}',
                    group:group,
                  },
                  success:function(data){ 
                       $('.selected-group').html(data.data);
                      if(data.Iscustom == true){
                          $('#hlabel').html("Assign approvers (hierarchy) :");
  
                              $('#approver1').on('change',function(){
                                var myValue = $(this).val();
                                   $.ajax({
                                     url : "/assign/group",
                                     type: "POST",
                                     data:{
                                      _token: '{{csrf_token()}}',
                                      id: 1,
                                      value : myValue
                                     },
                                     success:function(data){
                                        if(myValue != 4){
                                             $('#approver2').html(data.data).removeAttr('disabled','disabled');
                                             if(myValue != 3){
                                                    if(myValue == 2){
                                                        $('#approver3').removeAttr('disabled','disabled').html("<option value = '4'>FINAL APPROVER</option>");
                                                        $('#approver4').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                                    }else{
                                                        $('#approver3').removeAttr('disabled','disabled').html("<option value = '3'>GOV. COMPLIANCE</option><option value = '4'>FINAL APPROVER</option>");
                                                        $('#approver4').removeAttr('disabled','disabled').html("<option value = '4'>FINAL APPROVER</option>");
                                                    }
                                                }else{
                                                   $('#approver3').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                                   $('#approver4').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                             }
                                            //  $('#approver4').html("<option value = '0'>--- --- ---</option>");
                                        }else{
                                              $('#approver2').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                              $('#approver3').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                              $('#approver4').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                        }
                                        
                                     }
                                    
                                   });
                              });
                              $('#approver2').on('change',function(){
                                var myValue = $(this).val();
                                $.ajax({
                                     url : "/assign/group",
                                     type: "POST",
                                     data:{
                                      _token: '{{csrf_token()}}',
                                      id: 2,
                                      value : myValue
                                     },
                                     success:function(data){
                                        if(myValue != 4){
                                              $('#approver3').html(data.data).removeAttr('disabled','disabled');
                                              if(myValue == 3){
                                                  $('#approver4').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                              }else{
                                                  $('#approver4').html("<option value = '4'>FINAL APPROVER</option>").removeAttr('disabled','disabled');
                                              }
                                          }else{
                                                $('#approver3').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                                $('#approver4').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                          }
                                      }
                                   });
                              });
                              $('#approver3').on('change',function(){
                                var myValue = $(this).val();
                                $.ajax({
                                     url : "/assign/group",
                                     type: "POST",
                                     data:{
                                      _token: '{{csrf_token()}}',
                                      id: 3,
                                      value : myValue
                                     },
                                     success:function(data){

                                    
                                      if(myValue != 4){
                                              $('#approver4').html(data.data).removeAttr('disabled','disabled');
                                      }else{
                                            $('#approver4').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                      }
                                     }
                                   });
                              });   
                      }else{
                          $('#hlabel').html("Hierarchy :");
                      }
                  }
                });
            });
        } catch (error) {
          console.log(error);
        }

        try {
              var group = $('#app_group').val();
              var sdc_id = $('#app_group').data('sdc');

              $.ajax({
                url:"/group/selection2",
                type: "POST",
                data: {
                  _token: '{{csrf_token()}}',
                  group:group,
                  sdc_id : sdc_id
                },
                success:function(data){
                      $('.selected-group').html(data.data);
                      if(data.Iscustom == true){
                          $('#hlabel').html("Assign approvers (hierarchy) :");
  
                              $('#approver1').on('change',function(){
                                var myValue = $(this).val();
                                   $.ajax({
                                     url : "/assign/group",
                                     type: "POST",
                                     data:{
                                      _token: '{{csrf_token()}}',
                                      id: 1,
                                      value : myValue
                                     },
                                     success:function(data){
                                        if(myValue != 4){
                                             $('#approver2').html(data.data).removeAttr('disabled','disabled');
                                             if(myValue != 3){
                                                    if(myValue == 2){
                                                        $('#approver3').removeAttr('disabled','disabled').html("<option value = '4'>FINAL APPROVER</option>");
                                                        $('#approver4').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                                    }else{
                                                        $('#approver3').removeAttr('disabled','disabled').html("<option value = '3'>GOV. COMPLIANCE</option><option value = '4'>FINAL APPROVER</option>");
                                                        $('#approver4').removeAttr('disabled','disabled').html("<option value = '4'>FINAL APPROVER</option>");
                                                    }
                                                }else{
                                                   $('#approver3').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                                   $('#approver4').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                             }
                                            //  $('#approver4').html("<option value = '0'>--- --- ---</option>");
                                        }else{
                                              $('#approver2').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                              $('#approver3').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                              $('#approver4').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                        }
                                        
                                     }
                                    
                                   });
                              });
                              $('#approver2').on('change',function(){
                                var myValue = $(this).val();
                                $.ajax({
                                     url : "/assign/group",
                                     type: "POST",
                                     data:{
                                      _token: '{{csrf_token()}}',
                                      id: 2,
                                      value : myValue
                                     },
                                     success:function(data){
                                        if(myValue != 4){
                                              $('#approver3').html(data.data).removeAttr('disabled','disabled');
                                              if(myValue == 3){
                                                  $('#approver4').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                              }else{
                                                  $('#approver4').html("<option value = '4'>FINAL APPROVER</option>").removeAttr('disabled','disabled');
                                              }
                                          }else{
                                                $('#approver3').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                                $('#approver4').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                          }
                                      }
                                   });
                              });
                              $('#approver3').on('change',function(){
                                var myValue = $(this).val();
                                $.ajax({
                                     url : "/assign/group",
                                     type: "POST",
                                     data:{
                                      _token: '{{csrf_token()}}',
                                      id: 3,
                                      value : myValue
                                     },
                                     success:function(data){

                                    
                                      if(myValue != 4){
                                              $('#approver4').html(data.data).removeAttr('disabled','disabled');
                                      }else{
                                            $('#approver4').html("<option value = '0'>--- --- ---</option>").attr('disabled','disabled');
                                      }
                                     }
                                   });
                              });   
                      }else{
                          $('#hlabel').html("Hierarchy :");
                      }
                }

              });

         

        }catch (error) {
          console.log(error);
        }

        const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'PHP',
        minimumFractionDigits: 2
      })

       function getTotalNetSales(){
            var vat_sales = 0;
            var non_vat_sales = 0;
            var z_rated_sales = 0;
            var vat_amount1 = 0;
            var vat_ex_amount1 = 0;
            var total_net_sales = 0;


            if($('#vat_sales').val() != ""){
              vat_sales = parseFloat($('#vat_sales').val());
            }

            if($('#non_vat_sales').val() != ""){
              non_vat_sales = parseFloat($('#non_vat_sales').val());
            }

            if($('#z_rated_sales').val() != ""){
              z_rated_sales = parseFloat($('#z_rated_sales').val());
            }

            if($('#vat_amount1').val() != ""){
              vat_amount1 = parseFloat($('#vat_amount1').val());
            }

            if($('#vat_ex_amount1').val() != ""){
              vat_ex_amount1 = parseFloat($('#vat_ex_amount1').val());
            }
              total_net_sales = vat_sales +  non_vat_sales + z_rated_sales + vat_amount1 + vat_ex_amount1 ;
      
            $('#total_net_sales').val(formatter.format(total_net_sales));
  
       }


       function getTotalNetReturns(){
            var vat_returns = 0;
            var non_vat_returns = 0;
            var z_rated_ret = 0;
            var vat_amount2 = 0;
            var vat_ex_amount2 = 0;
            var total_net_returns = 0;

            if($('#vat_returns').val() != ""){
                vat_returns = parseFloat($('#vat_returns').val());
            }

            if($('#non_vat_returns').val() != ""){
              non_vat_returns = parseFloat($('#non_vat_returns').val());
            }

            if($('#z_rated_ret').val() != ""){
              z_rated_ret = parseFloat($('#z_rated_ret').val());
            }

            if($('#vat_amount2').val() != ""){
              vat_amount2 = parseFloat($('#vat_amount2').val());
            }
    
            if($('#vat_ex_amount2').val() != ""){
              vat_ex_amount2 = parseFloat($('#vat_ex_amount2').val());
            }
            
              total_net_returns = vat_returns + non_vat_returns + z_rated_ret + vat_amount2 + vat_ex_amount2;

            $('#total_net_returns').val(formatter.format(total_net_returns));

       }

         function getTotalAfterReturns(){
            var accum_vat = 0;
            var accum_non_vat = 0;
            var accum_z_rated = 0;
            var vat_amount3 = 0;
            var vat_ex_amount3 = 0;
            var total_after_ret = 0;

            if($('#accum_vat').val() != ""){
               accum_vat = parseFloat($('#accum_vat').val());
            }

            if($('#accum_non_vat').val() != ""){
              accum_non_vat = parseFloat($('#accum_non_vat').val());
            }

            if($('#accum_z_rated').val() != ""){
              accum_z_rated = parseFloat($('#accum_z_rated').val());
            }

            if($('#vat_amount3').val() != ""){
              vat_amount3 = parseFloat($('#vat_amount3').val());
            }

            if($('#vat_ex_amount3').val() != ""){
              vat_ex_amount3 = parseFloat($('#vat_ex_amount3').val());
            }

            total_after_ret = accum_vat + accum_non_vat + accum_z_rated + vat_amount3 + vat_ex_amount3;


              $('#total_after_ret').val(formatter.format(total_after_ret));
         }

       
         function isNumberKey(evt, obj) {

              var charCode = (evt.which) ? evt.which : event.keyCode
              var value = obj.value;
              var dotcontains = value.indexOf(".") != -1;
              if (dotcontains)
                  if (charCode == 46) return false;
              if (charCode == 46) return true;
              if (charCode > 31 && (charCode < 48 || charCode > 57))
                  return false;
              return true;
      }

      // onkeypress="return isNumberKey(event,this)"

     
       
      </script>
</body>
</html>