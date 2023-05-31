@extends('layout.downtime_add')

@section('content')

@if(Route::get('act') == "success")

<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	<span class="fa fa-check-square"></span><strong> Success!</strong> Record has been added.
</div>

@endif

<form method="post" id="downtimeform" action="{{ route('downtime.store', ['act' => 'submitdowntime']) }}">
	@csrf
	<div class="modal-header">
		<h4 class="modal-title"><b>Input Downtime Details</b></h4>
	</div>
	<div class="modal-body">
		@if (session('status'))
		<div class="alert alert-success" role="alert">
			<button type="button" class="close" data-dismiss="alert">×</button>
			{{ session('status') }}
		</div>
		@elseif(session('failed'))
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert">×</button>
			{{ session('failed') }}
		</div>
		@endif
		@csrf
		<div class="form-group" style="height:500px">
			<div class="row">
				<div class="col-md-6">

					<div class="row">
						<div class="col-md-12 margin-bottom-10">
							<label class="control-label col-md-3">Unit</label>
							<div class="col-md-9">
								<select class="form-control select2" name="unit" id="unit" required>
									<option value=""> - Select Unit -</option>

									@foreach ($units as $item)

									<option value="{{$item->id}}"> {{$item->type}}&nbsp;&nbsp;{{$item->name}} </option>

									@endforeach

								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 margin-bottom-10">
							<label class="control-label col-md-3">Work Order</label>
							<div class="col-md-9">
								<input type="text" size="16" name="work_order" id="work_order" class="form-control"
								required maxlength="50">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 margin-bottom-10">
							<label class="control-label col-md-3">Assigned To:</label>
							<div class="col-md-9">
								<select class="form-control select2" name="assigned_to" id="assigned_to">
									<option value="">- Select -</option>
									@foreach ($assigned as $item)
									<option value="{{$item->name}}">{{$item->name}}</option>
									@endforeach
								</select>
								</optgroup>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 margin-bottom-10">
							<label class="control-label col-md-3">Downtime Category</label>
							<div class="col-md-9">
								<select class="form-control" name="dcategory" id="dcategory">
									<option></option>
									<optgroup label="Downtime Category">
										<option value="ACCIDENT">Accident</option>
										<option value="CORRECTIVE MAINTENANCE">Corrective Maintenance</option>
										<option value="PREVENTIVE MAINTENANCE">Preventive Maintenance</option>
								</select>
								</optgroup>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 margin-bottom-10">
							<label class="control-label col-md-3">Downtime Type</label>
							<div class="col-md-9">
								<select class="form-control" name="dtype" id="dtype" onchange="dtypeChanged();">
									<option></option>
									<optgroup label="Downtime Type">
										<option value="1">Scheduled Downtime (Corrective/PM)</option>
										<option value="2">Unscheduled Downtime (Breakdown)</option>
									</optgroup>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">

							<div id="rt1" style="display:none;">
								<label class="control-label col-md-3">Repair Type</label>
								<div class="col-md-9">
									<select class="form-control" name="repairType1" id="repairType">
										<option value=""> - Select Type -</option>
										<option value="Inspections">Inspections</option>
										<option value="Repair and Replace">Repair and Replace</option>
										<option value="Service and Lube">Service and Lube</option>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">

							<div id="rt2" style="display:none;">
								<label class="control-label col-md-3">Repair Type</label>
								<div class="col-md-9">
									<select class="form-control" name="repairType2" id="repairType">
										<option value=""> - Select Type -</option>
										<option value="Brake System">Brake System</option>
										<option value="Clutch System">Clutch System</option>
										<option value="Engine System">Engine System</option>
										<option value="Primary Function">Primary Function</option>
										<option value="Transmission System">Transmission System</option>
									</select>
								</div>
							</div>
						</div>
					</div>

					<br>

					<div class="row">
						<div class="col-md-12 margin-bottom-10">

							<label class="control-label col-md-3">Work Details:</label>
							<div class="col-md-9">
								<textarea class="form-control" rows="5" name="work_details"
									placeholder="Work Details"></textarea>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 margin-bottom-10">
							<label class="control-label col-md-3">Remarks:</label>
							<div class="col-md-9">
								<textarea class="form-control" rows="5" onkeyup="mech();" name="remarks"
									placeholder="Remarks"></textarea>
							</div>

						</div>
					</div>
					<div class="row">
						<div class="col-md-12 margin-bottom-10">

							<label class="control-label col-md-3">Mechanics:</label>
							<div class="col-md-9">
								<input type="text" size="16" name="mechanics" id="select2_sample5" class="form-control"
									required="required">

							</div>
							<div class="col-md-12" id="crewdiv">

							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="row">
						<div class="col-md-12 margin-bottom-10">
							<label class="control-label col-md-3">Status</label>
							<div class="col-md-9">
								<select class="form-control" name="status" id="status" required>
									@foreach ($unitStatus as $item)
									<option value="{{$item->status}}">{{$item->status}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 margin-bottom-10">
							<label class="control-label col-md-3">Start</label>
							<div class="col-md-9">
								<div class="input-group">
									<input class="form-control" onchange="checkdates('startd')" type="datetime-local"
										id="startd" name="startd" />

								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 margin-bottom-10">
							<label class="control-label col-md-3">End</label>
							<div class="col-md-9">
								<div class="input-group">
									<input class="form-control" onchange="checkdates('endd')" type="datetime-local"
										id="endd" name="endd" />

								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 margin-bottom-10">
							<label class="control-label col-md-3">Reported</label>
							<div class="col-md-9">
								<div class="input-group">
									<input type="date" size="16" name="reported_date" id="reported_date"
										class="form-control">
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12 margin-bottom-10" id="result">

						</div>
					</div>
				</div>
			</div>

		</div>
		<input type="hidden" name="olr_url" value="">
		<br><br>
	</div>
	<div class="modal-footer" id="footermode">
		<button type="button" class="btn default" onclick="window.close();">Cancel</button>
		@if($create)
		<input type="submit" class="btn blue" value="Add">
		@else
		<input disabled type="submit" class="btn blue" value="Add">
		@endif
	</div>
</form>
@endsection

@push('javascript')
<script>
	jQuery(document).ready(function() {    
	   Metronic.init(); // init metronic core components
	   Layout.init(); // init current layout
	   ComponentsDropdowns.init();
	  
	});

	$(document).ready(function () {
	$('#unit').chosen();
	});

	$(document).ready(function () {
	$('#dcategory').chosen();
	});

	$(document).ready(function () {
	$('#assigned_to').chosen();
	});

	$(document).ready(function () {
	$('#dtype').chosen();
	});

	$(document).ready(function () {
	$('#repairType').chosen();
	});

	$(document).ready(function () {
	$('#repairType2').chosen();
	});

	$(document).ready(function () {
	$('#status').chosen();
	});
</script>
<script>
	var ComponentsDropdowns = function () {
		
		let mech_tags = {!! json_encode($mechanic_option2 ?? '') !!}
		mech_tags = mech_tags.split(",");

	   var handleSelect2 = function () {
		   $("#select2_sample5").select2({
			   tags: mech_tags
			//    tags: ["red", "green", "blue", "yellow", "pink"]

		   });

	   	}
	   	return {
		   //main function to initiate the module
		   init: function () {            
			   handleSelect2();
		   }
	   	};

   }();
</script>
<script>
	function hasValue(elem) {
		return $(elem).filter(function() { return $(this).val(); }).length > 0;
	}

	function dtypeChanged(){
	   var dtype = $('#dtype').val();
		  $('#rt1').hide();
		  $('#rt2').hide();
	   if(dtype == 1 || dtype == 2){               
		  $('#rt'+dtype).fadeIn("slow",pulsate_now('#repairType'));
		 
	   }
	}

	function pulsate_now(x){
	   $(x).pulsate({
		  color: "#399bc3",
		  repeat: false
	   });
	}         

	$("#downtimeform :input").change(function() {

	   if ($("#startd").val() != "" && $("#endd").val() != "" && $("#reported_date").val() != "" && $("#unit").val() != "" ){
		  calculate();
	   }
	});

	function calculate(){
		$( "#result" ).html('');
	   $.ajax({
		  method: "POST",
		  url: "ajax.php?act=calculate",
		  data: { mechanics: $('#select2_sample5').val(), startd: $('#startd').val(), endd: $('#endd').val(), reported_date: $('#reported_date').val(), unit: $('#unit').val()}
	   })
	   .done(function( html ) {
		  $( "#result" ).html( html );
	   });
	}

	function checkdates(x){
	   if(x=='startd'){    // Auto Change Reported Date           
		  if($('#reported_date').val()==''){
			 var currentTime = new Date($('#startd').val());
			 var month = ("0" + (currentTime.getMonth()+1)).slice(-2);
			 var date = ("0" + currentTime.getDate()).slice(-2);
			 var year = currentTime.getFullYear();
			 //alert();
			 $('#reported_date').val(year + '-' + month + '-' + date);
			 //$('#reporoted_date').val(a.getDate());
		  }
	   }
	   if ($("#startd").val() != "" && $("#endd").val() != ""){               
		  var start = new Date($('#startd').val());
		  var end = new Date($('#endd').val());
		  if (start > end) {               
			 alert("End Date should be greater than Start Date!");
			 $("#"+x).val('');
		  }
		
	   }
	}
</script>
@endpush