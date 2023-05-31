use Carbon\Carbon;
@extends('layout.utilization')

@section('content')
<div class="modal fade" id="ChangeStatusModal" tabindex="-1" role="ChangeStatusModal" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<input type="hidden" name="cs_id" id="cs_id">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Change Status for <span id="cs_refcode"></span></h4>
				</div>

				<div class="modal-body"> 
					<select class="form-control" name="cs_status" id="cs_status" required>                             
						<option value="Waiting for Vehicle Availability">Waiting for Vehicle Availability</option>
						<option value="Waiting for Driver Availability">Waiting for Driver Availability</option>
						<option value="On-Hold by Requester">On-Hold by Requester</option>
						<option value="Scheduled">Scheduled</option>
						<option value="In-progress">In-progress</option>
						<option value="Cancelled">Cancelled</option>
					</select>
					<br>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-circle dark btn-outline" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
					<button type="button" onclick="change_status();" class="btn btn-circle blue"><span class="fa fa-check"></span> Update Status</button>
				</div>

			</div>
		</div>
	</div>

	<div class="modal fade bs-modal-lg" id="newrequest" tabindex="-1" role="newrequest" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			<form autocomplete="off" method="post" action="{{ route('vehicle.request.create.destination') }}" id="newrequest_form">
				@csrf
                <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">New Vehicle Request</h4>
				</div>
				<div class="modal-body" style="height:850px">
					<input type="hidden" name="action" value="add">
					<table width="100%">
						<tr valign="middle">                                    
						<td align="center">                                       
							<table width="100%">
								<tr>
									<td>
									<select name="dept_select" id="dept_select" class="form-control" placeholder="Select Dept">
										<option value="">Select Dept</option>										
										@foreach($dept as $key => $item)
										<option value="{{ $item['name'] }}">{{ ($item['name']) }}</option>
                                        @endforeach
									</select>
									</td>
									<td><input type="text" name="dept_input" id="dept_input" class="form-control" placeholder="Or input new dept"></td>
								</tr>
							</table>
							<br>
						</td>                                    
						</tr> 
					</table>  
					<div class="row">
						<div class="portlet box blue col-md-10 col-md-offset-1">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-file-powerpoint-o"></i> Request Details
							</div>                                   
						</div>
						<div class="portlet-body form">
							<div class="form-horizontal" role="form">                           
								<div class="form-body">
									
									<div class="form-group">
										<label class="col-md-4 control-label">Date Needed <i class="font-red">*</i></label>
										<div class="col-md-8">
											<div class="input-group">
												<input type="date" class="form-control" id="datee" name="date_needed" date-format="Y-m-d" />
												{{-- <input name="do" class="form-control" size="16" type="date" value="" required> --}}
												<span class="input-group-btn">
													{{-- <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button> --}}
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label">Chargeable Cost Code <i class="font-red">*</i></label>
										<div class="col-md-8">
											<input type="text" name="costcode" id="costcode" class="form-control" placeholder="Cost Code" required>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label">Purpose/Description of Work <i class="font-red">*</i></label>
										<div class="col-md-8">
											<textarea name="purpose" class="form-control" id="purpose" required></textarea>
										</div>
									</div>
									
								</div>
							</div>                                 
						</div>
						</div>
					</div>                              
					<div class="row">
						<div class="col-md-6">
						<div class="portlet box blue-hoki">
						<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-truck"></i> Delivery Instructions
								</div>                                   
						</div>
						<div class="portlet-body form">
								<div role="form">                           
									<div class="form-body">

									<div class="form-group">
									<input class="form-control" type="text" id="search" placeholder="Search Employee"/>
									  <span><img style="display: none;" id="emp_spinner" class="wd-15p mg-t-1" src="{{ asset('assets/apps/img/spinner/spinner5.gif') }}" height="50" width="150" alt=""></span> 
									  <div id="employee_list"></div>  
									</div>

									<div class="form-group">
									<label class="control-label">Contact Person <i class="font-red">*</i></label>                    
									<input type="text" id="di_contactpersonq" name="di_contactpersonq" class="typeahead form-control input-sm hide" required disabled>   
									<input type="hidden" id="di_contactperson" name="di_contactperson" class="form-control input-sm" disabled> 
									<input type="text" id="fullname" name="fullname" class="form-control input-sm" required>
									</div>									

									<div class="form-group">
									<label class="control-label">Contact No. / Office Tel No. <i class="font-red">*</i></label>                                                
									<input type="text" id="di_contactno" name="di_contactno" class="form-control input-sm" required>                                                
									</div> 

									<div class="form-group hide">
									<label class="control-label">Designation</label>                                                
									<input type="text" id="di_designation" name="di_designation" class="form-control input-sm" disabled readonly>
									<input type="text" id="position" name="position" class="form-control input-sm">
									</div> 
									       
									<div class="form-group hide">
									<label class="control-label">Dept</label>                                                
									<input type="text" id="di_dept" name="di_dept" class="form-control input-sm" readonly disabled>
									<input type="text" id="department" name="department" class="form-control input-sm">
									</div> 									

									<div class="form-group">
									<label class="control-label">Delivery Site</label>      
									<select name="di_deliverysite" id="di_deliverysite" class="form-control input-sm">
										<option value="">-- Select One --</option>
										@foreach($destinations as $destination)
                                            <option value="{{ $destination->name }}">{{ $destination->name }}</option>
                                        @endforeach
									</select>
									<input type="text" id="di_otherd" name="di_otherd" class="form-control input-sm margin-top-10" style="display:none;" placeholder="Enter Other Destination">           
									
									</div>     

									<div class="form-group">
									<label class="control-label">Delivery Instruction</label>  
									<textarea name="di_instruction" id="di_instruction" class="form-control" required="required"></textarea>                                            
									</div>                             

									</div>
								</div>                                 
						</div>
						</div>
						</div>
						<div class="col-md-6">
						<div class="portlet box grey-gallery">
						<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-paper-plane-o"></i> Pickup Instructions
								</div>                                   
						</div>
						<div class="portlet-body form">
								<div role="form">                           
									<div class="form-body">
									<div class="form-group">
										<label class="control-label">Dept / Establishment (for outside of PMC)</label>                                                      
										<input type="text" id="pi_dept" name="pi_dept" class="form-control input-sm" placeholder="">                                                      
									</div>

									<div class="form-group">
										<label class="control-label">Location/Site/Address</label>                                                      
										<input type="text" id="pi_location" name="pi_location" class="form-control input-sm" placeholder="">                                                      
									</div>                                             

									</div>
								</div>                                 
						</div>
						</div>
						</div>
						
					</div>                               
				</div>
				<div class="modal-footer" id="footermode">
					<button type="button" class="btn default" data-dismiss="modal">Cancel</button>
					@if($create)
					<input type="submit" class="btn blue" value="Save" onclick="validate_dept();">
					@else
					<input disabled type="submit" class="btn blue" value="Save" onclick="validate_dept();">
					@endif
				</div>
			</form>
			</div>
		</div>
	</div>

	<div class="modal fade bs-modal-lg" id="editrequest" tabindex="-1" role="editrequest" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			<form method="post" action="{{ route('vehicle.request.update') }}">
                @csrf
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Update Request</h4>
				</div>
				<div class="modal-body" style="height:300px">
					<input type="hidden" name="id_edit" id="id_edit">
					<table width="100%">
						<tr valign="middle">
						<td>                                       
							<table width="100%">
								<tr>
									<td>
									<select name="dept_select_edit" id="dept_select_edit" class="form-control" placeholder="Select Dept">
										<option value="">Select Dept</option>
                                        @foreach($dept as $key => $item)
										<option value="{{ $item['name'] }}">{{ ($item['name']) }}</option>
                                        @endforeach
									</select>
									</td>
									<td><input type="text" name="dept_input_edit" id="dept_input_edit" class="form-control" placeholder="Or input new dept"></td>
								</tr>
							</table>
							<br>
						</td>                                    
						</tr>                                   
					</table>      
					<div class="row">
						<div class="portlet box blue col-md-10 col-md-offset-1">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-file-powerpoint-o"></i> Request Details
							</div>                                   
						</div>
						<div class="portlet-body form">
							<div class="form-horizontal" role="form">                           
								<div class="form-body">
									<div class="form-group">
									<label class="col-md-4 control-label">Date Needed <i class="font-red">*</i></label>
									<div class="col-md-8">
										<div class="input-group date">
											<!-- <input type="date" size="16" readonly class="form-control" name="date_needed_edit" id="date_needed_edit" required> -->
											<input type="date" size="16" class="form-control" id="date_needed_edit" name="date_needed_edit" date-format="Y-m-d" />
											<!-- <span class="input-group-btn"> -->
											<!-- <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button> -->
											</span>
										</div>
									</div>
									</div>
									<div class="form-group">
									<label class="col-md-4 control-label">Chargeable Cost Code <i class="font-red">*</i></label>
									<div class="col-md-8">
										<input type="text" name="costcode_edit" id="costcode_edit" class="form-control" placeholder="Cost Code" required>
									</div>
									</div>
									<div class="form-group">
									<label class="col-md-4 control-label">Purpose/Description of Work <i class="font-red">*</i></label>
									<div class="col-md-8">
										<textarea name="purpose_edit" class="form-control" id="purpose_edit" required></textarea>
									</div>
									</div>
									
								</div>
							</div>                                 
						</div>
						</div>
					</div>                              
					<div class="row">
						<div class="col-md-6">
						<div class="portlet box blue-hoki">
						<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-truck"></i> Delivery Instructions
								</div>                                   
						</div>
						<div class="portlet-body form">
								<div role="form">                           
									<div class="form-body">

									<div class="form-group">
									<input class="form-control" type="text" id="e_search" placeholder="Search Employee"/>
									  <span><img style="display: none;" id="e_emp_spinner" class="wd-15p mg-t-1" src="{{ asset('assets/apps/img/spinner/spinner5.gif') }}" height="50" width="150" alt=""></span> 
									  <div id="e_employee_list"></div>  
									</div>

									<div class="form-group">
									<label class="control-label">Contact Person <i class="font-red">*</i></label>                    
									<input type="hidden" id="di_contactperson_editq" name="di_contactperson_editq" class="form-control input-sm" placeholder="" required>  
									<input type="hidden" id="di_contactperson_edit" name="di_contactperson_edit" class="form-control input-sm" placeholder=""> 
									<input type="text" id="e_fullname" name="e_fullname" class="form-control input-sm" required>                        
									</div>

									<div class="form-group">
									<label class="control-label">Contact No. / Office Tel No. <i class="font-red">*</i></label>                                                
									<input type="text" id="di_contactno_edit" name="di_contactno_edit" class="form-control input-sm" placeholder="" required>                                                
									</div> 

									<div class="form-group">
									<label class="control-label">Designation</label>                                                
									<input type="hidden" id="di_designation_edit" name="di_designation_edit" class="form-control input-sm" placeholder="">
									<input type="text" id="e_position" name="e_position" class="form-control input-sm">                                                
									</div>        

									<div class="form-group">
									<label class="control-label">Dept</label>                                                
									<input type="hidden" id="di_dept_edit" name="di_dept_edit" class="form-control input-sm" placeholder=""> 
									<input type="text" id="e_department" name="e_department" class="form-control input-sm">
									</div> 
								
									<div class="form-group">
									<label class="control-label">Delivery Site</label>      
									<select name="di_deliverysite_edit" id="di_deliverysite_edit" class="form-control input-sm">													
                                        @foreach($destinations as $destination)
                                            <option value="{{ $destination->name }}">{{ $destination->name }}</option>
                                        @endforeach
									</select>
									<input type="text" id="di_otherd_edit" name="di_otherd_edit" class="form-control input-sm margin-top-10" style="display:none;" placeholder="Enter Other Destination">           
									
									</div>  

									<div class="form-group">
									<label class="control-label">Delivery Instruction</label>  
									<textarea name="di_instruction_edit" id="di_instruction_edit" class="form-control" required="required"></textarea>                                            
									</div>                             

									</div>
								</div>                                 
						</div>
						</div>
						</div>
						<div class="col-md-6">
						<div class="portlet box grey-gallery">
						<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-paper-plane-o"></i> Pickup Instructions
								</div>                                   
						</div>
						<div class="portlet-body form">
								<div role="form">                           
									<div class="form-body">
									<div class="form-group">
										<label class="control-label">Dept / Establishment (for outside of PMC)</label>                                                      
										<input type="text" id="pi_dept_edit" name="pi_dept_edit" class="form-control input-sm" placeholder="">                                                      
									</div>

									<div class="form-group">
										<label class="control-label">Location/Site/Address</label>                                                      
										<input type="text" id="pi_location_edit" name="pi_location_edit" class="form-control input-sm" placeholder="">                                                      
									</div>                                             

									</div>
								</div>                                 
						</div>
												
						</div>
						<div>
							<button type="button" class="btn default" data-dismiss="modal">Cancel</button>
							@if($create)
							<input type="submit" class="btn blue" value="Save">
							@else
							<input disabled type="submit" class="btn blue" value="Save">
							@endif
						</div>
						</div>
						
					</div>                           
				</div>
				<div class="modal-footer">
					
					</div>
				</form>
				</div>
			</div>
		</div>
		<div class="page-container">
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
		<div class="page-content">

			<form method="get" act="index.php">
				<div class="row">
					<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
						Request List @if(Auth::user()->role=='requestor')<small>{{ Auth::user()->dept }} </small>@endif                                             
					</h3>                        
					</div>
				</div>
			</form>
    
        <div class="clearfix">
        </div>
        <div class="row margin-bottom-10">
            <div class="col-md-2 pull-left"><span style="font-size:15px;"><input type="checkbox" name="filter" id="filter"> Filter</span></div>
            <div class="col-md-6 text-center">
                Trip Ticket Legend: 
                <span class="label label-primary">New Ticket</span>
                <span class="label label-warning">Ticket Printed</span>
                <span style="background-color:#35aa47;" class="label">Completed</span>
                <span class="label label-danger">Cancelled</span>
            </div>
            <div class="col-md-4 text-right">
                <div>
					@if($create)
						<a class="btn blue btn-sm" href="#" style="margin-left: 10px;" onclick="$('#newrequest').modal('show');">
							<span class="fa fa-plus"></span> Add New
						</a>
					@else
						<button disabled class="btn blue btn-sm" href="#" style="margin-left: 10px;" onclick="$('#newrequest').modal('show');">
							<span class="fa fa-plus"></span> Add New
						</button>
					@endif
                <a class="btn green btn-sm" onclick="exportToExcel('#sample_4')" style="margin-left: 10px;">
                    <span class="fa fa-download"></span> Download List
                </a>                       
                </div> 
            </div>
        </div>  
        <div class="row">                  
            <div class="col-md-12">                     
                <div class="clearfix"></div>
                <table style="font-size:12px;" class="table table-striped table-bordered table-hover js-dynamitable" id="sample_4">
                <thead id="nofilter_head">                                    
                    <tr>
                        <th style="font-size:11px;">Request No. </th>
                        <th style="font-size:11px;">Dept </th>
                        <th style="font-size:11px;">Date Needed </th>
                        <th style="font-size:11px;">Date Requested </th>
                        <th style="font-size:11px;">Purpose</th>
                        <th style="font-size:11px;">Last Message </th>
                        <th style="font-size:11px;">Status </th>
                        <th style="font-size:11px;">Status Changed </th>
                        <th style="font-size:11px;">Trip Ticket </th>
                        <th style="font-size:11px;">Action </th>                                    
                    </tr>                                  
                </thead>
                <thead id="filter_head" style="display:none;">
                    
                    <tr>
                        <th style="font-size:11px;">Request No. <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                        <th style="font-size:11px;">Dept <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                        <th style="font-size:11px;">Date Needed <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                        <th style="font-size:11px;">Date Requested <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                        <th style="font-size:11px;">Purpose <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                        <th style="font-size:11px;">Last Message <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                        <th style="font-size:11px;">Status <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                        <th style="font-size:11px;">Status Changed <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                        <th style="font-size:11px;">Trip Ticket <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                        <th style="font-size:11px;">Action <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>                                    
                    </tr>
                    <tr>
                        <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                        <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                        <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                        <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                        <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                        <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                        <th>                                 
                            <select class="js-filter form-control" style="font-size:12px;">
                            <option value=""></option>
                            <option value="New Request">New Request </option>
                            <option value="Waiting for Vehicle Availability">Waiting for Vehicle Availability</option>
                            <option value="Waiting for Driver Availability">Waiting for Driver Availability</option>
                            <option value="On-Hold by Requester">On-Hold by Requester</option>
                            <option value="In-progress">In-progress</option>
                            <option value="Cancelled">Cancelled</option>
                            <option value="Closed">Closed</option>
                            <option value="">Reset Filter</option>
                            </select>
                        </th>
                        <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                        <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                        <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
						<tr>
							<td style="width:80px;"><a target="_blank" href="{{ route('vehicle.request.get', ['id' => $request->id]) }}" >{{ $request->refcode }}</a></td>
							<td style="width:140px;">{{ $request->dept }}</td>
							<td style="width:140px;">{{ date('Y-m-d',strtotime($request->date_needed)) }}</td> 
							{{-- <td style="width:140px;">{{ $request->date_needed }}</td>  --}}
							{{-- <td style="width:140px;">{{ \Carbon\Carbon::parse($request->date_needed)->format('Y-m-d') }}</td> --}}
							<td style="width:140px;">{{ date('Y-m-d',strtotime($request->addedAt)) }}</td>     
							<td>{{ $request->purpose }}</td>
							<td id="msg_status{{ $request->id }}">{{ isset($request->message) ? $request->message->message: '' }}</td>       
							<td style="color: 
								@if($request->status == 'Cancelled' || $request->status == 'Closed')
									red;
								@endif">
								{{ $request->status }}
							@if($edit)
							<a style="float: right;" href="javascript::void(0)" onclick="edit_status({{ $request->id }},'{{ $request->status }}','{{ $request->refcode }}');" title="Change Status">
									<span class=@if($request->status=='Cancelled' || $request->status=='Closed') @else 'fa fa-pencil' @endif></span>
							</a>
							@else
							<button disabled style="float: right;" href="javascript::void(0)" onclick="edit_status({{ $request->id }},'{{ $request->status }}','{{ $request->refcode }}');" title="Change Status">
									<span class=@if($request->status=='Cancelled' || $request->status=='Closed') @else 'fa fa-pencil' @endif></span>
							</button>
							@endif
							</td>
							<td style="width:140px;" title="last changed by {{ $request->lastStatusChangedBy }}">{{ date('Y-m-d',strtotime($request->lastStatusChanged)) }}</td>
							
							<td>

								@forelse($request->tripTicket as $ticket)
									
									@if($edit)
										@if($ticket->Status == 'Completed')
											<a target="_blank"  href="{{ route('vehicle.request.trip_completed', ['id' => $ticket->tripTicket]) }}" 
												class="btn btn-xs 
													@if($ticket->Status == 'Completed')
														green
													@elseif($ticket->Status == 'Closed' || $ticket->Status == 'Cancelled')
														red
													@else
														@if($ticket->isPrinted == 1)
															yellow
														@else
															blue
														@endif
													@endif 
													popovers" data-container="body" data-trigger="hover" data-html="true" data-placement="top" data-original-title="{{ $ticket->tripTicket }}" 
											data-content="
														<div>Vehicle: {{ $ticket->type }}</div>
														<div>Date Out: {{ date('Y-m-d',strtotime($ticket->dateStart)) }}</div>
														{{-- <div>Date Out: {{ !empty($ticket->dateStart) ? $ticket->dateStart->dateStart: '' }}</div>">{{ $ticket->tripTicket }} --}}
														<div>Driver: {{ !empty($ticket->driver) ? $ticket->driver->driver_name: '' }}</div>">{{ $ticket->tripTicket }}
											</a>&nbsp;
										@else
											<a target="_blank" href="{{ route('vehicle.request.dispatch_details', ['id' => $ticket->tripTicket]) }}" 
												class="btn btn-xs 
													@if($ticket->Status == 'Completed')
														green
													@elseif($ticket->Status == 'Closed' || $ticket->Status == 'Cancelled')
														red
													@else
														@if($ticket->isPrinted == 1)
															yellow
														@else
															blue
														@endif
													@endif 
													popovers" data-container="body" data-trigger="hover" data-html="true" data-placement="top" data-original-title="{{ $ticket->tripTicket }}" 
											data-content="
														<div>Vehicle: {{ $ticket->type }}</div>
														{{-- <div>Date Out: {{ $ticket->dateStart }}</div> --}}
														<div>Date Out: {{ date('Y-m-d',strtotime($ticket->dateStart)) }}</div>
														<div>Driver: {{  !empty($ticket->driver) ? $ticket->driver->driver_name: ''}}</div>">{{ $ticket->tripTicket }}
											</a>&nbsp;
											
											@endif
											@else
											<button disabled class="btn btn-xs" >
												{{ $ticket->tripTicket }}
											</button>&nbsp;
									@endif

								@empty
								@endforelse

							</td>
							<td style="width:150px;">
								<input type="hidden" name="isClosable{{$request->id}}>" id="isClosable{{ $request->id }}" value="">
								@if($request->isNotEditable == 0 || $request->isNotEditable == null)
									@if($request->status != 'Cancelled')
										@if($edit)
										<a href="#" class="btn yellow btn-xs" title="Update Request" onclick="editRequest('{{ $request->id }}');"><i class="fa fa-edit"></i></a>
										@else
										<button disabled href="#" class="btn yellow btn-xs" title="Update Request" onclick="editRequest('{{ $request->id }}');"><i class="fa fa-edit"></i></button>
										@endif
										@if($delete)
										<a href="#" class="btn red btn-xs" title="Cancel Request" onclick="cancel('{{ $request->id }}');"><i class="fa fa-minus-circle"></i></a>
										@else
										<button disabled href="#" class="btn red btn-xs" title="Cancel Request" onclick="cancel('{{ $request->id }}');"><i class="fa fa-minus-circle"></i></button>
										@endif
									@endif
								@endif
								@if($create)
								<a style="display:{{($request->status == 'Cancelled' || $request->status == 'Closed') ? 'none' : ''}}" href="{{ route('vehicle.request.dispatch', $request->id) }}" class="btn green btn-xs" title="Add New Trip Ticket">
									<i class="fa fa-plus-square"></i>
								</a>
								@else
								<button disabled style="display:{{($request->status == 'Cancelled' || $request->status == 'Closed') ? 'none' : ''}}" href="{{ route('vehicle.request.dispatch', $request->id) }}" class="btn green btn-xs" title="Add New Trip Ticket">
									<i class="fa fa-plus-square"></i>
								</button>
								@endif
								@if($edit)
								<a href="#" class="btn purple btn-xs dropdown-quick-sidebar-toggler" title="Send Message" id="{{ $request->id }}">
									<i class="fa fa-comments-o"></i>
								</a>
								@else
								<button disabled href="#" class="btn purple btn-xs dropdown-quick-sidebar-toggler" title="Send Message" id="{{ $request->id }}">
									<i class="fa fa-comments-o"></i>
								</button>
								@endif
							</td>
						</tr>
					@endforeach
                </tbody>
                </table>
            <div class="pull-right">
                <p>
                    @if($page > 1)
						<a class="btn blue" href="{{env('APP_URL')}}/vehicle/request/list?page={{ isset($page) ? $page-1: '2' }}" ><< Previous </a>
                        <!-- <a class="btn blue" href="/vehicle/request/list?page={{ isset($page) ? $page-1: '2' }}"><< Previous </a> -->
                    @endif

					<a class="btn blue" href="{{env('APP_URL')}}/vehicle/request/list?page={{ isset($page) ? $page+1: '2'  }}">Next >> </a>
                    <!-- <a class="btn blue" href="/vehicle/request/list?page={{ isset($page) ? $page+1: '2'  }}">Next >> </a> -->
                </p>
            </div>
                
            </div>                   
        </div>
        <div class="clearfix">
        </div>      
    </div>
    </div>
    <!-- END CONTENT -->
</div>
@endsection

@section('javascript')
<script src="{{asset('js/table/dynamitable.jquery.min.js')}} "></script>
<script src="{{asset('js/typeahead.js')}}"></script>
<script>
	jQuery(document).ready(function() {    
		Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
		ComponentsPickers.init();
		$('#di_contactpersonq').typeahead({
			source: function (query, result) {
				$.ajax({
					url: "{!! route('contact-person') !!}",
					data: 'query=' + query,
					dataType: "json",
					type: "POST",
					success: function (data) {
						console.log(data);
						
						result($.map(data, function (item) {
							return item;
						}));
					}
				});
			},
			updater: function(item) {
				var x = item.split(" - ");
				$('#di_contactperson').val(x[0]);
				$('#di_designation').val(x[1]);
				$('#di_dept').val(x[2]);
				return item;
			}
		});

		$('#di_contactperson_editq').typeahead({
			source: function (query, result) {
				//alert(result);
				$.ajax({
					url: "hris.php",
					data: 'query=' + query,            
					dataType: "json",
					type: "POST",
					success: function (data) {
						//console.log(x);
						
						result($.map(data, function (item) {
							return item;
						}));
						
					}
				});
			},
			updater: function(item) {
				var x = item.split(" - ");
				$('#di_contactperson_edit').val(x[0]);
				$('#e_fullname').val(x[0]);
				$('#di_designation_edit').val(x[1]);
				$('#e_position').val(x[1]);
				$('#di_dept_edit').val(x[2]);
				$('#e_department').val(x[2]);
				return item;
			}
		});
	
	});
</script>
<script>
   function edit_status(id,status,refcode){
      $('#cs_id').val(id);
      $('#cs_refcode').html(refcode);
      var isClosable = $('#isClosable'+id).val();
      if(isClosable == 0){
         $("#cs_status option[value='Closed']").remove();
      }
      else{
         $('#cs_status').append($('<option>', {
             value: 'Closed',
             text: 'Closed'
         }));
      }
      
      $('#cs_status option[value="'+status+'"]').attr("selected",true);
      
      $('#ChangeStatusModal').modal('show');
   }

   function change_status(){
      var id = $('#cs_id').val();
      var new_status = $('#cs_status').val();      
      $.ajax({
         method: "POST",
         url: "{{ route('vehicle.request.change.status') }}",
         data: { cs_id: id, cs_status: new_status}         
      })
      .done(function() {        
         $('#ChangeStatusModal').modal('hide');
         location.reload(); 
      });
   }
</script>
<script>

	let isAddnew = {!! json_encode($isAdd ?? '')  !!}

	if(isAddnew)
	{
		$('#newrequest').modal('show');
	}
   
	$("#filter").click( function(){
      if( $(this).is(':checked') ) {
         $('#filter_head').show();
         $('#nofilter_head').hide();
      }
      else{
         $('#nofilter_head').show();
         $('#filter_head').hide();
      }
   });

   function validate_dept(){    
        console.log($('#dept_select').val())    
        if(!$('#dept_select').val() && !$('#dept_input').val()){
            alert('Please Select Dept or Input New Dept');
            $('#dept_input').focus();
            return false;
        }
        else{
            $("newrequest_form").submit();
        }
   };

   function cancel(x){        
      var r = confirm("Are you sure you want to cancel this request?");
      if (r == true) {
         window.location = `{{env('APP_URL')}}/vehicle/${x}/cancel`;
      } else {
         return false;
      }
   }

   function editRequest(x){
		$.ajax({
			method: "GET",
			url: `{{env('APP_URL')}}/vehicle/request/${x}/details`,
		})
		.done(function( d ) {
			console.log(d)
			var contactPerson = d[0].contact_person != null ? d[0].contact_person+' - ': ''
			var designation =  d[0].designation != null ?  d[0].designation+' - ': ''
			var dept =  d[0].dept != null ?  d[0].dept: ''
			
			contactPerson = contactPerson+designation+dept

			$('#purpose_edit').val(d[0].purpose);
			$('#costcode_edit').val(d[0].costcode);
			$('#date_needed_edit').val(d[0].date_needed);
			$('#id_edit').val(d[0].id);
			$('#dept_select_edit').val(d[0].dept);
			$('#di_contactperson_edit').val(d[0].contact_person);
			$('#di_contactperson_editq').val(contactPerson);
			$('#e_fullname').val(d[0].contact_person);
			$('#di_designation_edit').val(d[0].designation);
			$('#e_position').val(d[0].designation);
			$('#di_dept_edit').val(d[0].dept);
			$('#e_department').val(d[0].dept);
			$('#di_contactno_edit').val(d[0].contact_no);
			$('#di_deliverysite_edit').val(d[0].delivery_site);
			$('#di_instruction_edit').val(d[0].other_instructions);
			$('#pi_dept_edit').val(d[0].pickup_dept);
			$('#pi_location_edit').val(d[0].pickup_location);
			$('#editrequest').modal('show');
		});
	}

   $("#datee").on('keypress', function(e){ e.preventDefault(); });
   let todayDate = new Date().getDate();
   let endD = new Date(new Date().setDate(todayDate));
//    $('.form_date').datetimepicker
//    ({
// 	format: 'YYYY-MM-DD',
	
//    });

   $('#di_deliverysite').on('change', function() {
	 var xx = this.value;
	 if(xx == 'Other'){
		$("#di_otherd").prop('required',true);
		$("#di_deliverysite").prop('required',false);
		$('#di_otherd').show();
	 }
	 else{
		$("#di_otherd").prop('required',false);
		$("#di_deliverysite").prop('required',true);
		$('#di_otherd').hide();
	 }
	});

	$('#di_deliverysite_edit').on('change', function() {
	 var xx = this.value;
	 if(xx == 'Other'){
		$("#di_otherd_edit").prop('required',true);
		$("#di_deliverysite_edit").prop('required',false);
		$('#di_otherd_edit').show();
	 }
	 else{
		$("#di_otherd_edit").prop('required',false);
		$("#di_deliverysite_edit").prop('required',true);
		$('#di_otherd_edit').hide();
	 }
	});

	function costcode_check(x,y){
		$.ajax({
         method: "GET",
         url: "{{env('APP_URL')}}/costcodes.php?code="+x
      })
      .done(function( d ) {      
         if(d == 0){
			 alert(x +' is not a valid Cost Code!');
			 $('#'+y).val('');
			 $('#'+y).focus();
		 }
      });
	}

</script>

<script>

    $(document).ready(function(){

    var typingTimer;

    $('#search').keydown(function(){
        $('#emp_spinner').show();
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTypingEmployee, 2000);
    });

      $('#e_search').keydown(function(){
        $('#e_emp_spinner').show();
        clearTimeout(typingTimer);
        typingTimer = setTimeout(e_doneTypingEmployee, 2000);
    });

    function doneTypingEmployee(){
        var query = $('#search').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('search.hris.employee') }}",
            method: "POST",
            data: { query :query, _token:_token },
            success: function(data)
            {
                $('#emp_spinner').hide();
                $('#employee_list').fadeIn();
                $('#employee_list').html(data);
            }
        })
    }

       function e_doneTypingEmployee(){
        var query = $('#e_search').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('e_search.e_hris.e_employee') }}",
            method: "POST",
            data: { query :query, _token:_token },
            success: function(data)
            {
                $('#e_emp_spinner').hide();
                $('#e_employee_list').fadeIn();
                $('#e_employee_list').html(data);
            }
        })
    }

    });

    $(document).on('click','.emp_list',function(){
    var emp = $(this).text();
    var i = emp.split("=");    

    $('#search').val(i[0]);
    $('#employee_id').val(i[1]);
    $('#first_name').val(i[2]);
    $('#middle_name').val(i[3]);
    $('#last_name').val(i[4]);
    $('#companyid').val(i[5]);
    $('#department').val(i[6]);
    $('#position').val(i[7]);
    $('#fullname').val(i[8]);
    $('#employee_list').fadeOut();

    });  

      $(document).on('click','.e_emp_list',function(){
    var emp = $(this).text();
    var i = emp.split("=");    

    $('#e_search').val(i[0]);
    $('#e_employee_id').val(i[1]);
    $('#e_first_name').val(i[2]);
    $('#e_middle_name').val(i[3]);
    $('#e_last_name').val(i[4]);
    $('#e_companyid').val(i[5]);
    $('#e_department').val(i[6]);
    $('#e_position').val(i[7]);
    $('#e_fullname').val(i[8]);
    $('#e_employee_list').fadeOut();

    });   

    </script>

@endsection