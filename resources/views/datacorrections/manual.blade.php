@extends('datacorrections.index')
@section('title', 'Manual Data Correction')
@section('content')

<div class="form-group" style="padding:30px;">
<form class="needs-validation" action="{{ route('mdc.store') }}"  method="post" novalidate>
   
{{ csrf_field() }}
 
    <div class="sdc-header" >
            <div  class="py-3 text-center mb-4">
                    <h2>MANUAL DATA CORRECTION FORM</h2>
            </div>
            <hr>
            <div  class="row text-center">
                <div class="col-md-6">
                    <span><strong>TICKET NO : </strong></span>
                <span id="tickerno">TID{{ $ticket->id  }}</span>
                <input type="hidden" name="ticketno" value="{{ $ticket->id }}">
                </div>
                <div class="col-md-6">
                        <span><strong>MDC NO :</strong> </span>
                       
                        <span id="mdcno"> 
                                @if ($mdc != null)
                                MDC{{  $mdc->id+=1 }}
                                @else
                                MDC1
                                @endif
                        </span>

                        <input type="hidden"  name="mdcno" value="<?php 
                                if($mdc != null){
                                        echo "MDC".$mdc->id;
                                }else{
                                        echo "MDC1";
                                }
                        ?>">
                </div> 
            </div>
        
    </div>
    <hr>


                    <div class="row">
                      <div class="col-md-4 mb-3">
                        <label for="datesubmitted">Date Submitted : </label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" id="datesubmitted" name="datesubmitted" class="form-control" required>
                                <div class="input-group-addon invalid-tooltip ">
                                        Valid date is required.
                                </div>             
                            </div>
                        </div>

                      <div class="col-md-8  mb-3">
                            <label for="requestor">Name of Requestor : </label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="requestor" id="requestor" required>
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
                                        <option value="">Choose...</option>
                                        @foreach ($departments as $department)
                                         <option  data-id="{{ $department->id }}" value="{{ $department->department }}"> {{ $department->department }} </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-tooltip ">
                                        Please select a valid department.
                                    </div>
                            </div>

                        <div class="col-md-6 mb-3">
                                <label for="position">Position : </label>
                                <select class="custom-select d-block w-100" name="position" id="position"  required>
                                        <option value="">Choose...</option> 
                                        {{-- @foreach ($positions  as $position)
                                                <option value="{{ $position->position }}">{{ $position->position }}</option>
                                        @endforeach --}}
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
                                        <input type="text" class="form-control" name="affected" id="affected" >
                                        <div class="invalid-tooltip " style="width: 100%;">
                                            Valid affected store/server is required
                                        </div>
                                    </div>   
                            </div>

                            <div class="col-md-6">
                                    <label for="affecteddate">Affected Date : </label>
                                    <input type="text" id = "affecteddate" name="affecteddate"  class="form-control date1"/>
                            </div>
                    </div>

                        
                
                    
                    <div class="row mb-3">
                          <div class="col-md-12">
                                <label for="dfindings">Findings and Recommendations :</label>
                            <div class="input-group">
                                <textarea type="text" class="form-control" name="dfindings" cols="5" rows="5" id="dfindings"  ></textarea>
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
                              <div class="input-group">
                                    <input type="text" class="form-control" name="verifiedby" id="verifiedby"  >
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
                                <textarea type="text" class="form-control" name="dshouldbe" cols="5" rows="5" id="dshouldbe"  ></textarea>
                                <div class="invalid-tooltip " style="width: 100%;">
                                    Should be data is required
                                </div>
                            </div>   
                          </div>

                    </div>
 

                      <div class="row mb-3">
                            <div class="col-md-6">
                                  <label for="preverifiedby">Verified by :</label>
                              <div class="input-group">
                                    <input type="text" class="form-control" name="preverifiedby" id="preverifiedby"  >
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid verified by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6">
                                <label for="preverifieddate">Date Verified : </label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="text" id="preverifieddate"  name="preverifieddate" class="form-control" >
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
                              <div class="input-group">
                                    <input type="text" class="form-control" name="hacrapprovedby" id="hacrapprovedby"  >
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid verified by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                    <label for="hacrdate">Date : </label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <input type="text" id="hacrdate" name="hacrdate" class="form-control" >
                                            <div class="input-group-addon invalid-tooltip ">
                                                    Valid date is required.
                                            </div>             
                                        </div>
                                    </div>
                      </div>

                      <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                  <label for="acrapprovedby">Name of Approver :</label>
                              <div class="input-group">
                                    <input type="text" class="form-control" name="acrapprovedby" id="acrapprovedby"  >
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid verified by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                    <label for="acrdate">Date : </label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <input type="text" id="acrdate" name="acrdate" class="form-control" >
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
                                    <input type="text" class="form-control" name="cprassignedto" id="cprassignedto" >
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid request assigned to is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                    <label for="cprassigneddate">Date Completed :</label>
                                <div class="input-group">
                                        <div class="input-group date" data-provide="datepicker">
                                                <input type="text" id="cprassigneddate" name="cprassigneddate" class="form-control" >
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
                                    <input type="text" class="form-control" name="cprreviewedby" id="cprreviewedby">
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid request reviewed by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="cpdatereviewed">Date Reviewed :</label>
                                <div class="input-group">
                                        <div class="input-group date" data-provide="datepicker">
                                                <input type="text" id="cpdatereviewed" name="cpdatereviewed" class="form-control" >
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
                              <div class="input-group">
                                    <input type="text" class="form-control" id="dcdeployedby" name="dcdeployedby">
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid request reviewed by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dcdeployeddate">Date :</label>
                                <div class="input-group">
                                        <div class="input-group date" data-provide="datepicker">
                                                <input type="text" id="dcdeployeddate" name="dcdeployeddate" class="form-control" >
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
                              <div class="input-group">
                                    <input type="text" class="form-control" name="dcrreviewedby" id="dcrreviewedby">
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid request reviewed by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dcrdate">Date :</label>
                                <div class="input-group">
                                        <div class="input-group date" data-provide="datepicker">
                                                <input type="text" id="dcrdate" name="dcrdate" class="form-control" >
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
                            <div class="col-md-12">
                                <label for="pcvverifiedby">Verified by :</label>
                                <div class="input-group">
                                      <input type="text" class="form-control" name="pcvverifiedby" id="pcvverifiedby"  >
                                      <div class="invalid-tooltip " style="width: 100%;">
                                              Valid verified by is required
                                      </div>
                                   
                                </div>   
                              </div>
  
                              <div class="col-md-12">
                                      <label for="pcvdate">Date : </label>
                                          <div class="input-group date" data-provide="datepicker">
                                                
                                              <input type="text" name="pcvdate" id="pcvdate" class="form-control" >
                                             
                                              <div class="input-group-addon invalid-tooltip ">
                                                      Valid date is required.
                                              </div>             
                                          </div>
                                      </div>
                      </div>

 
                    
                    <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit" name="posted" value="0">Submit Data</button>
               
            </form>
        
    </div>
    


@endsection