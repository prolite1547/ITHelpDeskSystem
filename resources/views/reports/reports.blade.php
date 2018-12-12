<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>-- Reports</title>
        
		@include('reports.rheader')
		
    </head>
    <body>  
		
			<div class="" style="">
				<div class="panel">
					<div class="panel-heading">
						
					</div>
					<div class="panel-body">
							<h2>  Issue Reports</h2>
							<div class="tab-base" style="border: 1px solid #c1c1c1;background:#25476a" >
					
									<!--Nav Tabs-->
									<ul class="nav nav-tabs">
										<li class="active">
											<a data-toggle="tab" href="#demo-lft-tab-1">Issues Per Person</a>
										</li>
										<li>
											<a data-toggle="tab" href="#demo-lft-tab-2">Issues Per Category Monthly</a>
										</li>
										<li>
											<a data-toggle="tab" href="#demo-lft-tab-3">Issues Logged vs. Resolved</a>
										</li>
									</ul>

									<div class="tab-content" style="border: 1px solid #c1c1c1;">
											<div id="demo-lft-tab-1" class="tab-pane fade active in">
													<div class="row" style="margin-top:30px;">
															<div class="col-md-4">
																	<div class="form-group" id = "data_5">
																		<label class="control-label">Date range from </label>
																			<div class="input-daterange input-group" id="datepicker">
																			<?php  
																				date_default_timezone_set("Asia/Manila");
																				$currentDate =  date('m/d/Y');
																				$newDate = date("m/d/Y", strtotime($currentDate));
																			
																			?>
																			
																			<input type="text" id = "ippstartDate" class="form-control-sm form-control" name="start" value="<?php echo $newDate ?>"/>
																			<span class="input-group-addon">to</span>
																			<input type="text" id = "ippendDate" class="form-control-sm form-control" name="end" value="<?php echo $newDate ?>" />
																	</div>
																	</div>
															</div>
								
															<div class="col-md-4">
																	<div class="form-group">
																			<label class="control-label">Name</label>
																			<select data-placeholder="Choose User." id="user" name="user" class="filter demo-chosen-select" tabindex="2">
																				@foreach ($users as $user)
																					<option value="{{ $user->id }}"> {{ $user->name }}</option>
																				@endforeach
																				
																			</select>
									
																	</div>
															</div>
															 
														
													</div>

													<div class="row">
															<div class="col-md-12">
																	<div class="form-group">
																		 
																			<button style="float:right;" onclick="getIPPData()" class="btn btn-primary">Generate Report</button>
																	</div>
															</div>
													</div>
													<hr>
													<div class="row" style="margin-top: 50px;">
															<div class="panel">
																	 
																	 
																	
																	 
																	<div class="panel-body">
																		<div id="ticket-logged" class="row" style="margin-bottom:10px;display:none;">
																			<div class="ticketlogged col-md-12">
																				<label class="control-label"><b>No. of Ticket Logged : </b> </label> 
																				<label class="control-label" id="ticket-logs"></label>
																			</div>
																		</div>
																		<div  id = "IPPDATA" class="generated-data">
																			<p class="text-center">click Generate Report to show data . .</p>
																		</div>
																		
																	</div>
															</div>
											
													</div>
												
											</div>

											<div id="demo-lft-tab-2" class="tab-pane fade">
												<div class="row" style="margin-top:30px;">
													
													<div class="col-sm-4">
															<div class="form-group">
																	<label class="control-label">Category</label>
																	<select data-placeholder="Choose Category." id="category" name="category" class="filter demo-chosen-select" tabindex="2">
																		<option value="all">All</option>
																		@foreach ($categories as $category)
																			<option value="{{ $category->id }} "> {{ $category->name }} </option>
																		@endforeach
																		 
																	</select>
							
															</div>
													</div>
													<div class="col-sm-4">
															<?php  
																date_default_timezone_set("Asia/Manila");
																$currentDate =  date('m/Y');
																 
														
															?>
															<label for="datesubmitted">Month </label>
															<div class="input-group date" id="monthPicker" data-provide="datepicker">
																<input type="text" id="month" name="month" value="<?php echo $currentDate;?>" class="form-control">
																<div class="input-group-addon invalid-tooltip ">
																	 
																</div>             
															</div>
														 
														 
													</div>
												</div>
												<div class="row">
														<div class="col-md-12">
																<div class="form-group">
																	 
																		<button style="float:right;" onclick="getIPCData()" class="btn btn-primary">Generate Report</button>
																</div>
														</div>
												</div>
												<hr>
													<div class="row" style="margin-top: 50px;">
															<div class="panel">
																	

																	<div id="IPCDATA" class="panel-body" >
																			<p class="text-center">click Generate Report to show data . .</p>
																	</div>
																</div>
											
													</div>
												 

											</div>
											<div id="demo-lft-tab-3" class="tab-pane fade">
												<div class="row" style="margin-top:30px;">
														<div class="col-md-4">
																<div class="form-group" id = "data_5">
																	<label class="control-label">Date range from </label>
																		<div class="input-daterange input-group" id="datepicker">
																		<?php  
																			date_default_timezone_set("Asia/Manila");
																			$currentDate =  date('m/d/Y');
																			$newDate = date("m/d/Y", strtotime($currentDate));
																		
																		?>
																		
																		<input type="text" id = "ilrstartDate" class="form-control-sm form-control" name="start" value="<?php echo $newDate ?>"/>
																		<span class="input-group-addon">to</span>
																		<input type="text" id = "ilrendDate" class="form-control-sm form-control" name="end" value="<?php echo $newDate ?>" />
																</div>
																</div>
														</div>
													<div class="col-sm-4">
															<div class="form-group">
																	<label class="control-label">Category</label>
																	<select data-placeholder="Choose Category." id="category1" name="category1" class="filter demo-chosen-select" tabindex="2">
																		<option value="all">All</option>
																		@foreach ($categories as $category)
																			<option value="{{ $category->id }} "> {{ $category->name }} </option>
																		@endforeach
																		 
																	</select>
							
															</div>
													</div>
													 
												</div>

												<div class="row">
														<div class="col-md-12">
																<div class="form-group">
																	 
																		<button style="float:right;" onclick="getILRData()" class="btn btn-primary">Generate Report</button>
																</div>
														</div>
												</div>
												<hr>
												<div class="row" style="margin-top: 50px;">
														<div class="panel">
					
																<div class="panel-body" id="ILRDATA" >
																	 <p class="text-center">click Generate Report to show data . .</p>
																</div>
															</div>
										
												</div>
											</div>
									</div>
							</div>
						         
					</div>
				</div>

				 
			</div>
	 
       
            {{-- <script src="{{ asset('js/app_2.js') }}"></script> --}}
			@include('reports.rfooter')
			 
    </body>

   
</html>