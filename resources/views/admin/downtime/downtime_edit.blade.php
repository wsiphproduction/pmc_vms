@extends('layout.downtime_edit')

@section('content')
<div class="page-container">

		@if(Session::has('success'))

		<script>
			setTimeout(function() {
				$('#success').fadeOut();
			}, 3000);
		</script>

		<div id="success" class="alert alert-success alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><span class="fa fa-check-square-o"></span> Success!</strong> {{ Session::get('success') }}
		</div>
		@endif

		@if(Session::has('error'))

		<script>
			setTimeout(function() {
				$('#error').fadeOut();
			}, 3000);
		</script>
		<div id="error" class="alert alert-danger alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><span class="fa fa-warning"></span> Error!</strong> {{ Session::get('error') }}
		</div>

		@endif
		@if ($errors->any())
		<script>
			$('#error_any').fadeOut();
		</script>
		<div id="error_any" class="alert alert-danger alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><span class="fa fa-warning"></span> Error!</strong> {{ $errors->first() }}
		</div>
		@endif
		<form method="POST" id="downtimeform" action="{{ route('downtime.downtime_update',  ['downtime' =>  $id]) }}">
			@csrf
			{{ method_field('PATCH') }}
			<div class="modal-header">
				<h4 class="modal-title"><b>Update Downtime Details </b></h4>
			</div>
			<div class="modal-body">
				<div class="form-group" style="height:600px">
					<div class="row">
						<div class="col-md-6">

							<div class="row">
								<div class="col-md-12 margin-bottom-10">
									<label class="control-label col-md-3">Unit</label>
									<div class="col-md-9">
										<select class="form-control" name="unit" id="unit" required>
											<option value=""> - Select Unit -</option>
											@foreach ($unit as $item)


											<option value="{{ $item['id'] }}" {{ ($item['id'] == $result['unitId']) ? 'selected' : '' }}>{{ $item['name'] }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12 margin-bottom-10">
									<label class="control-label col-md-3">Work Order</label>
									<div class="col-md-9">
										<input type="text" size="16" name="work_order" id="work_order" class="form-control" required maxlength="50" value="{{ $result->workOrder }}">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12 margin-bottom-10">
									<label class="control-label col-md-3">Assigned To:</label>
									<div class="col-md-9">
										<select class="form-control" name="assigned_to" id="assigned_to">
											<option value=""> - Select -</option>
											@foreach ($assigned as $item)

											<option value="{{ $item['name'] }}" {{ ($item['name'] == $result['assignedTo']) ? 'selected' : '' }}>{{ $item['name'] }}</option>

											@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12 margin-bottom-10">
									<label class="control-label col-md-3">Downtime Category</label>
									<div class="col-md-9">
										<select class="form-control" name="dcategory">
											<option value=""> - Select Type -</option>
											<option value="ACCIDENT" {!! $result->downtimeCategory == "ACCIDENT" ? 'selected="selected"' : "" !!} >Accident</option>
											<option value="CORRECTIVE MAINTENANCE" {!! $result->downtimeCategory == "CORRECTIVE MAINTENANCE" ? 'selected="selected"' : "" !!} >Corrective Maintenance</option>
											<option value="PREVENTIVE MAINTENANCE" {!! $result->downtimeCategory == "PREVENTIVE MAINTENANCE" ? 'selected="selected"' : "" !!} >Preventive Maintenance</option>
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12 margin-bottom-10">
									<label class="control-label col-md-3">Downtime Type</label>
									<div class="col-md-9">
										<select class="form-control" name="dtype" id="dtype" onchange="dtypeChanged();">
											<option value=""> - Select Type - </option>
											<option value="1" {!! $result->isScheduled == 1 ? 'selected="selected"' : "" !!}>Scheduled Downtime (Corrective/PM)</option>
											<option value="2" {!! $result->isScheduled == 2 ? 'selected="selected"' : "" !!}>Unscheduled Downtime (Breakdown)</option>
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12 margin-bottom-10">
									<div id="rt1" style=' {!! $result->isScheduled == 1 ? "" : "display:none;" !!} '>
										<label class="control-label col-md-3">Repair Type</label>
										<div class="col-md-9">
											<select class="form-control" name="repairType1" id="repairType">
												<option value=""> - Select Type - </option>
												<option value="Inspections" {!! $result->repairType == "Inspections" ? 'selected="selected"' : "" !!} >Inspections</option>
												<option value="Repair and Replace" {!! $result->repairType == "Repair and Replace" ? 'selected="selected"' : "" !!} >Repair and Replace</option>
												<option value="Service and Lube" {!! $result->repairType == "Service and Lube" ? 'selected="selected"' : "" !!} >Service and Lube</option>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12 margin-bottom-10">
									<div id="rt1" style=' {!! $result->isScheduled == 2 ? "" : "display:none;" !!} '>
										<label class="control-label col-md-3">Repair Type</label>
										<div class="col-md-9">
											<select class="form-control" name="repairType2" id="repairType">
												<option value=""> - Select Type -</option>
												<option value="Brake System" {!! $result->repairType == "Brake System" ? 'selected="selected"' : "" !!} >Brake System</option>
												<option value="Clutch System" {!! $result->repairType == "Clutch System" ? 'selected="selected"' : "" !!} >Clutch System</option>
												<option value="Engine System" {!! $result->repairType == "Engine System" ? 'selected="selected"' : "" !!} >Engine System</option>
												<option value="Primary Function" {!! $result->repairType == "Primary Function" ? 'selected="selected"' : "" !!} >Primary Function</option>
												<option value="Transmission System" {!! $result->repairType == "Transmission System" ? 'selected="selected"' : "" !!} >Transmission System</option>
											</select>
										</div>
									</div>
								</div>
							</div>



							<div class="row">
								<div class="col-md-12 margin-bottom-10">

									<label class="control-label col-md-3">Work Details:</label>
									<div class="col-md-9">
										<textarea class="form-control" rows="5" name="work_details" placeholder="Work Details">{{ $result->workDetails }}</textarea>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12 margin-bottom-10">
									<label class="control-label col-md-3">Remarks:</label>
									<div class="col-md-9">
										<textarea class="form-control" rows="5" name="remarks" placeholder="Remarks">{{$result->remarks}}</textarea>
									</div>

								</div>
							</div>

							<div class="row">
								<div class="col-md-12 margin-bottom-10">

									<label class="control-label col-md-3">Mechanics:</label>
									<div class="col-md-9">
										<input id="select2_sample5" name="mechanics" class="form-control" value="{{ $crews }}" required>
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
											<option value=""> - Current Status -</option>
											@foreach ($unitStatus as $item)
											<option value="{{$item->status}}" {!! $result->status == $item->status ? 'selected="selected"' : "" !!}>{{$item->status}}</option>
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
											<input required class="form-control" onchange="checkdates('startd')" value="{!! date('Y-m-d\TH:i', strtotime($result->ds)) !!}" type="datetime-local" id="startd" name="startd" />
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12 margin-bottom-10">
									<label class="control-label col-md-3">End</label>
									<div class="col-md-9">
										<div class="input-group">
											<input required class="form-control" onchange="checkdates('endd')" value="{!! date('Y-m-d\TH:i', strtotime($result->de)) !!}" type="datetime-local" id="endd" name="endd" />
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12 margin-bottom-10">
									<label class="control-label col-md-3">Reported</label>
									<div class="col-md-9">
										<div class="input-group">
											<input type="date" size="16" name="reported_date" value="{!! date('Y-m-d', strtotime($result->rd)) !!}" id="reported_date" class="form-control">
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

			</div>
			<div class="modal-footer" id="footermode">
				<button type="button" class="btn default" data-dismiss="modal" onclick="self.close()">Cancel</button>
				<input type="submit" class="btn blue" value="Update">
			</div>
		</form>

	</div>
	@endsection

	@push('javascript')
	<script>
		jQuery(document).ready(function() {
			Metronic.init(); // init metronic core components
			Layout.init(); // init current layout
			ComponentsDropdowns.init();
		});
	</script>
	<script>
		var ComponentsDropdowns = function() {

			let mech_tags = {!! json_encode($mechanic_option2 ?? '') !!}
			mech_tags = mech_tags.split(",");

			var handleSelect2 = function() {
				$("#select2_sample5").select2({
					tags: mech_tags
				});

			}
			return {
				//main function to initiate the module
				init: function() {
					handleSelect2();
				}
			};

		}();
	</script>
	<script>
		function hasValue(elem) {
			return $(elem).filter(function() {
				return $(this).val();
			}).length > 0;
		}

		function dtypeChanged() {
			var dtype = $('#dtype').val();
			$('#rt1').hide();
			$('#rt2').hide();
			if (dtype == 1 || dtype == 2) {
				$('#rt' + dtype).show();
			}
		}


		$("#downtimeform :input").change(function() {
			if ($("#startd").val() != "" && $("#endd").val() != "" && $("#reported_date").val() != "" && $("#unit").val() != "") {
				calculate();
			}
		});

		function calculate() {
			$.ajax({
					method: "POST",
					url: "ajax.php?act=calculate",
					data: {
						mechanics: $('#select2_sample5').val(),
						startd: $('#startd').val(),
						endd: $('#endd').val(),
						reported_date: $('#reported_date').val(),
						unit: $('#unit').val()
					}
				})
				.done(function(html) {
					$("#result").html(html);
				});
		}

		$("#add_mechanic").click(function(e) {
			e.preventDefault();
			var total = $('#no_crew').val();
			var x = parseInt(total) + 1;
			$('#crewdiv').append("<div style='color:black;font-size:12px;font-weight:bold;' class='col-md-12 pull-right'>Mechanic " + x + ": <select class='form-control mechanic' name='mechanic" + x + "' onchange='calculate();' required></select></div>");
			$('#no_crew').val(x);
			calculate();
		});

		$('.mechanic').change(function() {
			calculate();
		});





		function checkdates(x) {
			if (x == 'startd') { // Auto Change Reported Date           
				if ($('#reported_date').val() == '') {
					var currentTime = new Date($('#startd').val());
					var month = ("0" + (currentTime.getMonth() + 1)).slice(-2);
					var date = ("0" + currentTime.getDate()).slice(-2);
					var year = currentTime.getFullYear();
					//alert();
					$('#reported_date').val(year + '-' + month + '-' + date);
					//$('#reporoted_date').val(a.getDate());
				}
			}
			if ($("#startd").val() != "" && $("#endd").val() != "") {

				var start = new Date($('#startd').val());
				var end = new Date($('#endd').val());
				if (start > end) {
					alert("End Date should be greater than Start Date!");
					$("#" + x).val('');
				}

			}
		}
	</script>
	@endpush