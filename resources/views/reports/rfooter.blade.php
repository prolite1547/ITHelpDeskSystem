<script src="{{ asset('nifty/js/jquery.min.js') }} "></script>
<script src="{{ asset('nifty/js/bootstrap.min.js') }} "></script>
<script src="{{ asset('nifty/js/nifty.min.js') }} "></script>
<script src="{{ asset('nifty/js/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('nifty/js/dataTables/dataTables.bootstrap4.min.js') }}"></script> 

<script src="{{ asset('nifty/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('nifty/plugins/chosen/chosen.jquery.min.js') }}"></script>
<script src="{{ asset('nifty/plugins/select2/js/select2.min.js') }}"></script>

<script src="{{ asset('nifty/js/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('nifty/js/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('nifty/js/daterangepicker/daterangepicker.js') }}"></script>
 
 

<script>
        $('.demo-chosen-select').chosen({width:'100%'});
        $('.demo-cs-multiselect').chosen({width:'100%'});
        $('input[name="daterange"]').daterangepicker();
        $('#data_5 .input-daterange').datepicker({
         
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
        });
        
         $("#monthPicker").datepicker({
                  format: "m/yyyy",
                  viewMode: "months", 
                  minViewMode: "months"
         });
</script>
<script> 
         var rowCount = 0;
         var resolvedCount = 0;

        // $(document).ready(function(){
        //     $('.dataTables-example').DataTable({
        //         pageLength: 25,
        //         responsive: true,
        //         dom: '<"html5buttons"B>lTfgitp',
        //         buttons: [
        //             { extend: 'copy'},
        //             {extend: 'csv'},
        //             {extend: 'excel', title: 'ExampleFile'},
        //             {extend: 'pdf', title: 'ExampleFile'},

        //             {extend: 'print',
        //              customize: function (win){
        //                     $(win.document.body).addClass('white-bg');
        //                     $(win.document.body).css('font-size', '10px');

        //                     $(win.document.body).find('table')
        //                             .addClass('compact')
        //                             .css('font-size', 'inherit');
        //             }
        //             }
        //         ]

        //     });

        // });

        function getIPPData() {
         
           var user_id = $('#user').val();
           var start1 = $('#ippstartDate').val();
           var end1 = $('#ippendDate').val();


            $.ajax({
               type:'POST',
               url:'/reports/genipp',
               data:{ _token: '{{csrf_token()}}', user_id:user_id, start: start1, end:end1 },
               beforeSend:function(){
                  $(".loading").show();
               },
               success:function(data) {
                  $(".loading").hide();
                  $('#ticket-logged').show();
                  $('#IPPDATA').html(data.ippdata);
                  $('#ticket-logs').html(data.ticket_logged);

                            $('.IPPTable').DataTable({
                            pageLength: 25,
                            responsive: true,
                            dom: '<"html5buttons"B>lTfgitp',
                            buttons: [
                                {extend: 'copy'},
                                {extend: 'csv', title: 'Issues Per Person ('+start1+'-'+end1+')'},
                                {extend: 'excel', title: 'Issues Per Person ('+start1+'-'+end1+')'},
                                {extend: 'pdf', title: 'Issues Per Person ('+start1+'-'+end1+')'},

                                {extend: 'print',
                                customize: function (win){
                                        $(win.document.body).addClass('white-bg');
                                        $(win.document.body).css('font-size', '10px');

                                        $(win.document.body).find('table')
                                                .addClass('compact')
                                                .css('font-size', 'inherit');
                                }
                                }
                            ]

                        });
               }
            });
         }


         function getIPCData(){
            var categ = $('#category').val();
            var monthyear = $('#month').val();
            var montharr = monthyear.split('/');

            var month1 = montharr[0];
            var year1 = montharr[1];

            $.ajax({
               type:'POST',
               url:'/reports/genipc',
               data:{ _token: '{{csrf_token()}}', category:categ ,month:month1, year:year1},
               success:function(data) {
                  $('#IPCDATA').html(data.ipcdata);
                            $('.IPCTable').DataTable({
                            pageLength: 25,
                            responsive: true,
                            dom: '<"html5buttons"B>lTfgitp',
                            buttons: [
                                {extend: 'copy'},
                                {extend: 'csv', title:'Issues Per Category ('+month1+'/'+year1+')'},
                                {extend: 'excel', title: 'Issues Per Category ('+month1+'/'+year1+')'},
                                {extend: 'pdf', title: 'Issues Per Category ('+month1+'/'+year1+')'},

                                {extend: 'print',
                                customize: function (win){
                                        $(win.document.body).addClass('white-bg');
                                        $(win.document.body).css('font-size', '10px');

                                        $(win.document.body).find('table')
                                                .addClass('compact')
                                                .css('font-size', 'inherit');
                                }
                                }
                            ]

                        });
               }
            });
         }

          function getILRData(){
            var categ = $('#category1').val();
            var start1 = $('#ilrstartDate').val();
            var end1 = $('#ilrendDate').val();
            var status = $('#status').val();

            $.ajax({
               type:'POST',
               url: "/reports/genilr",
               data:{ _token: '{{csrf_token()}}', category:categ, start:start1, end:end1, status :status},
               success:function(data) {
                  $('#ILRDATA').html(data.ilrdata);
                  rowCount = data.rowCount;
                  resolvedCount = data.resolvedCount;

                            $('.ILRTable').DataTable({
                            pageLength: 25,
                            responsive: true,
                            "autoWidth": true,
                            "order": [[ 3, "desc" ]],
                            dom: '<"html5buttons"B>lTfgitp',
                            buttons: [
                                { extend: 'copy'},
                                {extend: 'csv',  title: 'Issues Logged vs. Resolved ('+start1+'-'+end1+')'},
                                {extend: 'excel', title: 'Issues Logged vs. Resolved ('+start1+'-'+end1+')'},
                                {extend: 'pdf',  title: 'Issues Logged vs. Resolved ('+start1+'-'+end1+')'},

                                {extend: 'print', title: 'Issues Logged vs. Resolved ('+start1+'-'+end1+')',
                                customize: function (win){
                                        $(win.document.body).addClass('white-bg');
                                        $(win.document.body).css('font-size', '10px');
                                        $(win.document.body).find('h1').css('font-size', '14px');
                                        $(win.document.body).find('h1').append("<br><br>Logged : "+ rowCount + " | Resolved : "+ resolvedCount);
                                        $(win.document.body).find('table')
                                                .addClass('compact')
                                                .css('font-size', 'inherit');
                                }
                                }
                            ]

                        });
               },
               error:function(error){
                  console.log(error);
               }  
            });
         }

         function getRDSData(){
            var start1 = $('#rdstartDate').val();
            var end1 = $('#rdendDate').val();
            var store = $('#store').val();

            $.ajax({
               type:'POST',
               url: "/reports/genrds",
               data:{ _token: '{{csrf_token()}}', store:store ,start:start1, end:end1},
               success:function(data) {
                
                  $('#RDSDATA').html(data.rdsdata);
                            $('.RDSTable').DataTable({
                            pageLength: 25,
                            responsive: true,
                            "order": [[ 0, "desc" ]],
                            dom: '<"html5buttons"B>lTfgitp',
                            buttons: [
                                {extend: 'copy'},
                                {extend: 'csv',  title: 'Reported Downtime Per Store ('+start1+'-'+end1+')'},
                                {extend: 'excel', title: 'Reported Downtime Per Store ('+start1+'-'+end1+')'},
                                {extend: 'pdf',  title: 'Reported Downtime Per Store ('+start1+'-'+end1+')'},

                                {extend: 'print',
                                customize: function (win){
                                        $(win.document.body).addClass('white-bg');
                                        $(win.document.body).css('font-size', '10px');

                                        $(win.document.body).find('table')
                                                .addClass('compact')
                                                .css('font-size', 'inherit');
                                }
                                }
                            ]

                        });
               }
            });
         }


         function getINVData(){
            var start1 = $('#invstartDate').val();
            var end1 = $('#invendDate').val();
            var invstatus = $('#invstatus').val();


            $.ajax({
               type:'POST',
               url: "/reports/geninv",
               data:{ _token: '{{csrf_token()}}', start:start1, end:end1, status:invstatus},
               success:function(data) {
                
                  $('#INVDATA').html(data.invdata);
                            $('.INVTable').DataTable({
                            pageLength: 25,
                            responsive: true,
                            "order": [[ 0, "desc" ]],
                            dom: '<"html5buttons"B>lTfgitp',
                            buttons: [
                                {extend: 'copy'},
                                {extend: 'csv',  title: 'Inventory Report ('+start1+'-'+end1+')'},
                                {extend: 'excel', title: 'Inventory Report ('+start1+'-'+end1+')'},
                                {extend: 'pdf',  title: 'Inventory Report ('+start1+'-'+end1+')'},
                                {extend: 'print',
                                customize: function (win){
                                        $(win.document.body).addClass('white-bg');
                                        $(win.document.body).css('font-size', '10px');
                                        $(win.document.body).find('table')
                                                .addClass('compact')
                                                .css('font-size', 'inherit');
                                }
                                }
                            ]

                        });
               }
            });
         }

         function getReportSummary(){
            var start1 = $('#summaryStartDate').val();
            var end1 = $('#summaryEndDate').val();
             $('#SUMMARYDATA').html('<p class="text-center">Fetching data, Please wait...</p>');
             $.ajax({
                type: "POST",
                url: "/reports/gensummary",
                data: {
                  _token: '{{csrf_token()}}',
                  start: start1,
                  end: end1,
                },
                success : function(data){
                  $('#SUMMARYDATA').html(data.summarydata);
                  $('.SUMMARYDATA').DataTable({
                     pageLength: 25,
                     responsive: true,
                     "order": [[ 0, "desc" ]],
                     dom: '<"html5buttons"B>lTfgitp',
                     buttons: [
                         {extend: 'copy'},
                         {extend: 'csv',  title: 'Ticket Summary Report ('+start1+'-'+end1+')'},
                         {extend: 'excel', title: 'Ticket Summary Report ('+start1+'-'+end1+')'},
                         {extend: 'pdf',  title: 'Ticket Summary Report ('+start1+'-'+end1+')'},
                         {extend: 'print',
                         customize: function (win){
                                 $(win.document.body).addClass('white-bg');
                                 $(win.document.body).css('font-size', '10px');
                                 $(win.document.body).find('table')
                                         .addClass('compact')
                                         .css('font-size', 'inherit');
                         }
                         }
                     ]
   
                 });
                } 
             });
         }




</script>
