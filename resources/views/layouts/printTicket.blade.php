<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Print Ticket</title>
        <link rel="stylesheet" href="{{ asset('css/app_2.css') }}">
        <link rel="stylesheet" href="{{ asset('css/sdcprint.css') }}">
        
    </head>

    <body>
        <div class="container border-1" style="margin-top: 100px;margin-bottom: 20px;">
           @foreach ($ticket as $tcket)
          
            <div class="row mb-2 mt-2">
                <div class="col-md-12">
                        <img src="{{ asset('logo/cithardware.jpg') }}" alt="" width="60px" height="60px">
                        <span style="font-weight:bold;font-size:20px;">Help Desk Ticketing System</span>
                        <button class="btn btn-danger action-buttons" style="float:right;" onclick="window.print()"> Print Data</button>
                </div>
                 
            </div>
            <div class="row mb-1 mt-3">
                <div class="col-md-12 ticket-header underline">
                     Ticket Information
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-12 ticket-number underline">
                    Ticket # : {{ $tcket->id }}
                </div>
            </div>
            <div class="row mb-1 border-bot">
                    <div class="col-md-6 border-right">
                            <span class="ticket-titles">Subject  </span>
                            <span class="ticket-detail ">{{ $tcket->incident->subject }}</span>
                    </div>
                    <div class="col-md-6">
                            <span class="ticket-titles">Status  </span>
                    <span class="ticket-detail">{{ $tcket->statusRelation->name }}</span>
                    </div>
            </div>
            <div class="row mb-1 border-bot">
                    <div class="col-md-6  border-right">
                            <span class="ticket-titles">Details  </span>
                    <span class="ticket-detail ">{{ $tcket->incident->details }}</span>
                    </div>
                    <div class="col-md-6">
                            <span class="ticket-titles">Priority  </span>
                    <span class="ticket-detail">{{strtolower($tcket->priorityRelation->name)}}</span>
                    </div>
            </div>
            <div class="row mb-1 border-bot">
                    <div class="col-md-6  border-right">
                            <span class="ticket-titles">Contact #  </span>
                    <span class="ticket-detail ">{{ $tcket->incident->call->contact->number }}</span>
                    </div>
                    <div class="col-md-6">
                            <span class="ticket-titles">Type  </span>
                    <span class="ticket-detail"> {{ $tcket->typeRelation->name }}</span>
                    </div>
            </div>
            <div class="row mb-1 border-bot">
                <div class="col-md-6  border-right">
                        <span class="ticket-titles">Caller </span>
                <span class="ticket-detail ">{{ $tcket->incident->call->callerRelation->full_name }}</span>
                </div>
                <div class="col-md-6">
                        <span class="ticket-titles">Assigned To  </span>
                        <span class="ticket-detail">{{ $tcket->assigneeRelation->full_name }} ({{ $tcket->assigneeRelation->role->role }})</span>
                </div>
          </div>

          <div class="row  mb-1 border-bot">
            <div class="col-md-6  border-right">
                    <span class="ticket-titles">Logged Date </span>
            <span class="ticket-detail ">{{ $tcket->created_at }}</span>
            </div>
            <div class="col-md-6">
                    <span class="ticket-titles">Category  </span>
            <span class="ticket-detail">{{ $tcket->incident->categoryRelation->name }} > {{ $tcket->incident->catARelation->name }} > {{ $tcket->incident->catBRelation->name  }}</span>
            </div>
        </div>

        <div class="row mb-1 border-bot ">
            <div class="col-md-6  border-right">
                    <span class="ticket-titles">Logged By </span>
                    <span class="ticket-detail ">{{ $tcket->incident->call->loggedBy->full_name }} ({{ $tcket->incident->call->loggedBy->role->role  }})</span>
            </div>
            <div class="col-md-6">
                    <span class="ticket-titles">Data Correction  </span>
                    <span class="ticket-detail">    
                        @if(isset($tcket->SDC->id))
                                    {{ $tcket->SDC->sdc_no }}
                                    @if($tcket->SDC->posted) (POSTED) @endif
                            
                        @elseif (isset($tcket->MDC->id))
                                    {{ $tcket->MDC->mdc_no }}
                                      @if($tcket->MDC->posted) (POSTED)@endif
                        @endif
                    </span>
            </div>
        </div>

        
        <div class="row  border-bot " style="padding-bottom: 10px;">
            <div class="col-md-6  border-right">
                    <span class="ticket-titles">Expiration Date </span>
            <span class="ticket-detail ">{{ $tcket->expiration }}</span>
            </div>
            <div class="col-md-6">
                    <span class="ticket-titles">Attachments  </span>
                    <span class="ticket-detail">
                            @if(!$tcket->incident->getFiles->isEmpty())
                            @foreach($tcket->incident->getFiles as $file)
                                    {{$file->original_name}} ,
                            @endforeach
                            @else
                                No Attachments
                            @endif

                    </span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12 ticket-header underline">
                Conversations
            </div>
        </div>
           
        @forelse($tcket->ticketMessages as $message)
            <div class="row conversation">
                    <div class="col-md-1">
                            <img src="{{asset("/storage/profpic/".$message->user->profpic->image."")}}" alt="" height="60px" width="60px">
                    </div>
                    <div class="col-md-11 ">
                         <span class="username">
                             {{ $message->user->full_name }}
                         </span>
                         <span class="timestamp">
                             {{ $message->getOriginal('created_at')  }} 
                        </span>
                        <span class="message">
                            "{{ $message->message }}"
                        </span>
                    </div>
            </div>
        @empty
            <span style="display:block;text-align:center;color:#c1c1c1;padding:10px;">No Discussions . .</span>
        @endforelse

       
        
            @endforeach 
        </div>
             
    
    </body>
</html>