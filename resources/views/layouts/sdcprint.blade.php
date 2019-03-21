<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{asset('images/tab-logo.png')}}" type="image/png">
        <title>System Data Correction (SDC{{ $sdc->id }})</title>
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
                     @if ($sdc->status == 0)
                     <a href="{{ route('sdc.edit', ['id'=> $sdc->id ]) }}" class="btn btn-primary action-buttons" style="color:white;">Update Data</a>
                     <a href="{{ route('sdc.destroy', ['id'=> $sdc->id ]) }}" class="btn btn-danger action-buttons mt-1" style="color:white;">Cancel Data Correct</a>
                     @endif
                 </div>
             </div>
             <div class="row">
                 <div class="col-md-12 heading text-center">
                     <span>SYSTEM DATA CORRECTION FORM</span>
                 </div>
             </div>

             <div class="row wborder">
                 <div class="col-md-7 text-center pt-2 ">
                     <span class="note">This form shall be used for system data correction</span><br>
                     <span class="note">This shall be subject to authorization process as defined by the management</span>
                 </div>
                 <div class="col-md-2 text-center">
                     <span class="sdc_label wborder">SDC No.</span>
                 </div>
                 <div class="col-md-3 text-center">
                     <span class="ids">{{$sdc->sdc_no}}</span><br>
                     <span class="hdticketno">HD Ticket No</span><br>
                     <span class="ids">TID{{$sdc->ticket_no}}</span>
                 </div>
             </div>

             <div class="row">
                 <div class="col-md-2 wborder">
                    <span class="labels"> Date Submitted : </span>
                 </div>
                 <div class="col-md-10 wborder">
                    <span class="data">{{ $sdc->date_submitted }}</span>
                 </div>
                     
             </div>
             <div class="row">
                    <div class="col-md-2 wborder">
                       <span class="labels"> Name of Requestor : </span>
                    </div>
                    <div class="col-md-10 wborder">
                            <span class="data"> {{ $sdc->requestor_name}} </span>
                     </div>
                </div>
            <div class="row">
                    <div class="col-md-2 wborder">
                        <span class="labels"> Dept. Supervisor : </span>
                    </div>
                    <div class="col-md-10 wborder">
                        <span class="data">{{ strtoupper($sdc->dept_supervisor) }}   </span>
                    </div>
            </div>
            <div class="row">
                    <div class="col-md-2 wborder">
                        <span class="labels"> Department : </span>
                    </div>
                    <div class="col-md-10 wborder">
                    <span class="data">{{ $sdc->department }}</span>
                    </div>
            </div>
            <div class="row">
                    <div class="col-md-2 wborder">
                        <span class="labels"> Position : </span>
                    </div>
                    <div class="col-md-10 wborder">
                        <span class="data">{{ $sdc->position }}</span>
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
                    <div class="col-md-10 wborder">
                        <span class="data"> {{ $sdc->affected_ss }} </span>
                    </div>
            </div>
            <div class="row">
                    <div class="col-md-2 wborder">
                        <span class="labels"> Terminal Name (for POS) : </span>
                    </div>
                    <div class="col-md-10 wborder">
                        <span class="data"> {{ $sdc->terminal_name }} </span>
                    </div>
            </div>
            @if (isset($sdc->attachments))
                    <div class="row ">
                            <div class="col-md-12 mt-2">
                                <span class="labels">Attachment(s) : </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-1">
                                
                                       
                                        <ol class="labels" style=" ">
                                            @foreach ($sdc->attachments as $attachment)
                                                @if ($attachment->role_id != '5')
                                                    <li class="data"><a href="/storage/sdc_attachments/{{$attachment->original_name}}" download>{{  $attachment->original_name  }}</a></li>
                                                @endif 
                                            @endforeach
                                        </ol>
                                       
                                    
                            </div>
                    </div>
            @endif
            <div class="row">
                    <div class="col-md-12">
                        <span class="labels">Findings and Recommendations : </span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12 fandr">
                            <span class="data">  {!!  nl2br($sdc->findings_recommendations)  !!}</span>
                    </div>
            </div>


            <div class="row">
                    <div class="col-md-12 subheading text-center wborder">
                        <span> Hard Copy for POS</span>
                    </div>
            </div>

            <div class="row">
                    <div class="col-md-2 wborder">
                        <span class="labels"> Last Z Reading : </span>
                    </div>
                    <div class="col-md-2 wborder">
                        <span class="data">{{ $sdc->hc_last_z_reading }}  </span>
                    </div>
                    <div class="col-md-2 wborder">
                            <span class="labels"> Last DCR : </span>
                    </div>
                    <div class="col-md-2 wborder">
                        <span class="data"> {{ $sdc->hc_last_dcr }} </span>
                    </div>
                    <div class="col-md-2 wborder">
                            <span class="labels"> Last Transaction ID : </span>
                    </div>
                    <div class="col-md-2 wborder">
                        <span class="data"> {{ $sdc->hc_last_transaction_id }} </span>
                    </div>
            </div>
            <div class="row">
                    <div class="col-md-2 wborder">
                        <span class="labels"> Last Accumulator : </span>
                    </div>
                    <div class="col-md-4 wborder">
                          <span class="data <?php if($sdc->hc_last_accumulator){ echo "wborder"; }?>"> Tally </span>&nbsp; &nbsp;
                          <span class="data <?php if($sdc->hc_last_accumulator == "0"){ echo "wborder"; }?>"> Not Tally </span>
                    </div>

                    <div class="col-md-2 wborder">
                            <span class="labels"> Last OR No. : </span>
                        </div>
                        <div class="col-md-4 wborder">
                            <span class="data"> {{$sdc->hc_last_or_no}}  </span>
                    </div>
            </div>


            <div class="row">
                    <div class="col-md-12 subheading text-center wborder">
                        <span> Soft Copy for POS</span>
                    </div>
            </div>
            <div class="row">
                    <div class="col-md-2 wborder">
                        <span class="labels"> Last Z Reading : </span>
                    </div>
                    <div class="col-md-4 wborder">
                        <span class="data"> {{ $sdc->sc_last_z_reading }}  </span>
                    </div>
                   
                    <div class="col-md-2 wborder">
                            <span class="labels"> Last Transaction ID : </span>
                    </div>
                    <div class="col-md-4 wborder">
                        <span class="data"> {{ $sdc->sc_last_transaction_id }}  </span>
                    </div>
            </div>
            <div class="row">
                    <div class="col-md-2 wborder">
                        <span class="labels"> Last Accumulator : </span>
                    </div>
                    <div class="col-md-4 wborder">
                            <span class="data <?php if($sdc->sc_last_accumulator){ echo "wborder"; }?>"> Tally </span>&nbsp; &nbsp;
                            <span class="data <?php if($sdc->sc_last_accumulator == "0"){ echo "wborder"; }?>"> Not Tally </span>
                    </div>

                    <div class="col-md-2 wborder">
                            <span class="labels"> Last OR No. : </span>
                        </div>
                        <div class="col-md-4 wborder">
                        <span class="data">{{ $sdc->sc_last_or_no }}</span>
                    </div>
            </div>


            <div class="row">
                    <div class="col-md-12 heading text-center">
                        <span>Pre-Correction Verification</span>
                    </div>
            </div>

            <div class="row">
                <div class="col-md-2 wborder">
                    <span class="labels">Next Z Reading No.:</span>
                </div>
                <div class="col-md-2 wborder">
                <span class="data">{{ $sdc->pre_next_z_reading }}</span>
                </div>
                <div class="col-md-2 wborder">
                        <span class="labels">Next OR No.:</span>
                    </div>
                    <div class="col-md-2 wborder">
                            <span class="data"> {{ $sdc->pre_next_or_no }} </span>
                </div>
                <div class="col-md-2 wborder">
                        <span class="labels">Last Transaction ID :</span>
                    </div>
                    <div class="col-md-2 wborder">
                    <span class="data"> {{ $sdc->pre_last_transaction_id  }}</span>
                </div>
            </div>

            <div class="row">
                    <div class="col-md-3 wborder">
                        <span class="labels">Last Accumulator :</span>
                    </div>
                    <div class="col-md-3 wborder">
                            <span class="data"> {{ $sdc->pre_last_acc }} </span>
                    </div>
                     
                    <div class="col-md-3 wborder">
                            <span class="labels">Last OR No.:</span>
                    </div>
                    <div class="col-md-3 wborder">
                            <span class="data">{{ $sdc->pre_last_or_no }} </span>
                    </div>
            </div>

            @if (isset($sdc->attachments))
            <div class="row ">
                    <div class="col-md-12 mt-2">
                        <span class="labels">Additional Attachment(s) : </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-1">
                        
                               
                                <ol class="labels" style=" ">
                                    @foreach ($sdc->attachments as $attachment)
                                        @if ($attachment->role_id == '5')
                                            <li class="data"><a href="/storage/sdc_attachments/{{$attachment->original_name}}" download>{{  $attachment->original_name  }}</a></li>
                                        @endif 
                                    @endforeach
                                </ol>
                               
                            
                    </div>
            </div>
     
        @endif
            <div class="row">
                    <div class="col-md-2 wborder">
                        <span class="labels">Checked By :</span>
                    </div>
                    <div class="col-md-4  wborder">
                            <span class="data">  <?php echo strtoupper($sdc->ty1_fullname); ?> </span>
                    </div>
                    <div class="col-md-2 wborder">
                        <span class="labels">Date Checked :</span>
                    </div>
                    <div class="col-md-4  wborder">
                            <span class="data">  <?php echo  $sdc->ty1_date_verified; ?> </span>
                    </div>
                   
            </div>

            <div class="row">
                    <div class="col-md-4 wborder pt-2">
                        <span class="labels">Verified By : </span>
                    </div>
                    <div class="col-md-8 wborder text-center pt-2  row-height">
                    <div class="mt-2 wunderline">
                        <span class="data"> {{ strtoupper($sdc->pre_verified_by) }}</span>
                    @if ($sdc->pre_verified_signed)
                        <span class="signed"> [Signed]</span>
                    @endif
                    </div>
                        <span class="labels2">Signature over printed name</span>
                        
                    </div>
                </div>
    
            <div class="row ">
                    <div class="col-md-4 wborder">
                        <span class="labels"> Date : </span>
                    </div>
                    <div class="col-md-8 wborder data text-center" style="display:block;height:25px;">
                            {{ $sdc->pre_date_verified }}
                    </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <span class="labels">REMARKS : </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 remarks">
                        <span class="data"> 
                            {!! nl2br($sdc->ty2_remarks) !!}
                        </span>
                </div>
            </div>

    @if (isset($sdc->accumulators->id))
         <div class="row">
            <div class="col-md-12 heading text-center">
                <span>Accumulators</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 wborder">
                <span class="labels">Trans. Reset Count :</span>
            </div>
            <div class="col-md-4 wborder">
                    <span class="data"> {{ $sdc->accumulators->trans_reset_count }} </span>
            </div>
             
            <div class="col-md-2 wborder">
                    <span class="labels">OR Reset Count :</span>
            </div>
            <div class="col-md-4 wborder">
                    <span class="data">{{ $sdc->accumulators->or_reset_count }} </span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 heading">
                <span class="labels">ACCUM. NET SALES</span>
            </div>
           
            <div class="col-md-4 heading">
                <span class="labels">ACCUM. NET RETURNS</span>
            </div>

            <div class="col-md-4 heading">
                <span class="labels">ACCUM. NET SALES AFTER RETURNS</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 wborder">
                <span class="labels">Accum. VAT Sales : </span>
            </div>
            <div class="col-md-2 wunderline ">
                <span class="data">{{ $sdc->accumulators->vat_sales }}</span>
            </div>
            <div class="col-md-2 wborder">
                <span class="labels">Accum. VAT Returns : </span>
            </div>
            <div class="col-md-2 wunderline ">
                <span class="data">{{ $sdc->accumulators->vat_sales }}</span>
            </div>
            <div class="col-md-2 wborder">
                <span class="labels">Accum. VAT : </span>
            </div>
            <div class="col-md-2 wunderline ">
                <span class="data">{{ $sdc->accumulators->vat }}</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 wborder">
                <span class="labels">Accum. Non VAT Sales : </span>
            </div>
            <div class="col-md-2 wunderline ">
                <span class="data">{{ $sdc->accumulators->non_vat_sales }}</span>
            </div>
            <div class="col-md-2 wborder">
                <span class="labels">Accum. Non VAT Returns : </span>
            </div>
            <div class="col-md-2 wunderline ">
                <span class="data">{{ $sdc->accumulators->non_vat_ret }}</span>
            </div>
            <div class="col-md-2 wborder">
                <span class="labels">Accum. Non VAT : </span>
            </div>
            <div class="col-md-2 wunderline ">
                <span class="data">{{ $sdc->accumulators->non_vat }}</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 wborder">
                <span class="labels">Accum. Zero Rated Sales : </span>
            </div>
            <div class="col-md-2 wunderline ">
                <span class="data">{{ $sdc->accumulators->z_rated_sales }}</span>
            </div>
            <div class="col-md-2 wborder">
                <span class="labels">Accum. Zero Rated Returns : </span>
            </div>
            <div class="col-md-2 wunderline ">
                <span class="data">{{ $sdc->accumulators->z_rated_ret }}</span>
            </div>
            <div class="col-md-2 wborder">
                <span class="labels">Accum. Zero Rated : </span>
            </div>
            <div class="col-md-2 wunderline ">
                <span class="data">{{ $sdc->accumulators->z_rated }}</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 wborder">
                <span class="labels">Accum. VAT Amount : </span>
            </div>
            <div class="col-md-2 wunderline ">
                <span class="data">{{ $sdc->accumulators->vat_amount1 }}</span>
            </div>
            <div class="col-md-2 wborder">
                <span class="labels">Accum. VAT Amount : </span>
            </div>
            <div class="col-md-2 wunderline ">
                <span class="data">{{ $sdc->accumulators->vat_amount2 }}</span>
            </div>
            <div class="col-md-2 wborder">
                <span class="labels">Accum. VAT Amount : </span>
            </div>
            <div class="col-md-2 wunderline ">
                <span class="data">{{ $sdc->accumulators->vat_amount3 }}</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 wborder">
                <span class="labels">Accum. VAT Exempt Amt : </span>
            </div>
            <div class="col-md-2 dashedBorder ">
                <span class="data">{{ $sdc->accumulators->vat_exempt_amount1 }}</span>
            </div>
            <div class="col-md-2 wborder">
                <span class="labels">Accum. VAT Exempt Amt : </span>
            </div>
            <div class="col-md-2 dashedBorder ">
                <span class="data">{{ $sdc->accumulators->vat_exempt_amount2 }}</span>
            </div>
            <div class="col-md-2 wborder">
                <span class="labels">Accum. VAT Exempt Amt : </span>
            </div>
            <div class="col-md-2 dashedBorder ">
                <span class="data">{{ $sdc->accumulators->vat_exempt_3 }}</span>
            </div>
        </div>


        <div class="row">
            <div class="col-md-2  ">
                {{-- <span class="labels">Total Net Sales : </span> --}}
            </div>
            <div class="col-md-2   ">
                <span class="labels">{{ $sdc->accumulators->total_net_sales }}</span>
            </div>
            <div class="col-md-2  ">
                {{-- <span class="labels">Total Net Returns : </span> --}}
            </div>
            <div class="col-md-2   ">
                <span class="labels">{{ $sdc->accumulators->total_net_returns }}</span>
            </div>
            <div class="col-md-2  ">
                {{-- <span class="labels">Total Net Sales After Returns : </span> --}}
            </div>
            <div class="col-md-2   ">
                <span class="labels">{{ $sdc->accumulators->total_after_returns }}</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 wborder">
                <span class="labels">First Transaction :</span>
            </div>
            <div class="col-md-4 wborder">
                    <span class="data"> {{ $sdc->accumulators->first_trx }} </span>
            </div>
             
            <div class="col-md-2 wborder">
                    <span class="labels">Last Transaction :</span>
            </div>
            <div class="col-md-4 wborder">
                    <span class="data">{{ $sdc->accumulators->last_trx }} </span>
            </div>
        </div>

        
        
        
        <div class="row">
            <div class="col-md-2 wborder">
                    <span class="labels">Transaction Count :</span>
            </div>
            <div class="col-md-4 wborder">
                    <span class="data"> {{ $sdc->accumulators->trx_count }} </span>
            </div>
            <div class="col-md-2 wborder">
                <span class="labels">Previous Reading :</span>
            </div>
            <div class="col-md-4 wborder">
                    <span class="data"> {{ $sdc->accumulators->prev_reading }} </span>
            </div>
             
           
        </div>

        <div class="row">
        
            <div class="col-md-2 wborder">
                    <span class="labels">Current Reading :</span>
            </div>
            <div class="col-md-10 wborder">
                    <span class="data">{{ $sdc->accumulators->curr_reading }} </span>
            </div>
                
        </div>

@endif



        <div class="row">
            <div class="col-md-12 heading text-center">
                <span>Pre-Correction Verification</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 wborder pt-2">
                <span class="labels"> Accumulator Verified By : </span>
            </div>
            <div class="col-md-8 wborder text-center pt-2  row-height">
               

                <div class="mt-2 wunderline">
                    <span class="data"> {{ strtoupper($sdc->pre_acc_verified_by) }} </span>
                     {{-- @if (isset($sdc->pre_acc_verified_by))
                        <span class="signed"> [Signed]</span>
                     @endif --}}
                </div>
                <span class="labels2">Signature over printed name</span>
                
            </div>
        </div>

        <div class="row ">
                <div class="col-md-4 wborder">
                    <span class="labels"> Date : </span>
                </div>
                <div class="col-md-8 wborder data text-center" style="display:block;height:25px;">
                        {{ $sdc->pre_acc_verified_date }}
                </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <span class="labels">REMARKS : </span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 remarks">
                    <span class="data"> {!! nl2br($sdc->govcomp_remarks) !!}</span>
            </div>
    </div>

            <div class="row">
                    <div class="col-md-12 heading text-center">
                        <span>Approval of the Change Request</span>
                    </div>
            </div>

            <div class="row">
                    <div class="col-md-4 wborder pt-2">
                        <span class="labels">Approved By : </span>
                    </div>
                    <div class="col-md-8 wborder text-center pt-2  row-height">
                    <div class="mt-2 wunderline">
                        <span class="data"> {{ strtoupper($sdc->app_approved_by) }} </span>
                        {{-- @if (isset($sdc->app_approved_by))
                          <span class="signed"> [Signed]</span>
                        @endif --}}
                    </div>
                        <span class="labels2">Signature over printed name</span>
                        
                    </div>
                </div>

                <div class="row ">
                    <div class="col-md-4 wborder">
                        <span class="labels"> Date : </span>
                    </div>
                    <div class="col-md-8 wborder data text-center" style="display:block;height:25px;">
                            {{ $sdc->app_date_approved }}
                    </div>
            </div>
                <div class="row">
                    <div class="col-md-12">
                        <span class="labels">REMARKS : </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 remarks">
                            <span class="data"> 
                                {!! nl2br($sdc->app_remarks) !!}
                            </span>
                    </div>
                </div>
            

            
            <div class="row">
                    <div class="col-md-12 heading text-center">
                        <span>Change Processing</span>
                    </div>
            </div>

            <div class="row">
                <div class="col-md-3 wborder">
                    <span class="labels"> Request Assigned To : </span>
                </div>
                <div class="col-md-3 wborder">
                     <span class="data"> {{ strtoupper($sdc->cp_request_assigned_to) }}</span>
                    
                </div>
                <div class="col-md-3 wborder">
                        <span class="labels"> Date Completed : </span>
                    </div>
                    <div class="col-md-3 wborder">
                            <span class="data"> {{ $sdc->cp_date_completed }} </span>
                    </div>
            </div>
            <div class="row">
                    <div class="col-md-3 wborder">
                        <span class="labels"> Request Reviewed By : </span>
                    </div>
                    <div class="col-md-3 wborder">
                    <span class="data"> {{ strtoupper($sdc->cp_request_reviewed_by) }}</span>
                    </div>
                    <div class="col-md-3 wborder">
                            <span class="labels"> Date Reviewed : </span>
                        </div>
                        <div class="col-md-3 wborder">
                        <span class="data">{{ $sdc->cp_date_reviewed }}</span>
                        </div>
            </div>
            
            <div class="row">
                    <div class="col-md-12">
                        <span class="labels">Table and Fields Affected : </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 fandr">
                            <span class="data">{!! nl2br($sdc->cp_table_fields_affected) !!}</span>
                    </div>
                </div>
            

            <div class="row">
                    <div class="col-md-12 heading text-center">
                        <span>Deployment Confirmation</span>
                    </div>
            </div>
           
            <div class="row wborder">
                    <div class="col-md-2  pt-2">
                        <span class="labels">Deployed By : </span>
                    </div>
                    <div class="col-md-4  text-center pt-2  row-height">
                        <div class="mt-2 wunderline-2">
                            <span class="data"> {{ strtoupper($sdc->dc_deployed_by) }}  </span>
                            @if ($sdc->dc_deployed_signed)
                              <span class="signed"> [Signed]</span>
                            @endif
                        </div>
                        <span class="labels2">Signature over printed name</span>
                        
                    </div>

                    <div class="col-md-2  pt-2">
                            <span class="labels">Reviewed By : </span>
                    </div>
                    <div class="col-md-4  text-center pt-2  row-height">
                    <div class="mt-2 wunderline-2">
                        <span class="data"> {{ strtoupper($sdc->dc_reviewed_by) }} </span>
                        @if ($sdc->dc_reviewed_signed)
                            <span class="signed"> [Signed]</span>
                        @endif
                    </div>
                        <span class="labels2">Signature over printed name</span>
                        
                    </div>
            </div>

            <div class="row ">
                    <div class="col-md-2 ">
                        <span class="labels"> Date : </span>
                    </div>
                    <div class="col-md-4 data text-center" style="display:block;height:25px;">
                            {{ $sdc->dc_date_deployed }}
                    </div>
                    <div class="col-md-2">
                            <span class="labels"> Date : </span>
                        </div>
                    <div class="col-md-4 data text-center" style="display:block;height:25px;">
                            {{ $sdc->dc_date_reviewed }}
                    </div>
            </div>

            <div class="row">
                    <div class="col-md-12 heading text-center">
                        <span>Post-Correction Verification</span>
                    </div>
            </div>

            <div class="row">
                    <div class="col-md-4 wborder pt-2">
                        <span class="labels">Verified By : </span>
                    </div>
                    <div class="col-md-8 wborder text-center pt-2  row-height">
                        <div class="mt-2 wunderline">
                            <span class="data"> {{ strtoupper($sdc->post_verified_by) }} </span>
                            @if ($sdc->post_verified_signed)
                                <span class="signed"> [Signed]</span>
                            @endif
                        </div>
                        <span class="labels2">Signature over printed name</span>
                        
                    </div>
                </div>
    
            <div class="row ">
                    <div class="col-md-4 wborder">
                        <span class="labels"> Date : </span>
                    </div>
                    <div class="col-md-8 wborder data text-center" style="display:block;height:25px;">
                            {{ $sdc->post_date_verified }}
                    </div>
            </div>



        </div>
        <script>
            // window.print();
             
        </script>
    </body>
</html>