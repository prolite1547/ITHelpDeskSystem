@extends('datacorrections.index')
@section('title','System Data Correction (SDC'.$sdc->id.')')
@section('content')

<?php 
        $role_id = Auth::user()->role_id;
        $status = $sdc->status;

        if( (($role_id === 1 OR $role_id === 2 OR $role_id === 3 OR $role_id === 4) AND ($status != 0 AND $status != 4) ) OR ($role_id === 5 AND $status != 1) OR ($role_id === 6 AND $status != 2) OR ($role_id === 7 AND $status != 3) ){
                echo "<script>location.href=window.history.back()</script>";
        }
?>
<div class="form-group" style="padding:30px;">
<form class="needs-validation" action="{{ route('sdc.update', ['id'=>$sdc->id]) }}" enctype="multipart/form-data" method="post" novalidate>
   
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

                <input type="hidden" name="sdc_id" value="<?php 
                        if(isset($sdc->id)){
                                echo $sdc->id;
                        }else{
                                echo 1;
                        }
                      ?>">
            </div>
        
    </div>
    <hr>

{{-- SUPPORT FILL IN --}}
@if(Auth::user()->role_id === 1 OR Auth::user()->role_id === 2 OR Auth::user()->role_id === 3 OR Auth::user()->role_id === 4 OR Auth::user()->role_id === 7  )
                    <div class="row">
                      <div class="col-md-4 mb-3">
                        <label for="datesubmitted">Date Submitted : </label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" id="datesubmitted" name="datesubmitted" value="{{ $sdc->date_submitted }}" class="form-control input-validate" required @if (Auth::user()->role_id === 7 OR $sdc->status >= 1)
                                 disabled   
                                @endif>
                                <div class="input-group-addon invalid-tooltip ">
                                        Valid date is required.
                                </div>             
                            </div>
                        </div>

                      <div class="col-md-8  mb-3">
                            <label for="requestor">Name of Requestor : </label>
                            <div class="input-group">
                            <input type="text" class="form-control input-validate" name="requestor" value="{{ $sdc->requestor_name }}" id="requestor" required @if (Auth::user()->role_id === 7 OR $sdc->status >= 1 )
                            disabled   
                           @endif>
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
                                <input type="text" class="form-control input-validate" name="supervisor" value="{{ $sdc->dept_supervisor }}" id="supervisor" required @if (Auth::user()->role_id === 7 OR $sdc->status >= 1)
                                disabled   
                               @endif>
                                <div class="invalid-tooltip " style="width: 100%;">
                                    Valid dept. supervisor is required
                                </div>
                            </div>   
                        </div>

                        <div class="col-md-4 mb-3">
                                <label for="department">Department : </label>
                                  <select class="custom-select d-block w-100" name="department" id="department" required @if (Auth::user()->role_id === 7 OR $sdc->status >= 1)
                                                disabled   
                                               @endif>
                                        
                                        @foreach ($departments as $department)
                                               
                                                         <option data-id="{{ $department->id }}" value="{{$department->department}}"  @if ($sdc->department  == $department->department)selected @endif>{{ $department->department }}</option>
                                    
                                               
                                         @endforeach
                                    </select>
                                    <div class="invalid-tooltip ">
                                        Please select a valid department.
                                    </div>
                            </div>

                        <div class="col-md-3 mb-3">
                                <label for="position">Position : </label>
                                <select class="custom-select d-block w-100" name="position" id="position"   required @if (Auth::user()->role_id === 7 OR $sdc->status >= 1)
                                                disabled   
                                               @endif>
                                
                                     
                                </select>
                                <div class="invalid-tooltip">
                                          Valid position is required
                                </div>
                        </div>
                    </div>
                    <hr>
@endif
                    
                    <div style="background-color:#2c3e50;color:white;" class="py-3 text-center mb-3">
                            <h4>DETAILS</h4>
                    </div>

{{-- VISIBLE TO TREASURY USERS AND SUPPORTS --}}
@if (Auth::user()->role_id === 1 OR Auth::user()->role_id === 2 OR Auth::user()->role_id === 3 OR Auth::user()->role_id === 4 OR Auth::user()->role_id === 5 OR Auth::user()->role_id === 6 OR Auth::user()->role_id === 8)
                  
                    <div class="row mb-3">
                            <div class="col-md-6 mb-3 ">
                                    <label for="affected">Affected Store/Server : </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control input-validate" name="affected" value="{{ $sdc->affected_ss }}" id="affected"  
                                        @if (Auth::user()->role_id  != 1 OR Auth::user()->role_id  != 2 OR Auth::user()->role_id  != 3 OR Auth::user()->role_id  != 4)  
                                              @if ($sdc->status > 0)
                                                 disabled 
                                              @endif
                                        @endif>
                                        <div class="invalid-tooltip " style="width: 100%;">
                                            Valid affected store/server is required
                                        </div>
                                    </div>   
                            </div>

                            <div class="col-md-6">
                                    <label for="terminalname">Terminal Name (For POS) : </label>
                                    <div class="input-group">
                                     <input type="text" class="form-control input-validate" name="terminalname" value="{{ $sdc->terminal_name }}" id="terminalname" 
                                     @if (Auth::user()->role_id  != 1 OR Auth::user()->role_id  != 2 OR Auth::user()->role_id  != 3 OR Auth::user()->role_id  != 4 )
                                     @if ($sdc->status > 0)   
                                         disabled
                                     @endif
                                     @endif >
                                        {{-- <div class="invalid-feedback" style="width: 100%;">
                                            Valid affected store/server required
                                        </div> --}}
                                    </div>   
                            </div>
                    </div>
@endif
{{-- END --}}

{{-- ATTACHMENTS HERE (DOWNLOADABLE BY ALL USERS) --}}
@if ($sdc->status == 0)
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
@endif

<div class="row mb-3">
                <div class="col-md-12">
                        <label for="attachments">Attachment(s) :</label>
                        <ul id ="attachments" style="list-style: none;">
                                        <?php $count = 0;?>
                                @foreach ($sdc->attachments as $attachment)
                                        <li  id="<?php echo $count;?>">
                                              
                                                <a href="/storage/sdc_attachments/{{$attachment->original_name}}" download target="_about">{{ $attachment->original_name }}</a>
                                                @if ($sdc->status == 0)
                                                <a data-att_id = "{{ $attachment->id }}" data-name = "{{ $attachment->original_name }}" data-id= "<?php echo $count; ?>"class="btn btn-danger btn-sm mb-1 rmvAttachment" style="color:white;">X</a>
                                                 @endif
                                        </li>
                                        <?php 
                                               $count+=1;
                                        ?>
                                @endforeach
                        </ul>

                        
                </div>
</div>

{{-- END --}}

{{-- VISIBLE TO ALL USERS --}}
                    <div class="row mb-3">
                        <div class="col-md-12">
                              <label for="dfindings">Findings and Recommendations :</label>
                          <div class="input-group">
                              <textarea type="text" class="form-control text-area" name="dfindings" cols="5" rows="5" id="dfindings" 
                              @if (Auth::user()->role_id  != 1 OR Auth::user()->role_id  != 2 OR Auth::user()->role_id  != 3 OR Auth::user()->role_id  != 4 )
                              @if ($sdc->status > 0)   
                                 disabled
                              @endif
                              @endif >{{ $sdc->findings_recommendations }}</textarea>
                              <div class="invalid-tooltip " style="width: 100%;">
                                  Findings and recommendations is required
                              </div>
                          </div>   
                        </div>
                   </div>
{{-- END --}}
{{-- END OF 1ST PART SUPPORT FORM --}}

{{-- FOR TREASURY VISIBLE FORM --}}
@if (Auth::user()->role_id === 5 OR Auth::user()->role_id === 7 OR $sdc->status == 4)
                        <hr>
                            <div style=" color:darkslategray;padding:30px" class="py-3">
                                    <h5><b> - Hard Copy for POS - </b></h5>
                            </div>
                        <hr>
                            <div class="row mb-3">
                                    <div class="col-md-4 mb-3">
                                            <label for="hclastzreading">Last Z Reading : </label>
                                            <div class="input-group">
                                              <input type="text" class="form-control input-validate" name="hclastzreading" value="{{ $sdc->hc_last_z_reading }}" id="hclastzreading"  required @if (Auth::user()->role_id === 7 OR $sdc->status == 4)
                                                  disabled
                                              @endif >
                                                <div class="invalid-tooltip " style="width: 100%;">
                                                    Last Z Reading field is required
                                                </div>
                                            </div>   
                                    </div>
                                    <div class="col-md-4 mb-3">
                                            <label for="hclastdcr">Last DCR : </label>
                                            <div class="input-group">
                                             <input type="text" class="form-control input-validate" name="hclastdcr" value="{{ $sdc->hc_last_dcr }}" id="hclastdcr" @if (Auth::user()->role_id === 7 OR $sdc->status == 4)
                                             disabled
                                            @endif   >
                                                <div class="invalid-tooltip " style="width: 100%;">
                                                   Last DCR
                                                </div>
                                            </div>   
                                    </div>
                                    <div class="col-md-4 mb-3">
                                            <label for="hclasttransactionid">Last Transaction ID : </label>
                                            <div class="input-group">
                                            <input type="text" class="form-control input-validate" name="hclasttransactionid" value="{{ $sdc->hc_last_transaction_id }}" id="hclasttransactionid" required @if (Auth::user()->role_id === 7 OR $sdc->status == 4)
                                            disabled
                                        @endif  >
                                                <div class="invalid-tooltip " style="width: 100%;">
                                                     Last Transaction ID is required
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
                                                                    <input id="tally" name="hctally" type="checkbox" value="1"  <?php if($sdc->hc_last_accumulator){ echo "checked";}?> class="custom-control-input hcchk" @if (Auth::user()->role_id === 7 OR $sdc->status == 4)
                                                                    disabled
                                                                @endif >
                                                                    <label class="custom-control-label" for="tally">Tally</label>
                                                              </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                                <div class="custom-control custom-checkbox">
                                                                        <input id="nottally" name="hctally" value="0" type="checkbox" <?php if($sdc->hc_last_accumulator == "0" ){ echo "checked";}?> class="custom-control-input hcchk" @if (Auth::user()->role_id === 7 OR $sdc->status == 4)
                                                                        disabled
                                                                    @endif >
                                                                        <label class="custom-control-label" for="nottally">Not Tally</label>
                                                                </div>
                                                        </div>
                                                              
                                                    </div>
                                                      
                                         </div>
                                         
                                <div class="col-md-6 mb-3">
                                    <label for="hclastorno">Last OR No. : </label>
                                    <div class="input-group">
                                     <input type="text" class="form-control input-validate" name="hclastorno" value="{{ $sdc->hc_last_or_no }}" id="hclastorno" required @if (Auth::user()->role_id === 7 OR $sdc->status == 4)
                                     disabled
                                 @endif >
                                        <div class="invalid-tooltip " style="width: 100%;">
                                            Last OR No. field is required
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
                                            <input type="text" class="form-control input-validate" name="sclastzreading" value="{{ $sdc->sc_last_z_reading }}" id="sclastzreading" required @if (Auth::user()->role_id === 7 OR $sdc->status == 4)
                                            disabled
                                        @endif  >
                                                <div class="invalid-tooltip " style="width: 100%;">
                                                    Last Z Reading field is required
                                                </div>
                                            </div>   
                                    </div>
                                 
                                    <div class="col-md-6 mb-3">
                                            <label for="sclasttransactionid">Last Transaction ID : </label>
                                            <div class="input-group">
                                            <input type="text" class="form-control input-validate" name="sclasttransactionid" value="{{ $sdc->sc_last_transaction_id }}" id="sclasttransactionid" required @if (Auth::user()->role_id === 7 OR $sdc->status == 4)
                                            disabled
                                        @endif  >
                                                <div class="invalid-tooltip " style="width: 100%;">
                                                    Last Transaction ID field is required
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
                                                                    <input id="sctally" name="sctally" type="checkbox" value="1" <?php if($sdc->sc_last_accumulator){ echo "checked";}?> class="custom-control-input scchk" @if (Auth::user()->role_id === 7 OR $sdc->status == 4)
                                                                    disabled
                                                                @endif >
                                                                    <label class="custom-control-label" for="sctally">Tally</label>
                                                              </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                                <div class="custom-control custom-checkbox">
                                                                        <input id="scnottally" name="sctally" type="checkbox" value="0" <?php if($sdc->sc_last_accumulator == "0"){ echo "checked";}?> class="custom-control-input scchk" @if (Auth::user()->role_id === 7 OR $sdc->status == 4)
                                                                        disabled
                                                                    @endif >
                                                                        <label class="custom-control-label" for="scnottally">Not Tally</label>
                                                                </div>
                                                        </div>
                                                              
                                                    </div>
                                                      
                                         </div>
                                         
                                <div class="col-md-6 mb-3">
                                    <label for="sclastorno">Last OR No. : </label>
                                    <div class="input-group">
                                    <input type="text" class="form-control input-validate" name="sclastorno" value="{{ $sdc->sc_last_or_no }}" id="sclastorno" required  @if (Auth::user()->role_id === 7 OR $sdc->status == 4)
                                    disabled
                                @endif >
                                        <div class="invalid-tooltip " style="width: 100%;">
                                            Last OR No. field is required
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
@if (Auth::user()->role_id === 5 OR Auth::user()->role_id === 6 OR Auth::user()->role_id === 7 OR $sdc->status == 4)
                      <hr>

                      <div class="row mb-3">
                            <div class="col-md-4 mb-3">
                                  <label for="prezreadingno">Next Z Reading No.  :</label>
                              <div class="input-group">
                              <input type="text" class="form-control input-validate" name="prezreadingno" value="{{ $sdc->pre_next_z_reading }}" id="prezreadingno" @if (Auth::user()->role_id != 5) readonly @endif required>
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid Z Reading No. field is required
                                    </div>
                              </div>   
                            </div>

                            <div class="col-md-4 mb-3">
                                    <label for="prenextorno">Next OR No.  :</label>
                                      <div class="input-group">
                                      <input type="text" class="form-control input-validate" name="prenextorno" value="{{ $sdc->pre_next_or_no }}" id="prenextorno" @if (Auth::user()->role_id != 5) readonly @endif required >
                                      <div class="invalid-tooltip " style="width: 100%;">
                                              Next OR No. field is required
                                      </div>
                                </div>   
                              </div>

                              <div class="col-md-4">
                                    <label for="prelasttransactionid">Last Transaction ID :</label>
                                      <div class="input-group">
                                      <input type="text" class="form-control input-validate" name="prelasttransactionid" value="{{ $sdc->pre_last_transaction_id }}" @if (Auth::user()->role_id != 5) readonly @endif id="prelasttransactionid" required >
                                      <div class="invalid-tooltip " style="width: 100%;">
                                                Last Transaction ID field is required
                                      </div>
                                </div>   
                              </div>
                      </div>

                      
                      <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                        <label for="prelastacc">Last Accumulator :</label>
                                        <div class="input-group">
                                        <input type="text" class="form-control input-validate" name="prelastacc" value="{{$sdc->pre_last_acc}}" id="prelastacc" @if (Auth::user()->role_id != 5) readonly @endif  >
                                        <div class="invalid-tooltip " style="width: 100%;">
                                                Valid last accumulator
                                        </div>
                                </div>   
                                </div>

                                <div class="col-md-6">
                                        <label for="prelastorno">Last OR No. :</label>
                                        <div class="input-group">
                                        <input type="text" class="form-control input-validate" name="prelastorno" value="{{$sdc->pre_last_or_no}}" id="prelastorno" @if (Auth::user()->role_id != 5) readonly @endif required >
                                        <div class="invalid-tooltip " style="width: 100%;">
                                                Last OR No. field is required
                                        </div>
                                </div>   
                                </div>
                      </div>
@endif

{{-- END OF VIEW --}}


@if ((Auth::user()->role_id === 6 OR Auth::user()->role_id === 8) AND $sdc->status == 1)
                      <div class="row mb-3">
                            <div class="col-md-12">
                                  <label for="preverifiedby">Verified by :</label>
                                  
                              <div class="input-group">
                                    <input type="text" class="form-control" name="preverifiedby"  value="<?php 
                                        if(isset($sdc->pre_verified_by)){
                                                echo strtoupper($sdc->pre_verified_by);
                                        }else{
                                                echo strtoupper(Auth::user()->full_name );
                                        }   
                                     ?>" id="preverifiedby"  readonly >
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid verified by is required
                                    </div>
                                 
                              </div>   
                            </div>
                      </div>

                    

                                                        
                      <div class="row mb-3">
                            <div class="col-md-12">
                                    <label for="preverifieddate">Date : </label>
                                        
                                           <input type="text" class="form-control" name="preverifieddate"  value="<?php
                                                if(isset($sdc->pre_date_verified)){
                                                        echo $sdc->pre_date_verified;
                                                }else{
                                                        date_default_timezone_set("Asia/Manila");
                                                        $currentDate =  date('m/d/Y');
                                                        $newDate = date("m/d/Y", strtotime($currentDate));    

                                                        echo $newDate;
                                                }
                                            ?>" id="preverifieddate"  readonly >
                                  
                                            <div class="input-group-addon invalid-tooltip ">
                                                    Valid date is required.
                                            </div>             
                                        
                                    </div>
                      </div>
 


@endif
{{-- REMARKS FOR TREASURY --}}
@if (Auth::user()->role_id == 5)
        <div class="row mb-3">
                <div class="col-md-12">
                        <label for="tyremarks">Remarks :</label>
                        <div class="input-group">
                        <textarea type="text" class="form-control text-area" name="ty1remarks" cols="5" rows="5" id="ty1remarks" required @if (Auth::user()->role_id === 7 OR $sdc->status == 4 )
                                disabled
                        @endif>{{ $sdc->ty1_remarks }}</textarea>
                        <div class="invalid-tooltip " style="width: 100%;">
                                        Remarks field is required
                        </div>
                        </div>   
                </div>
        </div>


@elseif(Auth::user()->role_id == 6)
<div class="row mb-3">
                <div class="col-md-12">
                        <label for="tyremarks">Remarks :</label>
                        <div class="input-group">
                        <textarea type="text" class="form-control text-area" name="ty2remarks" cols="5" rows="5" id="ty2remarks" required @if (Auth::user()->role_id === 7 OR $sdc->status == 4 )
                                disabled
                        @endif>{{ $sdc->ty1_remarks }}</textarea>
                        <div class="invalid-tooltip " style="width: 100%;">
                                        Remarks field is required
                        </div>
                        </div>   
                </div>
        </div>

@endif        
{{-- REMARKS END --}}  
 
@if (Auth::user()->role_id == 5 OR Auth::user()->role_id == 6)
<div class="row mb-3">
        <div class="col-md-12">
                <label for="checkedby">Checked by:</label> 
                   
                <div class="input-group">
                <input type="text" class="form-control" name="checkedby" value="<?php 
                      if(isset($sdc->ty1_fullname)){
                              echo strtoupper($sdc->ty1_fullname);
                      }else{
                              echo strtoupper(Auth::user()->full_name);
                      }    
                      ?>" id="checkedby" readonly >
                  
                   
                </div>   
              </div>
</div>
@endif
{{-- TREASURY FORM END  --}}

{{-- FORM VIEW FOR GOV. COMPLIANCE USERS --}}
@if (Auth::user()->role_id === 6 OR Auth::user()->role_id === 7 OR $sdc->status == 4)

        <div class="row mb-3">
                <div class="col-md-12">
                  <label for="preaccumulatorverifiedby">Accumulator verified by :</label> 
                     
                  <div class="input-group">
                  <input type="text" class="form-control" name="preaccumulatorverifiedby" value="<?php 
                        if(isset($sdc->pre_acc_verified_by)){
                                echo strtoupper($sdc->pre_acc_verified_by);
                        }else{
                                echo strtoupper(Auth::user()->full_name);
                        }    
                        ?>" id="preaccumulatorverifiedby" readonly >
                        <div class="invalid-tooltip " style="width: 100%;">
                                Valid accumulator verified by is required
                        </div>
                     
                  </div>   
                </div>
          </div>

          <div class="row mb-3">
                <div class="col-md-12">
                        <label for="predateaccumulator">Date : </label>
                           
                                <input type="text" id="predateaccumulator" name="predateaccumulator" value="<?php 
                                        if(isset($sdc->pre_acc_verified_date)){
                                                echo $sdc->pre_acc_verified_date;
                                        }else{
                                                date_default_timezone_set("Asia/Manila");
                                                        $currentDate =  date('m/d/Y');
                                                        $newDate = date("m/d/Y", strtotime($currentDate));    

                                                        echo $newDate;
                                        }
                                ?>" class="form-control" readonly>
                                <div class="input-group-addon invalid-tooltip ">
                                        Valid date is required.
                                </div>             
                          
                </div>
          </div>
{{-- REMARKS HERE --}}
        <div class="row mb-3">
                <div class="col-md-12">
                        <label for="tyremarks">Remarks :</label>
                        <div class="input-group">
                        <textarea type="text" class="form-control text-area" name="govcompremarks" cols="5" rows="5" id="govcompremarks" required @if (Auth::user()->role_id === 7 OR $sdc->status == 4)
                                        disabled
                                    @endif >{{ $sdc->govcomp_remarks }}</textarea>
                        <div class="invalid-tooltip " style="width: 100%;">
                                 Remarks field is required
                        </div>
                        </div>   
                </div>
        </div>
        
{{-- END --}}
    
@endif

{{-- END OF GOV. COMPLIANCE FORM --}}
{{-- APPROVER FORM --}}
@if (Auth::user()->role_id === 7 OR $sdc->status == 4)
                      <hr>
                      <div style="background-color:#2c3e50;color:white;" class="py-3 text-center mb-3">
                              <h4>APPROVAL OF THE CHANGE REQUEST</h4>
                      </div>

                      <div class="row mb-3">
                            <div class="col-md-12 mb-3">
                                <label for="acrapprovedby">Approved by :</label>
                                 
                              <div class="input-group">
                              <input type="text" class="form-control" name="acrapprovedby" value="<?php
                                       if(isset($sdc->app_approved_by)){
                                            echo $sdc->app_approved_by;    
                                       }else{
                                            echo strtoupper(Auth::user()->full_name);
                                       }
                                ?>" id="acrapprovedby" readonly >
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid verified by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-12">
                                    <label for="acrdate">Date : </label>
                                       
                                            <input type="text" id="acrdate" name="acrdate" value="<?php
                                                if(isset($sdc->app_date_approved)){
                                                        echo $sdc->app_date_approved;
                                                }else{
                                                        date_default_timezone_set("Asia/Manila");
                                                        $currentDate =  date('m/d/Y');
                                                        $newDate = date("m/d/Y", strtotime($currentDate));    

                                                        echo $newDate;  
                                                }
                                            ?>" class="form-control" readonly >
                                            <div class="input-group-addon invalid-tooltip ">
                                                    Valid date is required.
                                            </div>             
                                        
                                    </div>
                      </div>
@endif
{{-- END OF APPROVER FORM --}}

{{-- SUPPORTS VIEWABLE FORM AFTER APPROVER IS DONE --}}
@if(Auth::user()->role_id === 1 OR Auth::user()->role_id === 2 OR Auth::user()->role_id === 3 OR Auth::user()->role_id === 4)
@if ($sdc->status == 4)

                      <hr>
                      <div style="background-color:#2c3e50;color:white;" class="py-3 text-center mb-3">
                              <h4>CHANGE PROCESSING</h4>
                      </div>

                      <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                             <label for="cprassignedto">Request Assigned To :</label> 
                              
                              <div class="input-group">
                              <input type="text" class="form-control input-validate" name="cprassignedto" style="text-transform: uppercase" value="{{ $sdc->cp_request_assigned_to }}" id="cprassignedto" >
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid request assigned to is required
                                    </div>
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                    <label for="cprassigneddate">Date Completed :</label>
                                <div class="input-group">
                                        <div class="input-group date" data-provide="datepicker">
                                        <input type="text" id="cprassigneddate" name="cprassigneddate" value="{{$sdc->cp_date_completed}}" class="form-control input-validate" >
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
                              <input type="text" class="form-control input-validate" name="cprreviewedby" style="text-transform: uppercase" value="{{ $sdc->cp_request_reviewed_by }}" id="cprreviewedby">
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid request reviewed by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="cpdatereviewed">Date Reviewed :</label>
                                <div class="input-group">
                                        <div class="input-group date" data-provide="datepicker">
                                                <input type="text" id="cpdatereviewed" name="cpdatereviewed" value="{{$sdc->cp_date_reviewed}}" class="form-control input-validate" >
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
                            <textarea type="text" class="form-control text-area" cols="5" rows="5" name="tfaffected" id="tfaffected">{{ $sdc->cp_table_fields_affected }}</textarea>
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
                              
                              <div class="input-group">
                              <input type="text" class="form-control input-validate" id="dcdeployedby" style="text-transform: uppercase" value="{{ $sdc->dc_deployed_by }}" name="dcdeployedby">
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid request reviewed by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dcdeployeddate">Date :</label>
                                <div class="input-group">
                                        <div class="input-group date" data-provide="datepicker">
                                                <input type="text" id="dcdeployeddate" name="dcdeployeddate" value="{{$sdc->dc_date_deployed}}" class="form-control input-validate" >
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
                              <input type="text" class="form-control input-validate" name="dcrreviewedby" style="text-transform: uppercase" value="{{ $sdc->dc_reviewed_by }}" id="dcrreviewedby">
                                    <div class="invalid-tooltip " style="width: 100%;">
                                            Valid request reviewed by is required
                                    </div>
                                 
                              </div>   
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dcrdate">Date :</label>
                                <div class="input-group">
                                        <div class="input-group date" data-provide="datepicker">
                                                <input type="text" id="dcrdate" name="dcrdate"  value="{{$sdc->dc_date_reviewed}}" class="form-control input-validate" >
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
                                
                                <div class="input-group">
                                <input type="text" class="form-control input-validate" name="pcvverifiedby"  style="text-transform: uppercase" value="{{ $sdc->post_verified_by }}" id="pcvverifiedby"  >
                                      <div class="invalid-tooltip " style="width: 100%;">
                                              Valid verified by is required
                                      </div>
                                   
                                </div>    
                              </div>
  
                              <div class="col-md-12">
                                      <label for="pcvdate">Date : </label>
                                          <div class="input-group date" data-provide="datepicker">
                                                
                                              <input type="text" name="pcvdate" id="pcvdate"  value="{{$sdc->post_date_verified}}" class="form-control input-validate" >
                                             
                                              <div class="input-group-addon invalid-tooltip ">
                                                      Valid date is required.
                                              </div>             
                                          </div>
                                      </div>
                      </div>
@endif                      
@endif
{{-- END OF FORM --}}

 
               
                <hr class="mb-4">
                @if (Auth::user()->role_id  != 1 OR Auth::user()->role_id  != 2 OR Auth::user()->role_id  != 3 OR Auth::user()->role_id  != 4 )  
                    
                 @if ($sdc->status == 4)
                        <button class="btn btn-danger btn-lg btn-block" value="SUBMIT" name="action" type="submit">Submit Data Correction</button>
                 @elseif($sdc->status == 0)
                       <div class="row">
                                <div class="col-md-12">
                                        <button class="btn btn-primary btn-lg btn-block" value="SAVE" name="action"  type="submit">Save Changes</button>
                                </div>
                      </div>
                 <hr>
                 <div class="row">
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
                @else
                        {{-- <button class="btn btn-danger btn-lg btn-block" value="SUBMIT" name="action" type="submit">Approve Data Correction</button> --}}
                        <div class="row">
                                <div class="col-md-6">
                                    <input class="btn btn-success btn-md btn-block" type="submit" name="action" value="SUBMIT FOR APPROVAL" > 
                                </div>
                                <div class="col-md-6">
                                    <select class="custom-select d-block w-100" name="forwardto" id="forwardto">
                                            <option value="2">Treasury 2</option> 
                                    </select>
                                    <div class="input-group-addon invalid-tooltip">
                                            This field is required
                                    </div>    
                                </div>
                        </div>
                        
                          <hr>
                           <div class="row">
                       
                                <div class="col-md-12">
                                        <input class="btn btn-primary btn-md btn-block" type="submit" name="action" value="REJECT"> 
                                </div>
                                  
                          </div>  
                 @endif
                      
                       
                @else
                        <button class="btn btn-primary btn-lg btn-block" value="SAVE" name="action" type="submit">Save Changes</button>
                        <button class="btn btn-danger btn-lg btn-block" value="POST" name="action" type="submit">Post Data Correction</button>
                @endif 

                <input type="hidden" name="role_id" value="{{ Auth::user()->role_id }}">

             </form>
        
    </div>
    


@endsection