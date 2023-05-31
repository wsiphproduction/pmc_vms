<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>Vehicle Monitoring System</title>

	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	@include('layout.head.styles.globalstyles')
	<!-- END GLOBAL MANDATORY STYLES -->

	<link rel="stylesheet" type="text/css" href="{{ asset('metronic/assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('metronic/assets/global/plugins/select2/select2.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('metronic/assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" />


	<!-- BEGIN THEME STYLES -->
	<link href="{{ asset('metronic/assets/global/css/components.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('metronic/assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('metronic/assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css" />
	<link id="style_color" href="{{ asset('metronic/assets/admin/layout/css/themes/default.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('metronic/assets/admin/layout/css/custom.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('metronic/datepicker/bootstrap/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" media="screen" />
	<script src="{{ asset('js/jquery.min.js') }}"></script>
</head>

<body class="page-header-fixed page-quick-sidebar-over-content page-full-width">
	<!-- BEGIN HEADER -->
	@include('layout.header')
	<div class="clearfix"></div>
	<!-- BEGIN CONTAINER -->
	<div class="page-container">
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<div class="row">
					<div class="col-md-12">
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->
						<div class="breadcrumbs">
							<h3><i class="fa fa-truck"></i> TRIP DETAILS</h3>
							<ol class="breadcrumb">
								<li>
									<a href="{{ route('form.home') }}"><i class="fa fa-home"></i> HOME</a>
								</li>
								<li>
									<a href="{{ route('vehicle.request.list') }}"><i class="fa fa-list"></i> REQUEST LIST</a>
								</li>
								<li class="active"><i class="fa fa-tags"></i> TRIP DETAILS</li>
							</ol>
							<a style="float: right;" class="btn yellow" href="{{ route('vehicle.request.dispatch_printout', ['id' => $id]) }}" target="_blank">
								<i class="fa fa-print"></i> Print
							</a>
							<br><br>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="row">
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12">
								<!-- BEGIN EXAMPLE TABLE PORTLET-->
								<div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption font-dark">
											<i class="fa fa-truck font-dark"></i>
										<span class="caption-subject bold uppercase"> Status : Completed  {{ explode('|', $dispatch->destination)[1] ?? '' }}</span>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 blog-tag-data">
											<h3>Trip Ticket - {{$id}}</h3>

											<div class="row">
												<div class="col-md-8">
													<ul class="list-inline blog-tags">
														<li style="font-size: 15px;font-style: italic;">
															<i class="fa fa-tags"></i>
															<a href="#">
																{{$vehicle_request->name ?? '' }}
															</a>/
															<a href="#">
																 {{$vehicle_request->dept ?? '' }}
															</a>

														</li>
													</ul>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="news-item-page">
														<table style="width:100%;font-size:17px;">
															<tr>
																<td width="200px;">Date Needed: </td>
																<td>
																	{{ Carbon\Carbon::parse($vehicle_request->date_needed)->format('Y-m-d h:i:s A') ?? ''}}
																</td>

															</tr>
															<tr>
																<td>Purpose: </td>
																<td>&nbsp;
																	<blockquote class="hero">
																		<p>
																			{{$dispatch->purpose ?? ''}}
																		</p>
																	</blockquote>
																</td>
															</tr>
														</table>

														<h4>Trip Summary:</h4>
														<table style="font-size: 15px;" class="table table-condensed">
															<tr>
																<td width="190px;">Date Out : </td>
																<td>{{  Carbon\Carbon::parse($dispatch->dateStart)->format('Y-m-d h:i:s A') ?? ''}}</td>
															</tr>
															<tr>
																<td width="190px;">Vehicle :</td>
																<td>{{$unit->name ?? '' }}</td>
															</tr>
															<tr>
																<td width="190px;">Driver :</td>
															<td>{{$driver->driver_name ?? ''}}</td>
															</tr>
															<tr>
																<td width="190px;">Destination :</td>
																<td><b>From:</b> {{ explode('|', $dispatch->destination)[0] ?? '' }} &nbsp;&nbsp; <b>To:</b> {{ explode('|', $dispatch->destination)[1] ?? '' }}</td>
															</tr>
															<tr>
																<td width="190px;">Purpose :</td>
																<td>{{$dispatch->purpose ?? ''}}</td>
															</tr>
															<tr>
																<td width="190px;">Passengers :</td>
																<td>{{$dispatch->passengers ?? ''}}</td>
															</tr>
														</table>
													</div>
												</div>
											</div>

											<hr>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12">
								<!-- BEGIN EXAMPLE TABLE PORTLET-->
								<div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption font-dark">
											<i class="fa fa-truck font-dark"></i>
											<span class="caption-subject bold uppercase"> Return & Fuel Slip Details TESTING</span>
										</div>
									</div>
									<div class="portlet-body">
										<table style="font-size: 17px;" class="table table-condensed">
											<tr>
												<td width="190px;"><strong><i class="fa fa-truck"></i> Return Trip Details</strong> </td>
												<td></td>
											</tr>
											<tr>
												<td width="190px;">Return Date & Time :</td>
												<td>
													{{  Carbon\Carbon::parse($dispatch->dateEnd)->format('F d, Y h:i:s A') ?? '' }}												
												</td>
											</tr>
											<tr>
												<td width="190px;">Odometer Start :</td>
												<td>{{ $dispatch->odometer_start ?? '' }}</td>
											</tr>
											<tr>
												<td width="190px;">Odometer End :</td>
												<td>{{ $dispatch->odometer_end ?? '' }}</td>
											</tr>
											<tr>
												<td width="190px;">Distance Travelled :</td>
												<td>{{ ((int)$dispatch->odometer_end - (int)$dispatch->odometer_start) ?? '' }} KM</td>
											</tr>
											<tr>
												<td width="190px;"><i class="fa fa-fire"></i> <strong>Fuel Details</strong></td>
												<td></td>
											</tr>
											<tr>
												<td width="190px;">Request Cost Code :</td>
												<td>{{ $vehicle_request->costcode ?? '' }}</td>
											</tr>
											<tr>
												<td width="190px;">Vehicle Cost Code :</td>
												<td>{{ $dispatch->vehicle_cost_code ?? '' }}</td>
											</tr>
											<tr>
												<td width="190px;">RQ # :</td>
												<td>{{ $dispatch->RQ ?? '' }}</td>
											</tr>
											<tr>
												<td width="190px;">Fuel Type :</td>
												<td>{{ $dispatch->fuel_added_type ?? '' }}</td>
											</tr>
											<tr>
												<td width="190px;">Item Code :</td>
												<td>{{ $dispatch->itemCode ?? '' }}</td>
											</tr>
											<tr>
												<td width="190px;">Requested Qty :</td>
												<td>{{ $dispatch->fuel_requested_qty . ' ' . $dispatch->uom }}</td>
											</tr>
											<tr>
												<td width="190px;">Actual Fuel Qty :</td>
												<td>{{ $dispatch->fuel_added_qty . ' ' . $dispatch->uom }}</td>
											</tr>
											<tr>
												<td width="190px;">Average Fuel Consumed :</td>
												<td>
													{{ $total ?? '' }}
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END CONTENT -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<div class="page-footer">
		<div class="page-footer-inner">
			<?php echo date('Y'); ?> &copy; PMC
		</div>
		<div class="page-footer-tools">
			<span class="go-top">
				<i class="fa fa-angle-up"></i>
			</span>
		</div>
	</div>
	<!-- Scripts -->
	<script src="{{ asset('metronic/assets/global/plugins/jquery-1.11.0.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/jquery-migrate-1.2.1.min.js') }}" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="{{ asset('metronic/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/jquery.cokie.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>

	<script src="{{ asset('metronic/assets/global/plugins/jquery.pulsate.min.js') }}" type="text/javascript"></script>

	<script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/select2/select2.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>


	<script src="{{ asset('metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/excel/src/jquery.table2excel.js') }}"></script>
	<script type="text/javascript" src="{{ asset('metronic/datepicker/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
</body>
<script>
	jQuery(document).ready(function() {
		Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
		ComponentsDropdowns.init();

	});
</script>
<!-- END BODY -->

</html>