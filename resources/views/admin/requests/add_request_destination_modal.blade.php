<div class="modal fade bs-modal-lg" id="new-request-destination" tabindex="-1" role="newrequest" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<form autocomplete="off" method="post" action="{{ route('vehicle.request.create.destination') }}" id="newrequest_form" onsubmit="return validate_dept();">
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
								<select required name="dept_select" id="dept_select" class="form-control" placeholder="Select Dept">
									<option value="">Select Dept</option>
									@foreach($departments as $department)
										<option value="{{ $department->name }}">{{ $department->name }}</option>
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
									<div class="input-group date form_datetime">
										<input type="text" size="16" id="datee" class="form-control" name="date_needed" required>
										<span class="input-group-btn">
										<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
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
							<label class="control-label">Contact Person <i class="font-red">*</i></label>                    
							<input type="text" id="di_contactpersonq" name="di_contactpersonq" class="typeahead form-control input-sm" required>   
							<input type="hidden" id="di_contactperson" name="di_contactperson" class="form-control input-sm">       
							</div>

							<div class="form-group">
							<label class="control-label">Contact No. / Office Tel No. <i class="font-red">*</i></label>                                                
							<input type="text" id="di_contactno" name="di_contactno" class="form-control input-sm" required>                                                
							</div> 

							<div class="form-group hide">
							<label class="control-label">Designation</label>                                                
							<input type="text" id="di_designation" name="di_designation" class="form-control input-sm">                                                
							</div>        

							<div class="form-group hide">
							<label class="control-label">Dept</label>                                                
							<input type="text" id="di_dept" name="di_dept" class="form-control input-sm">                                                
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
				<input type="submit" class="btn blue" value="Save">
			</div>
		</form>
		</div>
	</div>
</div>