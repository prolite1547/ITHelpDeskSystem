@extends('datacorrections.index')

@section('content')

<?php 
        if($sdc->posted){
                echo "<script>location.href=window.history.back()</script>";
        }
?>
<div class="form-group" style="padding:30px;">
<form class="needs-validation" action="{{ route('sdc.update', ['id'=>$sdc->id]) }}" method="post" novalidate>
   
{{ csrf_field() }}
{{ method_field('PUT') }}

<div class="sdc-header" >
            <div  class="py-3 text-center mb-4">
                    <h2>SYSTEM DATA CORRECTION FORM</h2>
            </div>
            <hr>
            <div  class="row text-center">
                <div class="col-md-6">
                    <span><strong>TICKET NO : </strong></span>
                    <span id="tickerno">TID{{ $sdc->ticket_no }}</span>
                <input type="hidden" name="ticketno" value="{{ $sdc->ticket_no }}">
                </div>
                <div class="col-md-6">
                        <span><strong>SDC NO :</strong> </span>
                        <span id="sdcno">SDC{{ $sdc->id }}</span>
                      
                </div> 
            </div>
        
    </div>
    <hr>


                    <div class="row">
                      <div class="col-md-4 mb-3">
                        <label for="datesubmitted">Date Submitted : </label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" id="datesubmitted" name="datesubmitted" value="{{ $sdc->date_submitted }}" class="form-control" required>
                                <div class="input-group-addon invalid-tooltip ">
                                        Valid date is required.
                                </div>             
                            </div>
                        </div>

                      <div class="col-md-8  mb-3">
                            <label for="requestor">Name of Requestor : </label>
                            <div class="input-group">
                            <input type="text" class="form-control" name="requestor" value="{{ $sdc->requestor_name }}" id="requestor" required>
                                <div class="invalid-tooltip " style="width: 100%;">
                                    Valid name of requestor is required
                                </div>
                            </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-5 mb-3">
                            <label for="supervisor">Dept. Supervisor : </label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="supervisor" value="{{ $sdc->dept_supervisor }}" id="supervisor" required>
                                <div class="invalid-tooltip " style="width: 100%;">
                                    Valid dept. supervisor is required
                                </div>
                            </div>   
                        </div>

                        <div class="col-md-4 mb-3">
                                <label for="department">Department : </label>
                                  <select class="custom-select d-block w-100" name="department"id="department" required>
                                        <option value="{{ $sdc->department }}"> {{ $sdc->department }} </option>
                                        @foreach ($departments as $department)
                                  <option value="{{$department->department}}">{{ $department->department }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-tooltip ">
                                        Please select a valid department.
                                    </div>
                            </div>

                        <div class="col-md-3">
                                <label for="position">Position : </label>
                                <select class="custom-select d-block w-100" name="position" id="position"   required>
                                <option value="{{ $sdc->position  }}">{{$sdc->position }}</option> 
                                        @foreach ($positions  as $position)
                                                <option value="{{ $position->position }}">{{ $position->position }}</option>
                                        @endforeach
                                </select>
                                <div class="invalid-tooltip " style="width: 100%;">
                                Valid position is required
                                </div>
                        </div>
                    </div>
                    <hr>
                    <div style="background-color:#2c3e50;color:white;" class="py-3 text-center mb-3">
                            <h4>DETAILS</h4>
                    </div>
                    
                    <div class="row mb-3">
                            <div class="col-md-6 mb-3 ">
                                    <label for="affected">Affected Store/Server : </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="affected" value="{{ $sdc->affected_ss }}" id="affected" >
                                        <div class="invalid-tooltip " style="width: 100%;">
                                            Valid affected store/server is required
                                        </div>
                                    </div>   
                            </div>

                            <div class="col-md-6">
                                    <label for="terminalname">Terminal Name (For POS) : </label>
                                    <div class="input-group">
                                     <input type="text" class="form-control" name="terminalname" value="{{ $sdc->terminal_name }}" id="terminalname" >
                                        {{-- <div class="invalid-feedback" style="width: 100%;">
                                            Valid affected store/server required
                                        </div> --}}
                                    </div>   
                            </div>
                    </div>

                        <hr>
                            <div style=" color:darkslategray;padding:30px" class="py-3">
                                    <h5><b> - Hard Copy for POS - </b></h5>
                            </div>
                        <hr>
                            <div class="row mb-3">
                                    <div class="col-md-4 mb-3"">
                                            <label for="hclastzreading">Last Z Reading : </label>
                                            <div class="input-group">
                                              <input type="text" class="form-control" name="hclastzreading" value="{{ $sdc->hc_last_z_reading }}" id="hclastzreading"  >
                                                <div class="invalid-tooltip " style="width: 100%;">
                                                    Valid position is required
                                                </div>
                                            </div>   
                                    </div>
                                    <div class="col-md-4 mb-3"">
                                            <label for="hclastdcr">Last DCR : </label>
                                            <div class="input-group">
                                             <input type="text" class="form-control" name="hclastdcr" value="{{ $sdc->hc_last_dcr }}" id="hclastdcr"  >
                                                <div class="invalid-tooltip " style="width: 100%;">
                                                    Valid position is required
                                                </div>
                                            </div>   
                                    </div>
                                    <div class="col-md-4 mb-3"">
                                            <label for="hclasttransactionid">Last Transaction ID : </label>
                                            <div class="input-group">
                                            <input type="text" class="form-control" name="hclasttransactionid" value="{{ $sdc->hc_last_transaction_id }}" id="hclasttransactionid"  >
                                                <div class="invalid-tooltip " style="width: 100%;">
                                                    Valid position is required
                                                </div>
                                            </div>   
                                    </div>
                                </div>

                                <div class="row mb-3">
                                        <div class="col-md-6 mb-3"">
                                                <label for="hclastzreading">Last Accumulator : </label>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                             <div class="custom-control custom-checkbox">
                                                                    <input id="tally" name="hctally" type="checkbox" value="1"  <?php if($sdc->hc_last_accumulator){ echo "checked";}?> class="custom-control-input hcchk">
                                                                    <label class="custom-control-label" for="tally">Tally</label>
                                                              </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                                <div class="custom-control custom-checkbox">
                                                                        <input id="nottally" name="hctally" value="0" type="checkbox" <?php if($sdc->hc_last_accumulator == "0" ){ echo "checked";}?> class="custom-control-input hcchk">
                                                                        <label class="custom-control-label" for="nottally">Not Tally</label>
                                                                </div>
                                                        </div>
                                                              
                                                    </div>
                                                      
                                         </div>
                                         
                                <div class="col-md-6 mb-3"">
                                    <label for="hclastorno">Last OR No. : </label>
                                    <div class="input-group">
                                     <input type="text" class="form-control" name="hclastorno" value="{{ $sdc->hc_last_or_no }}" id="hclastorno" >
                                        <div class="invalid-tooltip " style="width: 100%;">
                                            Valid position is required
                                        </div>
                                    </div>   
                            
                            </div>
                            </div>
               
                            <hr>
                            <div style=" color:darkslategray;padding:30px" class="py-3">
                                    <h5><b> - Soft Copy for POS -</b></h5>
                            </div>
                        <hr>
                            <div class="row mb-3">
                                    <div class="col-md-6 mb-3"">
                                            <label for="sclastzreading">Last Z Reading : </label>
                                            <div class="input-group">
                                            <input type="text" class="form-control" name="sclastzreading" value="{{ $sdc->sc_last_z_reading }}" id="sclastzreading"  >
                                                <div class="invalid-tooltip " style="width: 100%;">
                                                    Valid position is required
                                                </div>
                                            </div>   
                                    </div>
                                 
                                    <div class="col-md-6 mb-3"">
                                            <label for="sclasttransactionid">Last Transaction ID : </label>
                                            <div class="input-group">
                                            <input type="text" class="form-control" name="sclasttransactionid" value="{{ $sdc->sc_last_transaction_id }}" id="sclasttransactionid"  >
                                                <div class="invalid-tooltip " style="width: 100%;">
                                                    Valid position is required
                                                </div>
                                            </div>   
                                    </div>
                                </div>

                                <div class="row mb-3">
                                        <div class="col-md-6 mb-3"">
                                                <label for="sclastzreading">Last Accumulator : </label>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                             <div class="custom-control custom-checkbox">
                                                                    <input id="sctally" name="sctally" type="checkbox" value="1" <?php if($sdc->sc_last_accumulator){ echo "checked";}?> class="custom-control-input scchk">
                                                                    <label class="custom-control-label" for="sctally">Tally</label>
                                                              </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                                <div class="custom-control custom-checkbox">
                                                                        <input id="scnottally" name="sctally" type="checkbox" value="0" <?php if($sdc->sc_last_accumulator == "0"){ echo "checked";}?> class="custom-control-input scchk">
                                                                        <label class="custom-control-label" for="scnottally">Not Tally</label>
                                                                </div>
                                                        </div>
                                                              
                                                    </div>
                                                      
                                         </div>
                                         
                                <div class="col-md-6 mb-3"">
                                    <label for="sclastorno">Last OR No. : </label>
                                    <div class="input-group">
                                    <input type="text" class="form-control" name="sclastorno" value="{{ $sdc->sc_last_or_no }}" id="sclastorno" >
                                        <div class="invalid-tooltip " style="width: 100%;">
                                            
                                        </div>
                                    </div>   
                            
                            </div>
                            </div>
                   
                    
                    <div class="row mb-3">
                          <div class="col-md-12">
                                <label for="dfindings">Findings and Recommendations :</label>
                            <div class="input-group">
                            <textarea type="text" class="form-control" name="dfindings" cols="5" rows="5"   id="dfindings">{{ $sdc->findings_recommendations }}</textarea>
                                <div class="invalid-tooltip " style="width: 100%;">
                                    Findings and recommendations is required
                                </div>
                            </div>   
                          </div>

                    </div>

                    <hr>
                    <div style="background-color:#2c3e50;color:white;" class="py-3 text-center mb-3">
                            <h4>PRE-CORRECTION VERIFICATION</h4>
                    </div>
                    
                    <div class="row mb-3">
                            <div class="col-md-12">
                                  <label for="preaccumulatorverifiedby">Accumulator verified by :</label> 
                                  <div class="custom-control custom-checkbox mb-3">
                                        <input id="preaccsigned" name="preaccsigned" type="checkbox" value="1" <?php if($sdc->pre_acc_verified_signed){ echo "checked";}?> class="custom-control-input">
                                        <label class="custom-control-label" for="preaccsigned">Signed</label>
                                  </div>
                              <div class="input-group">
                              <input type="text" class="form-control" name="preaccumulatorverifiedby" value="{{ $sdc->pre_acc_verified_by }}" id="preaccumulatorverifiedby"  >
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid accumulator verified by is required
                                    </div>
                                 
                              </div>   
                            </div>
                      </div>

                      <div class="row mb-3">
                            <div class="col-md-12">
                                    <label for="predateaccumulator">Date : </label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <input type="text" id="predateaccumulator" name="predateaccumulator" value="{{ $sdc->pre_acc_verified_date }}" class="form-control" >
                                            <div class="input-group-addon invalid-tooltip ">
                                                    Valid date is required.
                                            </div>             
                                        </div>
                            </div>
                      </div>

                      <hr>

                      <div class="row mb-3">
                            <div class="col-md-4 mb-3">
                                  <label for="prezreadingno">Next Z Reading No.  :</label>
                              <div class="input-group">
                              <input type="text" class="form-control" name="prezreadingno" value="{{ $sdc->pre_next_z_reading }}" id="prezreadingno"  >
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid Z reading no. is required
                                    </div>
                              </div>   
                            </div>

                            <div class="col-md-4 mb-3">
                                    <label for="prenextorno">Next OR No.  :</label>
                                      <div class="input-group">
                                      <input type="text" class="form-control" name="prenextorno" value="{{ $sdc->pre_next_or_no }}" id="prenextorno"  >
                                      <div class="invalid-tooltip " style="width: 100%;">
                                              Valid OR no. is required
                                      </div>
                                </div>   
                              </div>

                              <div class="col-md-4">
                                    <label for="prelasttransactionid">Last Transaction ID :</label>
                                      <div class="input-group">
                                      <input type="text" class="form-control" name="prelasttransactionid" value="{{ $sdc->pre_last_transaction_id }}" id="prelasttransactionid" >
                                      <div class="invalid-tooltip " style="width: 100%;">
                                              Valid OR no. is required
                                      </div>
                                </div>   
                              </div>
                      </div>

                      
                      <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                        <label for="prelastacc">Last Accumulator :</label>
                                        <div class="input-group">
                                        <input type="text" class="form-control" name="prelastacc" value="{{$sdc->pre_last_acc}}" id="prelastacc"  >
                                        <div class="invalid-tooltip " style="width: 100%;">
                                                Valid last accumulator
                                        </div>
                                </div>   
                                </div>

                                <div class="col-md-6">
                                        <label for="prelastorno">Last OR No. :</label>
                                        <div class="input-group">
                                        <input type="text" class="form-control" name="prelastorno" value="{{$sdc->pre_last_or_no}}" id="prelastorno" >
                                        <div class="invalid-tooltip " style="width: 100%;">
                                                Valid last OR no. is required
                                        </div>
                                </div>   
                                </div>
                      </div>


                      <div class="row mb-3">
                            <div class="col-md-12">
                                  <label for="preverifiedby">Verified by :</label>
                                  <div class="custom-control custom-checkbox mb-3">
                                        <input id="preverifiedsigned" name="preverifiedsigned" type="checkbox" value="1" <?php if($sdc->pre_verified_signed){ echo "checked";}?> class="custom-control-input">
                                        <label class="custom-control-label" for="preverifiedsigned">Signed</label>
                                 </div>
                              <div class="input-group">
                                    <input type="text" class="form-control" name="preverifiedby" value="{{$sdc->pre_verified_by}}" id="preverifiedby"  >
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid verified by is required
                                    </div>
                                 
                              </div>   
                            </div>
                      </div>

                      <div class="row mb-3">
                            <div class="col-md-12">
                                    <label for="preverifieddate">Date : </label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <input type="text" id="preverifieddate"  name="preverifieddate" value="{{$sdc->pre_date_verified}}" class="form-control" >
                                            <div class="input-group-addon invalid-tooltip ">
                                                    Valid date is required.
                                            </div>             
                                        </div>
                                    </div>
                      </div>
                    
                      <hr>
                      <div style="background-color:#2c3e50;color:white;" class="py-3 text-center mb-3">
                              <h4>APPROVAL OF THE CHANGE REQUEST</h4>
                      </div>

                      <div class="row mb-3">
                            <div class="col-md-12 mb-3">
                                  <label for="acrapprovedby">Approved by :</label>
                                  <div class="custom-control custom-checkbox mb-3">
                                        <input id="appapprovedsigned" name="appapprovedsigned" type="checkbox" value="1" <?php if($sdc->app_approved_signed){ echo "checked";}?> class="custom-control-input">
                                        <label class="custom-control-label" for="appapprovedsigned">Signed</label>
                                  </div>
                              <div class="input-group">
                                    <input type="text" class="form-control" name="acrapprovedby" value="{{ $sdc->app_approved_by }}" id="acrapprovedby"  >
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid verified by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-12">
                                    <label for="acrdate">Date : </label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <input type="text" id="acrdate" name="acrdate" value="{{$sdc->app_date_approved}}" class="form-control" >
                                            <div class="input-group-addon invalid-tooltip ">
                                                    Valid date is required.
                                            </div>             
                                        </div>
                                    </div>
                      </div>

                      <hr>
                      <div style="background-color:#2c3e50;color:white;" class="py-3 text-center mb-3">
                              <h4>CHANGE PROCESSING</h4>
                      </div>

                      <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                             <label for="cprassignedto">Request Assigned To :</label> 
                              
                              <div class="input-group">
                              <input type="text" class="form-control" name="cprassignedto" value="{{ $sdc->cp_request_assigned_to }}" id="cprassignedto" >
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid request assigned to is required
                                    </div>
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                    <label for="cprassigneddate">Date Completed :</label>
                                <div class="input-group">
                                        <div class="input-group date" data-provide="datepicker">
                                        <input type="text" id="cprassigneddate" name="cprassigneddate" value="{{$sdc->cp_date_completed}}" class="form-control" >
                                                <div class="input-group-addon invalid-tooltip ">
                                                        Valid date is required.
                                                </div>             
                                        </div>
                                   
                                </div>   
                              </div>

                              
                      </div>

                      <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                  <label for="cprreviewedby">Request Reviewed By :</label>
                                
                              <div class="input-group">
                              <input type="text" class="form-control" name="cprreviewedby" value="{{ $sdc->cp_request_reviewed_by }}" id="cprreviewedby">
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid request reviewed by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="cpdatereviewed">Date Reviewed :</label>
                                <div class="input-group">
                                        <div class="input-group date" data-provide="datepicker">
                                                <input type="text" id="cpdatereviewed" name="cpdatereviewed" value="{{$sdc->cp_date_reviewed}}" class="form-control" >
                                                <div class="input-group-addon invalid-tooltip ">
                                                        Valid date is required.
                                                </div>             
                                        </div>
                                   
                                </div>   
                              </div>
                      </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                                <label for="tfaffected">Tables and Fields Affected :</label>
                            <div class="input-group">
                            <textarea type="text" class="form-control" cols="5" rows="5" name="tfaffected" id="tfaffected">{{ $sdc->cp_table_fields_affected }}</textarea>
                                <div class="invalid-tooltip " style="width: 100%;">
                                      Tables and Fields Affected is required
                                </div>
                            </div>   
                            </div>
                    </div>

                    <hr>
                    <div style="background-color:#2c3e50;color:white;" class="py-3 text-center mb-3">
                            <h4>DEPLOYMENT CONFIRMATION</h4>
                    </div>

                    <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                              <label for="dcdeployedby">Deployed By :</label>
                              <div class="custom-control custom-checkbox ml-3" style="display:inline-block;   ">
                                        <input id="dcdeployedsigned" name="dcdeployedsigned" type="checkbox" value="1" <?php if($sdc->dc_deployed_signed){ echo "checked";}?> class="custom-control-input">
                                        <label class="custom-control-label" for="dcdeployedsigned">Signed</label>
                              </div>
    
                              <div class="input-group">
                              <input type="text" class="form-control" id="dcdeployedby" value="{{ $sdc->dc_deployed_by }}" name="dcdeployedby">
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid request reviewed by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dcdeployeddate">Date :</label>
                                <div class="input-group">
                                        <div class="input-group date" data-provide="datepicker">
                                                <input type="text" id="dcdeployeddate" name="dcdeployeddate" value="{{$sdc->dc_date_deployed}}" class="form-control" >
                                                <div class="input-group-addon invalid-tooltip ">
                                                        Valid date is required.
                                                </div>             
                                        </div>
                                   
                                </div>   
                              </div>
                      </div>

                      <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                  <label for="dcrreviewedby">Reviewed By :</label>
                                  <div class="custom-control custom-checkbox ml-3" style="display:inline-block;   ">
                                                <input id="dcreviewedsigned" name="dcreviewedsigned" type="checkbox" value="1" <?php if($sdc->dc_reviewed_signed){ echo "checked";}?> class="custom-control-input">
                                                <label class="custom-control-label" for="dcreviewedsigned">Signed</label>
                                 </div>
                              <div class="input-group">
                              <input type="text" class="form-control" name="dcrreviewedby" value="{{ $sdc->dc_reviewed_by }}" id="dcrreviewedby">
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid request reviewed by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dcrdate">Date :</label>
                                <div class="input-group">
                                        <div class="input-group date" data-provide="datepicker">
                                                <input type="text" id="dcrdate" name="dcrdate"  value="{{$sdc->dc_date_reviewed}}" class="form-control" >
                                                <div class="input-group-addon invalid-tooltip ">
                                                        Valid date is required.
                                                </div>             
                                        </div>
                                   
                                </div>   
                              </div>
                      </div>

                      <hr>
                      <div style="background-color:#2c3e50;color:white;" class="py-3 text-center mb-3">
                              <h4>POST CORRECTION VERIFICATION</h4>
                      </div>

                      <div class="row mb-3">
                            <div class="col-md-12 mb-3">
                                <label for="pcvverifiedby">Verified by :</label>
                                <div class="custom-control custom-checkbox ml-3" style="display:inline-block;   ">
                                        <input id="postverifiedsigned" name="postverifiedsigned" type="checkbox" value="1" <?php if($sdc->post_verified_signed){ echo "checked";}?> class="custom-control-input">
                                        <label class="custom-control-label" for="postverifiedsigned">Signed</label>
                                 </div>
                                <div class="input-group">
                                <input type="text" class="form-control" name="pcvverifiedby"  value="{{ $sdc->post_verified_by }}" id="pcvverifiedby"  >
                                      <div class="invalid-tooltip " style="width: 100%;">
                                              Valid verified by is required
                                      </div>
                                   
                                </div>    
                              </div>
  
                              <div class="col-md-12">
                                      <label for="pcvdate">Date : </label>
                                          <div class="input-group date" data-provide="datepicker">
                                                
                                              <input type="text" name="pcvdate" id="pcvdate"  value="{{$sdc->post_date_verified}}" class="form-control" >
                                             
                                              <div class="input-group-addon invalid-tooltip ">
                                                      Valid date is required.
                                              </div>             
                                          </div>
                                      </div>
                      </div>
 
                    <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" value="0" name="posted" type="submit">Save Changes</button>
                <button class="btn btn-danger btn-lg btn-block" value="1" name="posted" type="submit">Post Data Correction</button>
            </form>
        
    </div>
    


@endsection