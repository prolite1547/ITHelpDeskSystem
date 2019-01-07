    <script src="{{ asset('nifty/js/jquery.min.js') }} "></script>
    <script src="{{ asset('nifty/js/bootstrap.min.js') }} "></script>
    <script src="{{ asset('nifty/js/nifty.min.js') }} "></script>
    <script src="{{asset('nifty/plugins/flot-charts/jquery.flot.min.js')}}"></script>
    <script src="{{asset('nifty/plugins/flot-charts/jquery.flot.categories.min.js')}}"></script>
    <script src="{{asset('nifty/plugins/flot-charts/jquery.flot.orderBars.min.js')}}"></script>
    <script src="{{asset('nifty/plugins/flot-charts/jquery.flot.tooltip.min.js')}}"></script>
    <script src="{{asset('nifty/plugins/flot-charts/jquery.flot.resize.min.js')}}"></script>
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

    $(document).on('nifty.ready', function(){
        loadChartAjax();
    });

    // SELECT EVENTS
        $('#ivryear').change(function(){
            loadAjaxIVR();
        });
            $('#ivrmonth').change(function(){
            loadAjaxIVR();
        });

        $('#crmonth').change(function(){
            loadAjaxCatLogsRes();
        });

        $('#cryear').change(function(){
            loadAjaxCatLogsRes();
        });

        $('#crcategory').change(function(){
            loadAjaxCatLogsRes();
        });

        $('#tryear').change(function(){
            loadAjaxTopResolvers()
        });

        $('#trmonth').change(function(){
            loadAjaxTopResolvers()
        });

    // END OF SELECT EVENTS 

    // --------------------------------------------------

    // LOAD ALL CHARTS 
    function loadChartAjax(){
        loadAjaxIVR();
        loadAjaxCatLogsRes();
        loadAjaxTopResolvers();
    }
    // END OF LOAD ALL CHARTS

     // --------------------------------------------------

    // FUNCTIONS LOAD AJAX
        function loadAjaxIVR(){
            var ivryear =  $('#ivryear').val();
            var ivrmonth = $('#ivrmonth').val();

            $.ajax({
                method: "POST",
                url:'/reports/lvr',
                data:{ _token: '{{csrf_token()}}', month:ivrmonth ,year: ivryear},
                success: function(data){
                    $('#ivrlogged').html(data.totalLogged);
                    $('#ivrresolved').html(data.totalResolved);
                    $('.lvryear1').html(ivryear);
                    generateLVR(data.logged, data.resolved, ivrmonth);
                }
            });
        }

        function loadAjaxCatLogsRes(){
            var cryear =  $('#cryear').val();
            var crmonth = $('#crmonth').val();
            var crcategory = $('#crcategory').val();

            
            $.ajax({
                method: "POST",
                url:'/reports/ipcr',
                data:{ _token: '{{csrf_token()}}', month:crmonth ,year: cryear, category:crcategory},
                success: function(data){
                    $('#crlogged').html(data.overallLogs);
                    $('#crresolved').html(data.overallResolved);
                    $('#selectedcryear').html(cryear);
                    generateCatLogsRes(data.totalLogs,data.totalResolved,data.categories);
                    
                }
            });
        }

        function loadAjaxTopResolvers(){

            var tryear =  $('#tryear').val();
            var trmonth = $('#trmonth').val();
            
            $.ajax({
                method: "POST",
                url:'/reports/tpr',
                data:{ _token: '{{csrf_token()}}', month:trmonth , year: tryear},
                success: function(data){
                    $('#selectedtryear').html(tryear);
                    generateTopResolvers(data.topresolvers,data.solveCount);
                  
                }
            });
            
        }
    // END OF FUNCTIONS LOAD AJAX 

     // --------------------------------------------------

    // POPULATE DATA TO CHARTS
    function generateLVR(logged, resolved, month){
            
            var logs = [];
            var resolves = [];
            

            for(var i = 0; i<logged.length; i++ ){
                logs.push([month-1, logged[i]]);
            }

            for(var i = 0; i<resolved.length; i++ ){
                resolves.push([month-1, resolved[i]]);
            }
            
             
            $.plot("#logvsresolved", [
                {
                    label: "Logged",
                    data: logs
                },{
                    label: "Resolved",
                    data: resolves
                }, ],{
                series: {
                    bars: {
                        show: true,
                        lineWidth: 0,
                        barWidth: 0.25,
                        align: "center",
                        order: 1,
                        fillColor: { colors: [ { opacity: .9 }, { opacity: .9 } ] }
                    }
                },
                colors: ['#03a9f4', '#e74c3c'],
                grid: {
                    borderWidth: 0,
                    hoverable: true,
                    clickable: true
                },
                yaxis: {
                    ticks: 4, tickColor: 'rgba(0,0,0,.02)'
                },
                xaxis: {
                    ticks:  [[0, "JANUARY"], [1, "FEBRUARY"], [2, "MARCH"], [3, "APRIL"], [4,"MAY"], [5,"JUNE"], [6,"JULY"], [7,"AUGUST"], [8,"SEPTEMBER"]
                    , [9,"OCTOBER"], [10,"NOVEMBER"] ,[11,"DECEMBER"] ],
                    tickColor: 'transparent',
                    
                    
                },
                tooltip: {
                    show: true,
                    content: "<div class='flot-tooltip text-center'><h5 class='text-main'>%s</h5>%y.0 </div>"
                }
            });
        }

    function generateCatLogsRes(logged, resolved,categories){
            logs = logged;
            resolves = resolved;   
            
            $.plot("#catlogsres", [
                {
                    label: "Logged",
                    data: logs
                },{
                    label: "Resolved",
                    data: resolves
                }, ],{
                series: {
                    bars: {
                        show: true,
                        lineWidth: 0,
                        barWidth: 0.25,
                        align: "center",
                        order: 1,
                        fillColor: { colors: [ { opacity: .9 }, { opacity: .9 } ] }
                    }
                },
                colors: ['#03a9f4', '#e74c3c'],
                grid: {
                    borderWidth: 0,
                    hoverable: true,
                    clickable: true
                },
                yaxis: {
                    ticks: 4, tickColor: 'rgba(0,0,0,.02)'
                },
                xaxis: {
                    ticks: categories,
                    tickColor: 'transparent'
                },
                tooltip: {
                    show: true,
                    content: "<div class='flot-tooltip text-center'><h5 class='text-main'>%s</h5>%y.0 </div>"
                }
            });
    } 

    function generateTopResolvers(topresolvers,solveCount){
        
        $.plot("#topresolvers", [
                {
                    label: "Resolved",
                    data: solveCount
                }, ],{
                series: {
                    bars: {
                        show: true,
                        lineWidth: 0,
                        barWidth: 0.25,
                        align: "center",
                        order: 1,
                        fillColor: { colors: [ { opacity: .9 }, { opacity: .9 } ] }
                    }
                },
                colors: ['#e74c3c'],
                grid: {
                    borderWidth: 0,
                    hoverable: true,
                    clickable: true
                },
                yaxis: {
                    ticks: 4, tickColor: 'rgba(0,0,0,.02)'
                },
                xaxis: {
                    ticks: topresolvers,
                    tickColor: 'transparent'
                },
                tooltip: {
                    show: true,
                    content: "<div class='flot-tooltip text-center'><h5 class='text-main'>%s</h5>%y.0 </div>"
                }
            });
    }
    // END OF POPULATE DATA TO CHARTS   
 
     // --------------------------------------------------
      

    </script>


    </body> 
</html>