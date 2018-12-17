@extends('datacorrections.index')

@section('content')

<?php 
         if($mdc->posted){
                echo "<script>location.href=window.history.back()</script>";
        }
?>

<div class="form-group" style="padding:30px;">
<form class="needs-validation" action="{{ route('mdc.update', ['id'=>$mdc->id]) }}" method="post" novalidate>
   
{{ csrf_field() }}
{{ method_field('PUT') }}

    <div class="sdc-header" >
            <div  class="py-3 text-center mb-4">
                    <h2>MANUAL DATA CORRECTION FORM</h2>
            </div>
            <hr>
            <div  class="row text-center">
                <div class="col-md-6">
                    <span><strong>TICKET NO : </strong></span>
                    <span id="tickerno">TID{{$mdc->ticket_no}}</span>
                    <input type="hidden" name="ticketno" value="{{$mdc->ticket_no}}">
                </div>
                <div class="col-md-6">
                        <span><strong>MDC NO :</strong> </span>
                       
                        <span id="mdcno"> 
                                
                                MDC{{  $mdc->id }}
                                
                        </span>

                        
                </div> 
            </div>
        
    </div>
    <hr>


                    <div class="row">
                      <div class="col-md-4 mb-3">
                        <label for="datesubmitted">Date Submitted : </label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" id="datesubmitted" name="datesubmitted"  value="{{ $mdc->date_submitted }}" class="form-control" required>
                                <div class="input-group-addon invalid-tooltip ">
                                        Valid date is required.
                                </div>             
                            </div>
                        </div>

                      <div class="col-md-8  mb-3">
                            <label for="requestor">Name of Requestor : </label>
                            <div class="input-group">
                            <input type="text" class="form-control" name="requestor" id="requestor" value="{{ $mdc->requestor_name }}" required>
                                <div class="invalid-tooltip " style="width: 100%;">
                                    Valid name of requestor is required
                                </div>
                            </div>
                      </div>
                    </div>

                    <div class="row mb-3">

                        <div class="col-md-6 mb-3">
                                <label for="department">Department : </label>
                                    <select class="custom-select d-block w-100" name="department" id="department" required>
                                    <option value="{{ $mdc->department }}">{{ $mdc->department  }}</option>
                                        @foreach ($departments as $department)
                                    <option value="{{ $department->department }} "> {{ $department->department }} </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-tooltip ">
                                        Please select a valid department.
                                    </div>
                            </div>

                        <div class="col-md-6 mb-3">
                                <label for="position">Position : </label>
                                <select class="custom-select d-block w-100" name="position" id="position"   required>
                                <option value="{{ $mdc->position  }}">{{$mdc->position }}</option> 
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
                                    <input type="text" class="form-control" name="affected" value="{{ $mdc->affected_ss }}"  id="affected" >
                                        <div class="invalid-tooltip " style="width: 100%;">
                                            Valid affected store/server is required
                                        </div>
                                    </div>   
                            </div>

                            <div class="col-md-6">
                                    <label for="affecteddate">Affected Date : </label>
                            <input type="text" id = "affecteddate" name="affecteddate" value="{{ $mdc->affected_date }}"  class="form-control date1"/>
                            </div>
                    </div>

                        
                
                    
                    <div class="row mb-3">
                          <div class="col-md-12">
                                <label for="dfindings">Findings and Recommendations :</label>
                            <div class="input-group">
                            <textarea type="text" class="form-control" name="dfindings" cols="5" rows="5" id="dfindings"  >{{ $mdc->findings_recommendations }}</textarea>
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
                                  <label for="verifiedby">Verified by :</label>
                                  <div class="custom-control custom-checkbox ml-3" style="display:inline-block;   ">
                                                <input id="verifiedbysigned" name="verifiedbysigned" type="checkbox" value="1" <?php if($mdc->verified_by_signed){ echo "checked";}?> class="custom-control-input">
                                                <label class="custom-control-label" for="verifiedbysigned">Signed</label>
                                  </div>
                              <div class="input-group">
                              <input type="text" class="form-control" name="verifiedby" value="{{ $mdc->verified_by }}" id="verifiedby"  >
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid verified by is required
                                    </div>
                                 
                              </div>   
                            </div>
                      </div>
                      <hr>

                    <div class="row mb-3">
                          <div class="col-md-12">
                                <label for="dshouldbe">Should be data :</label>
                            <div class="input-group">
                            <textarea type="text" class="form-control" name="dshouldbe" cols="5" rows="5" id="dshouldbe"  > {{ $mdc->pre_should_be_data }}</textarea>
                                <div class="invalid-tooltip " style="width: 100%;">
                                    Should be data is required
                                </div>
                            </div>   
                          </div>

                    </div>
 

                      <div class="row mb-3">
                            <div class="col-md-6">
                                  <label for="preverifiedby">Verified by :</label>
                                  <div class="custom-control custom-checkbox ml-3" style="display:inline-block;   ">
                                                <input id="preverifiedbysigned" name="preverifiedbysigned" type="checkbox" value="1" <?php if($mdc->pre_verified_signed){ echo "checked";}?> class="custom-control-input">
                                                <label class="custom-control-label" for="preverifiedbysigned">Signed</label>
                                  </div>
                              <div class="input-group">
                              <input type="text" class="form-control" name="preverifiedby" value="{{ $mdc->pre_verified_by }} " id="preverifiedby"  >
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid verified by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6">
                                <label for="preverifieddate">Date Verified : </label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="text" id="preverifieddate"  name="preverifieddate"  value="{{ $mdc->pre_date_verified }}"  class="form-control" >
                                        <div class="input-group-addon invalid-tooltip ">
                                                Valid date is required.
                                        </div>             
                                    </div>
                        </div>
                      </div>

                      
                    
                      <hr>
                      <div style="background-color:#2c3e50;color:white;" class="py-3 text-center mb-3">
                              <h4>APPROVAL OF THE CORRECTION REQUEST</h4>
                      </div>

                      <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                  <label for="hacrapprovedby">Name of Approver (Department Head) </label>
                                  <div class="custom-control custom-checkbox ml-3" style="display:inline-block;   ">
                                                <input id="hacrapprovedbysigned" name="hacrapprovedbysigned" type="checkbox" value="1" <?php if($mdc->app_head_approver_signed){ echo "checked";}?> class="custom-control-input">
                                                <label class="custom-control-label" for="hacrapprovedbysigned">Signed</label>
                                  </div>
                              <div class="input-group">
                              <input type="text" class="form-control" name="hacrapprovedby" value="{{ $mdc->app_head_approver }} " id="hacrapprovedby"  >
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid verified by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                    <label for="hacrdate">Date : </label>
                                        <div class="input-group date" data-provide="datepicker">
                                        <input type="text" id="hacrdate" name="hacrdate"  value="{{ $mdc->app_head_approver_date }}" class="form-control" >
                                            <div class="input-group-addon invalid-tooltip ">
                                                    Valid date is required.
                                            </div>             
                                        </div>
                                    </div>
                      </div>

                      <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                  <label for="acrapprovedby">Name of Approver :</label>
                                  <div class="custom-control custom-checkbox ml-3" style="display:inline-block;   ">
                                                <input id="acrapprovedbysigned" name="acrapprovedbysigned" type="checkbox" value="1" <?php if($mdc->app_approver_signed){ echo "checked";}?> class="custom-control-input">
                                                <label class="custom-control-label" for="acrapprovedbysigned">Signed</label>
                                  </div>
                              <div class="input-group">
                              <input type="text" class="form-control" name="acrapprovedby" value="{{ $mdc->app_approver }}" id="acrapprovedby"  >
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid verified by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                    <label for="acrdate">Date : </label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <input type="text" id="acrdate" name="acrdate"   value="{{$mdc->app_approver_date }}" class="form-control" >
                                            <div class="input-group-addon invalid-tooltip ">
                                                    Valid date is required.
                                            </div>             
                                        </div>
                                    </div>
                      </div>

                      <hr>
                      <div style="background-color:#2c3e50;color:white;" class="py-3 text-center mb-3">
                              <h4>CORRECTION PROCESSING</h4>
                      </div>

                      <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                  <label for="cprassignedto">Request Assigned To :</label>
                              <div class="input-group">
                              <input type="text" class="form-control" name="cprassignedto" value="{{ $mdc->cp_request_assignedTo }} " id="cprassignedto" >
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid request assigned to is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                    <label for="cprassigneddate">Date Completed :</label>
                                <div class="input-group">
                                        <div class="input-group date" data-provide="datepicker">
                                                <input type="text" id="cprassigneddate" name="cprassigneddate"  value="{{ $mdc->cp_date_completed }}" class="form-control" >
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
                              <input type="text" class="form-control" name="cprreviewedby" value="{{ $mdc->cp_request_reviewedBy }} " id="cprreviewedby">
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid request reviewed by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="cpdatereviewed">Date Reviewed :</label>
                                <div class="input-group">
                                        <div class="input-group date" data-provide="datepicker">
                                                <input type="text" id="cpdatereviewed" name="cpdatereviewed"  value="{{ $mdc->cp_date_reviewed }}" class="form-control" >
                                                <div class="input-group-addon invalid-tooltip ">
                                                        Valid date is required.
                                                </div>             
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
                                                <input id="dcdeployedbysigned" name="dcdeployedbysigned" type="checkbox" value="1" <?php if($mdc->dc_deployed_signed){ echo "checked";}?> class="custom-control-input">
                                                <label class="custom-control-label" for="dcdeployedbysigned">Signed</label>
                                  </div>
                              <div class="input-group">
                              <input type="text" class="form-control" id="dcdeployedby" value="{{ $mdc->dc_deployed_by }}" name="dcdeployedby">
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid request reviewed by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dcdeployeddate">Date :</label>
                                <div class="input-group">
                                        <div class="input-group date" data-provide="datepicker">
                                                <input type="text" id="dcdeployeddate" name="dcdeployeddate"  value="{{ $mdc->dc_date_deployed }}" class="form-control" >
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
                                                <input id="dcrreviewedbysigned" name="dcrreviewedbysigned" type="checkbox" value="1" <?php if($mdc->dc_reviewed_signed){ echo "checked";}?> class="custom-control-input">
                                                <label class="custom-control-label" for="dcrreviewedbysigned">Signed</label>
                                  </div>
                              <div class="input-group">
                              <input type="text" class="form-control" name="dcrreviewedby" value="{{ $mdc->dc_reviewed_by }}" id="dcrreviewedby">
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid request reviewed by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dcrdate">Date :</label>
                                <div class="input-group">
                                        <div class="input-group date" data-provide="datepicker">
                                                <input type="text" id="dcrdate" name="dcrdate"  value="{{ $mdc->dc_date_reviewed }}" class="form-control" >
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
                                                <input id="pcvverifiedbysigned" name="pcvverifiedbysigned" type="checkbox" value="1" <?php if($mdc->post_verified_signed){ echo "checked";}?> class="custom-control-input">
                                                <label class="custom-control-label" for="pcvverifiedbysigned">Signed</label>
                                  </div>
                                <div class="input-group">
                                      <input type="text" class="form-control" name="pcvverifiedby" value="{{$mdc->post_verified_by}}" id="pcvverifiedby"  >
                                      <div class="invalid-tooltip " style="width: 100%;">
                                              Valid verified by is required
                                      </div>
                                   
                                </div>   
                              </div>
  
                              <div class="col-md-12">
                                      <label for="pcvdate">Date : </label>
                                          <div class="input-group date" data-provide="datepicker">
                                                
                                              <input type="text" name="pcvdate" id="pcvdate"   value="{{ $mdc->post_date_verified }}"class="form-control" >
                                             
                                              <div class="input-group-addon invalid-tooltip ">
                                                      Valid date is required.
                                              </div>             
                                          </div>
                                      </div>
                      </div>

 
                    
                    <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit" name="posted" value="0">Save Changes</button>
                <button class="btn btn-danger btn-lg btn-block" type="submit" name="posted" value="1">Post Data Correction</button>
            </form>
        
    </div>
    


@endsection