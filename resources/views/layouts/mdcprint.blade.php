<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Manual Data Correction</title>
        <link rel="stylesheet" href="{{ asset('css/app_2.css') }}">
        <link rel="stylesheet" href="{{ asset('css/sdcprint.css') }} ">
    
    </head>
    
    <body>
            <div class="container">
                <div class="row mb-2 mt-2">
                    <div class="col-md-2" >
                    <img style="float:right;" src="{{ asset('logo/cithardware.jpg') }}" width="80px" height="80px" alt="">
                    </div>
                    <div class="col-md-7 ">
                       <span class="title-header "><b>Citihardware Inc.</b></span><br>
                       <span class="sub-title">Quimpo Blvd, Matina, Davao City</span><br>
                       <span class="sub-title">Tel No.: (082) 296-1821 to 83: Telefax Nos. : (082) 298-0746 / 296-0233</span>
                    </div>
                    <div class="col-md-3">
                        <a class="btn btn-success action-buttons" onclick="window.print();" style="color:white;">Print Data</a>
                        @if (!$mdc->posted)
                        <a href="{{ route('mdc.edit', ['id'=> $mdc->id ]) }}" class="btn btn-primary action-buttons" style="color:white;">Update Data</a>
                        @endif
                    </div>
                </div>
                    <div class="row">
                            <div class="col-md-12 heading text-center">
                                <span>MANUAL DATA CORRECTION FORM</span>
                            </div>
                    </div>
                    <div class="row wborder">
                            <div class="col-md-7 text-center pt-2 ">
                                <span class="note">This form shall be used for system data correction</span><br>
                                <span class="note">This shall be subject to authorization process as defined by the management</span>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="sdc_label wborder">MDC No.</span>
                            </div>
                            <div class="col-md-3 text-center">
                                <span class="ids">{{$mdc->mdc_no}}</span><br>
                                <span class="hdticketno">HD Ticket No</span><br>
                                <span class="ids"> TID{{$mdc->ticket_no}}</span>
                            </div>
                    </div>
                         <div class="row">
                            <div class="col-md-4 wborder">
                               <span class="labels"> Date Submitted : </span>
                            </div>
                            <div class="col-md-8 wborder">
                            <span class="data"> {{ $mdc->date_submitted  }}</span>
                            </div>
                                
                        </div>
                        <div class="row">
                               <div class="col-md-4 wborder">
                                  <span class="labels"> Name of Requestor : </span>
                               </div>
                               <div class="col-md-8 wborder">
                                       <span class="data"> {{ $mdc->requestor_name }}  </span>
                                </div>
                        </div>
                        <div class="row">
                                <div class="col-md-4 wborder">
                                    <span class="labels"> Position / Department : </span>
                                </div>
                                <div class="col-md-8 wborder">
                                <span class="data"> {{ $mdc->position." / ".$mdc->department }} </span>
                                </div>
                        </div>
                        <div class="row">
                                <div class="col-md-12 heading text-center">
                                    <span>Details</span>
                                </div>
                        </div>
                        <div class="row">
                                <div class="col-md-2 wborder">
                                    <span class="labels"> Affected Store/Server : </span>
                                </div>
                                <div class="col-md-4 wborder">
                                    <span class="data"> {{ $mdc->affected_ss }} </span>
                                </div>

                                <div class="col-md-2 wborder">
                                        <span class="labels"> Affected Date : </span>
                                    </div>
                                    <div class="col-md-4 wborder">
                                    <span class="data">{{ $mdc->affected_date }}</span>
                                    </div>
                        </div>
                        <div class="row">
                                <div class="col-md-12 pt-2">
                                    <span class="labels">Findings and Recommendations : </span>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-md-12 fandr">
                                <span class="data"> {{ $mdc->findings_recommendations }}  </span>
                             </div>
                        </div>
                        <div class="row">
                                <div class="col-md-12 heading text-center">
                                    <span>Pre-Correction Verification</span>
                                </div>
                        </div>
                        <div class="row  wborder">
                                <span class="labels pt-2 pl-3">  Verified By : </span>
                                <div class="col-md-12 text-center data">
                                    {{ strtoupper($mdc->verified_by) }}
                                    @if ($mdc->verified_by_signed)
                                    <span class="signed"> [SIGNED]</span>
                                    @endif
                                </div>
                        </div> 
                        <div class="row">
                                <div class="col-md-12  text-center">
                                        <span class="note">  Signature over printed name : </span>
                                </div>
                        </div>
                        <div class="row">
                                <div class="col-md-12 heading text-center">
                                    <span>Pre-Correction Verification</span>
                                </div>
                        </div>

                        <div class="row">
                                <div class="col-md-12 pt-2">
                                    <span class="labels">  Should be data : </span>
                                </div>
                        </div> 
                        <div class="row">
                                <div class="col-md-12 fandr">
                                    <span class="data"> {{ $mdc->pre_should_be_data }}  </span>
                                 </div>
                        </div>
                        <div class="row">
                                <div class="col-md-2 wborder">
                                    <span class="labels">Verified by : </span>
                                </div>
                                <div class="col-md-4 wborder height-space text-center">
                                <span class="data adjust-span mt-2 ">
                                    <?php
                                    if($mdc->pre_verified_by){
                                        echo strtoupper($mdc->pre_verified_by);
                                    }else{
                                        echo ".";
                                    }
                                   ?>
                                    @if ($mdc->pre_verified_signed)
                                    <span class="signed"> [SIGNED]</span>
                                    @endif
                                </span>
                                    <span class="labels2 adjust-span note">Signature over printed name</span>
            
                                </div>
                                <div class="col-md-2 wborder">
                                        <span class="labels">Date Verified : </span>
                                    </div>
                                    <div class="col-md-4 wborder height-space text-center">
                                        <span class="data adjust-span mt-2 ">
                                            <?php
                                            if($mdc->pre_date_verified){
                                                echo $mdc->pre_date_verified;
                                            }else{
                                                echo ".";
                                            }
                                            ?>
                                        </span>
                                        <span class="labels2 adjust-span note">Date</span>
                
                                    </div>
                        </div>
                        <div class="row">
                                <div class="col-md-12 heading text-center">
                                    <span>Approval of the Correction Request</span>
                                </div>
                        </div>
                        <div class="row">
                                <div class="col-md-2 wborder">
                                    <span class="labels">Name of Approver (Department Head) : </span>
                                </div>
                                <div class="col-md-4 wborder height-space text-center">
                                    <span class="data adjust-span mt-2 ">
                                            <?php
                                            if($mdc->app_head_approver){
                                                echo strtoupper($mdc->app_head_approver);
                                            }else{
                                                echo ".";
                                            }
                                           ?>
                                            @if ($mdc->app_head_approver_signed)
                                            <span class="signed"> [SIGNED]</span>
                                            @endif
                                    </span>
                                    <span class="labels2 adjust-span note">Signature over printed name</span>
            
                                </div>
                                <div class="col-md-2 wborder">
                                        <span class="labels">Date : </span>
                                    </div>
                                    <div class="col-md-4 wborder height-space text-center">
                                        <span class="data adjust-span mt-2 ">
                                            <?php
                                            if($mdc->app_head_approver_date){
                                                echo $mdc->app_head_approver_date;
                                            }else{
                                                echo ".";
                                            }
                                           ?>
                                             
                                        </span>
                                        <span class="labels2 adjust-span note">Date</span>
                
                                    </div>
                        </div>
                        <div class="row">
                                <div class="col-md-2 wborder">
                                    <span class="labels">Name of Approver : </span>
                                </div>
                                <div class="col-md-4 wborder height-space text-center">
                                    <span class="data adjust-span mt-2 ">
                                            <?php
                                            if($mdc->app_approver){
                                                echo strtoupper($mdc->app_approver);
                                            }else{
                                                echo ".";
                                            }
                                           ?>
                                       @if ($mdc->app_approver_signed)
                                          <span class="signed"> [SIGNED]</span>
                                       @endif
                                    </span>
                                    <span class="labels2 adjust-span note">Signature over printed name</span>
            
                                </div>
                                <div class="col-md-2 wborder">
                                        <span class="labels">Date : </span>
                                    </div>
                                    <div class="col-md-4 wborder height-space text-center">
                                        <span class="data adjust-span mt-2 ">
                                                <?php
                                                if($mdc->app_approver_date){
                                                    echo $mdc->app_approver_date;
                                                }else{
                                                    echo ".";
                                                }
                                               ?>
                                        </span>
                                        <span class="labels2 adjust-span note">Date</span>
                
                                    </div>
                        </div>
                        <div class="row">
                                <div class="col-md-12 heading text-center">
                                    <span>Correction Processing</span>
                                </div>
                        </div>
                        <div class="row">
                                <div class="col-md-2 wborder">
                                    <span class="labels"> Request Assigned To : </span>
                                </div>
                                <div class="col-md-4 wborder text-center">
                                <span class="data">{{  strtoupper($mdc->cp_request_assignedTo) }}</span>
                                </div>

                                <div class="col-md-2 wborder">
                                        <span class="labels"> Date Completed : </span>
                                    </div>
                                    <div class="col-md-4 wborder text-center">
                                        <span class="data"> {{$mdc->cp_date_completed}} </span>
                                    </div>
                        </div>
                        <div class="row">
                                <div class="col-md-2 wborder">
                                    <span class="labels"> Request Reviewed By : </span>
                                </div>
                                <div class="col-md-4 wborder text-center">
                                <span class="data"> {{  strtoupper($mdc->cp_request_reviewedBy) }}</span>
                                </div>

                                <div class="col-md-2 wborder ">
                                        <span class="labels"> Date Reviewed : </span>
                                    </div>
                                    <div class="col-md-4 wborder text-center">
                                        <span class="data">
                                                <?php
                                                if($mdc->cp_date_reviewed){
                                                    echo $mdc->cp_date_reviewed;
                                                }else{
                                                    echo ".";
                                                }
                                               ?>
                                        </span>
                                    </div>
                        </div>
                        <div class="row">
                                <div class="col-md-12 heading text-center">
                                    <span>Deployment Confirmation</span>
                                </div>
                        </div>

                        <div class="row">
                                <div class="col-md-2 wborder">
                                    <span class="labels">Deployed by : </span>
                                </div>
                                <div class="col-md-4 wborder height-space text-center">
                                    <span class="data adjust-span mt-2 ">
                                            <?php
                                                if($mdc->dc_deployed_by){
                                                    echo strtoupper($mdc->dc_deployed_by);
                                                }else{
                                                    echo ".";
                                                }
                                           ?>
                                        @if ($mdc->dc_deployed_signed)
                                        <span class="signed"> [SIGNED]</span>
                                        @endif
                                    </span>
                                    <span class="labels2 adjust-span note">Signature over printed name</span>
            
                                </div>
                                <div class="col-md-2 wborder">
                                        <span class="labels">Reviewed by : </span>
                                    </div>
                                    <div class="col-md-4 wborder height-space text-center">
                                        <span class="data adjust-span mt-2 ">
                                                <?php
                                                if($mdc->dc_reviewed_by){
                                                    echo strtoupper($mdc->dc_reviewed_by);
                                                }else{
                                                    echo ".";
                                                }
                                           ?>

                                            @if ($mdc->dc_reviewed_signed)
                                            <span class="signed"> [SIGNED]</span>
                                            @endif
                                        </span>
                                        <span class="labels2 adjust-span note">Signature over printed name</span>
                
                                    </div>
                                </div>

                        <div class="row">
                                <div class="col-md-2 wborder">
                                   <span class="labels"> Date : </span>
                                </div>
                                <div class="col-md-4 wborder text-center">
                                <span class="data">{{  $mdc->dc_date_deployed }}</span>
                                </div>
                                <div class="col-md-2 wborder">
                                        <span class="labels"> Date : </span>
                                     </div>
                                     <div class="col-md-4 wborder text-center">
                                        <span class="data">{{  $mdc->dc_date_reviewed }}</span>
                                     </div>
                        </div>
                        <div class="row">
                                <div class="col-md-12 heading text-center">
                                    <span>Post-Correction Verification</span>
                                </div>
                        </div>
                        <div class="row">
                                <div class="col-md-2 wborder">
                                    <span class="labels">Verified by : </span>
                                </div>
                                <div class="col-md-4 wborder height-space text-center">
                                    <span class="data adjust-span mt-2 ">
                                            <?php
                                            if($mdc->post_verified_by){
                                                if($mdc->post_verified_signed){
                                                    
                                                    echo strtoupper($mdc->post_verified_by);
                                                }
                                            }else{
                                                echo ".";
                                            }
                                       ?>
                                        @if ($mdc->post_verified_signed)
                                            <span class="signed"> [SIGNED]</span>
                                        @endif
                                    </span>

                                    

                                    <span class="labels2 adjust-span note">Signature over printed name</span>
            
                                </div>
                                <div class="col-md-2 wborder">
                                        <span class="labels">Date Verified : </span>
                                    </div>
                                    <div class="col-md-4 wborder height-space text-center">
                                        <span class="data adjust-span mt-2 ">
                                                <?php
                                                if($mdc->post_date_verified){
                                                    echo $mdc->post_date_verified;
                                                }else{
                                                    echo ".";
                                                }
                                           ?>
                                        </span>
                                        <span class="labels2 adjust-span note">Date</span>
                
                                    </div>
                        </div>

                           
            </div>

            <script>
                    // window.print();
                     
            </script>
    </body>

</html>