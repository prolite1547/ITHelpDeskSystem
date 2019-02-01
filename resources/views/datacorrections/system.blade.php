@extends('datacorrections.index')
@section('title', 'System Data Correction')
@section('content')

<div class="form-group" style="padding:30px;">
<form class="needs-validation" action="{{ route('sdc.store') }}" method="post" enctype="multipart/form-data" novalidate>
   
{{ csrf_field() }}

    <div class="sdc-header" >
            <div  class="py-3 text-center mb-4">
                    <h2>SYSTEM DATA CORRECTION FORM</h2>
            </div>
            <hr>
            <div  class="row text-center">
                <div class="col-md-6">
                    <span><strong>TICKET NO : </strong></span>
                    <span id="ticketno">{{ "TID".$ticket->id }}</span>
                <input type="hidden" name="ticketno" value="{{$ticket->id}}">
                </div>
                <div class="col-md-6">
                        <span><strong>SDC NO :</strong> </span>
                        <span id="sdcno">
                                @if ($sdc != null)
                                SDC{{ $sdc->id+=1 }}
                                @else
                                SDC1
                                @endif
                        </span>
                      <input type="hidden" name="sdcno" value="<?php
                                if($sdc != null){
                                        echo "SDC".$sdc->id;
                                }else{
                                        echo "SDC1";
                                }
                      ?>">
                      <input type="hidden" name="sdc_id" value="<?php 
                        if(isset($sdc->id)){
                                echo $sdc->id;
                        }else{
                                echo 1;
                        }
                      ?>">
                </div> 
            </div>
        
    </div>
    <hr>

{{-- SUPPORT FILL IN --}}
        @if(Auth::user()->role_id === 1 OR Auth::user()->role_id === 2 OR Auth::user()->role_id === 3 OR Auth::user()->role_id === 4 )
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
                        <div class="col-md-5 mb-3">
                            <label for="supervisor">Dept. Supervisor : </label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="supervisor"  id="supervisor" required>
                                <div class="invalid-tooltip " style="width: 100%;">
                                    Valid dept. supervisor is required
                                </div>
                            </div>   
                        </div>

                        <div class="col-md-4 mb-3">
                                <label for="department">Department : </label>
                                    <select class="custom-select d-block w-100" name="department" id="department" required>
                                        <option data-id="0" value="">Choose...</option>
                                         @foreach ($departments  as $department)
                                                <option data-id="{{ $department->id }}" value="{{ $department->department }}">{{ $department->department }}</option>
                                         @endforeach
                                    </select>
                                    <div class="invalid-tooltip ">
                                        Please select a valid department.
                                    </div>
                            </div>

                        <div class="col-md-3 mb-3">
                                <label for="position">Position : </label>
                                <select class="custom-select d-block w-100" name="position" id="position"  required>
                                        <option value="">Choose...</option> 
                                        {{-- @foreach ($positions  as $position)
                                                <option value="{{ $position->position }}">{{ $position->position }}</option>
                                        @endforeach --}}
                                </select>
                                <div class="invalid-tooltip">
                                         Valid position is required
                                </div>
                        </div>
                    </div>
@endif

                    <hr>
                    <div style="background-color:#2c3e50;color:white;" class="py-3 text-center mb-3">
                            <h4>DETAILS</h4>
                    </div>

                    
{{-- VISIBLE TO TREASURY USERS AND SUPPORTS --}}
@if (Auth::user()->role_id === 1 OR Auth::user()->role_id === 2 OR Auth::user()->role_id === 3 OR Auth::user()->role_id === 4 OR Auth::user()->role_id === 5 )

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
                                    <label for="terminalname">Terminal Name (For POS) : </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="terminalname" id="terminalname" >
                                        {{-- <div class="invalid-feedback" style="width: 100%;">
                                            Valid affected store/server required
                                        </div> --}}
                                    </div>   
                            </div>
                    </div>
@endif
{{-- END --}}

{{-- ATTACHMENTS HERE (DOWNLOADABLE BY ALL USERS) --}}

<div class="row mb-3">
                <div class="col-md-12">
                        <label for="upfile">Upload Attachment(s) :</label>
                        <div class="input-group">
                                <input id="upfile" name="upfile[]" type="file" multiple hidden>
                                <label class="btn btn-danger btn-sm" onclick="document.getElementById('upfile').click()">Choose File(s)</label>
                                
                        </div>
                     
                        <ol class="mt-2" id="selectedFiles">

                        </ol>
                </div>
</div>

{{-- END --}}

{{-- VISIBLE TO ALL USERS --}}
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
{{-- END --}}

{{-- END OF 1ST PART SUPPORT FORM --}}


{{-- FOR TREASURY VISIBLE FORM --}}
@if (Auth::user()->role_id === 5)
                        <hr>
                            <div style=" color:darkslategray;padding:30px" class="py-3">
                                    <h5><b> - Hard Copy for POS - </b></h5>
                            </div>
                        <hr>
                            <div class="row mb-3">
                                    <div class="col-md-4 mb-3">
                                            <label for="hclastzreading">Last Z Reading : </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="hclastzreading" id="hclastzreading" required  >
                                                <div class="invalid-tooltip " style="width: 100%;">
                                                    Valid position is required
                                                </div>
                                            </div>   
                                    </div>
                                    <div class="col-md-4 mb-3">
                                            <label for="hclastdcr">Last DCR : </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="hclastdcr" id="hclastdcr"  >
                                                <div class="invalid-tooltip " style="width: 100%;">
                                                    Valid position is required
                                                </div>
                                            </div>   
                                    </div>
                                    <div class="col-md-4 mb-3">
                                            <label for="hclasttransactionid">Last Transaction ID : </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="hclasttransactionid" id="hclasttransactionid"  >
                                                <div class="invalid-tooltip " style="width: 100%;">
                                                    Valid position is required
                                                </div>
                                            </div>   
                                    </div>
                                </div>

                                <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                                <label for="hclastzreading">Last Accumulator : </label>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                             <div class="custom-control custom-checkbox">
                                                                    <input id="tally" name="hctally" type="checkbox" value="1" class="custom-control-input hcchk">
                                                                    <label class="custom-control-label" for="tally">Tally</label>
                                                              </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                                <div class="custom-control custom-checkbox">
                                                                        <input id="nottally" name="hctally" value="0" type="checkbox" class="custom-control-input hcchk">
                                                                        <label class="custom-control-label" for="nottally">Not Tally</label>
                                                                </div>
                                                        </div>
                                                              
                                                    </div>
                                                      
                                         </div>
                                         
                                <div class="col-md-6 mb-3">
                                    <label for="hclastorno">Last OR No. : </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="hclastorno" id="hclastorno" >
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
                                    <div class="col-md-6 mb-3">
                                            <label for="sclastzreading">Last Z Reading : </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="sclastzreading" id="sclastzreading"  >
                                                <div class="invalid-tooltip " style="width: 100%;">
                                                    Valid position is required
                                                </div>
                                            </div>   
                                    </div>
                                 
                                    <div class="col-md-6 mb-3">
                                            <label for="sclasttransactionid">Last Transaction ID : </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="sclasttransactionid" id="sclasttransactionid"  >
                                                <div class="invalid-tooltip " style="width: 100%;">
                                                    Valid position is required
                                                </div>
                                            </div>   
                                    </div>
                                </div>

                                <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                                <label for="sclastzreading">Last Accumulator : </label>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                             <div class="custom-control custom-checkbox">
                                                                    <input id="sctally" name="sctally" type="checkbox" value="1" class="custom-control-input scchk">
                                                                    <label class="custom-control-label" for="sctally">Tally</label>
                                                              </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                                <div class="custom-control custom-checkbox">
                                                                        <input id="scnottally" name="sctally" type="checkbox" value="0" class="custom-control-input scchk">
                                                                        <label class="custom-control-label" for="scnottally">Not Tally</label>
                                                                </div>
                                                        </div>
                                                              
                                                    </div>
                                                      
                                         </div>
                                         
                                <div class="col-md-6 mb-3">
                                    <label for="sclastorno">Last OR No. : </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="sclastorno" id="sclastorno" >
                                        <div class="invalid-tooltip " style="width: 100%;">
                                            
                                        </div>
                                    </div>   
                            
                            </div>
                            </div>

                   

                    <hr>
                    <div style="background-color:#2c3e50;color:white;" class="py-3 text-center mb-3">
                            <h4>PRE-CORRECTION VERIFICATION</h4>
                    </div>
                    
@endif             

{{-- VIEWABLE BY GOV.COMPLIANCE/APPROVER USERS --}}
@if (Auth::user()->role_id === 5 OR Auth::user()->role_id === 6 )
                      <hr>

                      <div class="row mb-3">
                            <div class="col-md-4 mb-3">
                                  <label for="prezreadingno">Next Z Reading No.  :</label>
                              <div class="input-group">
                                    <input type="text" class="form-control" name="prezreadingno" id="prezreadingno"  readonly>
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid Z reading no. is required
                                    </div>
                              </div>   
                            </div>

                            <div class="col-md-4 mb-3">
                                    <label for="prenextorno">Next OR No.  :</label>
                                      <div class="input-group">
                                      <input type="text" class="form-control" name="prenextorno" id="prenextorno"  readonly >
                                      <div class="invalid-tooltip " style="width: 100%;">
                                              Valid OR no. is required
                                      </div>
                                </div>   
                              </div>

                              <div class="col-md-4">
                                    <label for="prelasttransactionid">Last Transaction ID :</label>
                                      <div class="input-group">
                                      <input type="text" class="form-control" name="prelasttransactionid" id="prelasttransactionid" readonly >
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
                                        <input type="text" class="form-control" name="prelastacc" id="prelastacc" readonly >
                                        <div class="invalid-tooltip " style="width: 100%;">
                                                Valid last accumulator
                                        </div>
                                </div>   
                                </div>

                                <div class="col-md-6">
                                        <label for="prelastorno">Last OR No. :</label>
                                        <div class="input-group">
                                        <input type="text" class="form-control" name="prelastorno" id="prelastorno" readonly >
                                        <div class="invalid-tooltip " style="width: 100%;">
                                                Valid last OR no. is required
                                        </div>
                                </div>   
                                </div>
                      </div>
@endif

{{-- END OF VIEW --}}


{{-- FORM VIEW FOR GOV. COMPLIANCE USERS --}}
@if (Auth::user()->role_id === 6)

                        <div class="row mb-3">
                                <div class="col-md-12">
                                <label for="preaccumulatorverifiedby">Accumulator verified by :</label>
                                <div class="input-group">
                                        <input type="text" class="form-control"  name="preaccumulatorverifiedby" id="preaccumulatorverifiedby" readonly >
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
                                                <input type="text" id="predateaccumulator" name="predateaccumulator" class="form-control" readonly >
                                                <div class="input-group-addon invalid-tooltip ">
                                                        Valid date is required.
                                                </div>             
                                        </div>
                                </div>
                        </div>
{{-- REMARKS HERE --}}

{{-- END --}}
    
@endif
{{-- END OF GOV. COMPLIANCE FORM --}}
@if (Auth::user()->role_id === 5)
                      <div class="row mb-3">
                            <div class="col-md-12">
                                  <label for="preverifiedby">Verified by :</label>
                              <div class="input-group">
                                    <input type="text" class="form-control" name="preverifiedby" id="preverifiedby" readonly >
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
                                            <input type="text" id="preverifieddate"  name="preverifieddate" class="form-control" readonly >
                                            <div class="input-group-addon invalid-tooltip ">
                                                    Valid date is required.
                                            </div>             
                                        </div>
                                    </div>
                      </div>

{{-- REMARKS FOR TREASURY --}}

{{-- REMARKS END --}}

@endif
{{-- TREASURY FORM END  --}}

{{-- APPROVER FORM --}}
@if (Auth::user()->role_id === 7)
                      <hr>
                      <div style="background-color:#2c3e50;color:white;" class="py-3 text-center mb-3">
                              <h4>APPROVAL OF THE CHANGE REQUEST</h4>
                      </div>

                      <div class="row mb-3">
                            <div class="col-md-12">
                                  <label for="acrapprovedby">Approved by :</label>
                              <div class="input-group">
                                    <input type="text" class="form-control" name="acrapprovedby" id="acrapprovedby" readonly  >
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid verified by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-12">
                                    <label for="acrdate">Date : </label>
                                        <div class="input-group date" data-provide="datepicker"> 
                                            <input type="text" id="acrdate" name="acrdate" class="form-control" readonly >
                                            <div class="input-group-addon invalid-tooltip ">
                                                    Valid date is required.
                                            </div>             
                                        </div>
                                    </div>
                      </div>
        @endif         
                    <hr class="mb-4">
 
                  <div class="row">
                       
                        <div class="col-md-12">
                                <input class="btn btn-primary btn-md btn-block" type="submit" name="action" value="SAVE"> 
                        </div>
                          
                  </div>
                  <hr>
                     <div class="row  mb-5">
                            <div class="col-md-6">
                                <input class="btn btn-success btn-md btn-block" type="submit" name="action" value="APPROVED & FORWARD" > 
                            </div>
                            <div class="col-md-6">
                                <select class="custom-select d-block w-100" name="forwardto" id="forwardto">
                                        <option value="1">Treasury 1</option> 
                                        <option value="2">Treasury 2</option> 
                                        <option value="3">Gov. Compliance</option>
                                        <option value="4">Final Approver</option> 
                                </select>
                                <div class="input-group-addon invalid-tooltip">
                                        This field is required
                                </div>    
                            </div>
                    </div>
                   
            </form>
            
    </div>
    


@endsection