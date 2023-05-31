<?php
//phpinfo(); die();
include('connection_agusan.php');
?>
<!DOCTYPE html>

<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>HRIS | Externsion System</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="metronic/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link href="metronic/assets/global/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
<link href="metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
<link href="metronic/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
<link href="metronic/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
<!-- BEGIN PAGE STYLES -->
<link href="metronic/assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="metronic/assets/global/css/components.css" rel="stylesheet" type="text/css"/>
<link href="metronic/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="metronic/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="metronic/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="metronic/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="page-header-fixed page-quick-sidebar-over-content">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
	<?php include('header.php');?>
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<?php include("sidebar.php");?>
	</div>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					Agusan - HR Reports
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="index.html">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">All Reports</a>
						</li>
						
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i>List of Reports
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="javascript:;" class="reload">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-hover table-striped table-bordered">
							<tr>
								<td>Employee List Group by Dept</td>
								<td><a class="btn btn-success" data-toggle="modal" href="#r1">Generate</a></td>
							</tr>
							<tr>
								<td>Employee Assigned Property Report</td>
								<td><a class="btn btn-success" data-toggle="modal" href="#r2">Generate</a></td>
							</tr>
							<tr>
								<td>Employee Certifications</td>
								<td><a class="btn btn-success" data-toggle="modal" href="#r3">Generate</a></td>
							</tr>
							<tr>
								<td>List of Dependents per Employee</td>
								<td><a class="btn btn-success" data-toggle="modal" href="#r4">Generate</a></td>
							</tr>
							<tr>
								<td>Employee Evaluation</td>
								<td><a class="btn btn-success" data-toggle="modal" href="#r5">Generate</a></td>
							</tr>
							<tr>
								<td>Employee Medical Record</td>
								<td><a class="btn btn-success" data-toggle="modal" href="#r6">Generate</a></td>
							</tr>
							<tr>
								<td>Employee Memo</td>
								<td><a class="btn btn-success" data-toggle="modal" href="#r7">Generate</a></td>
							</tr>
							<tr>
								<td>Employee Offenses</td>
								<td><a class="btn btn-success" data-toggle="modal" href="#r8">Generate</a></td>
							</tr>
							<tr>
								<td>Employee Previous Employment Report</td>
								<td><a class="btn btn-success" data-toggle="modal" href="#r9">Generate</a></td>
							</tr>
							</table>
							<div id="r1" class="modal fade" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Employee List Group by Dept</h4>
										</div>
										<form method="post" action="Agusan-hr/masterlistByDept.php" target="_blank">
										<div class="modal-body">
											<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
												<div class="row">
													<div class="col-md-12">
														
															<div class="col-md-12 form-group">
																<input type="checkbox" name="alldept" id="alldept" checked="checked" class="form-control"> All Dept 
																
																<div class="form-group display-hide sel_dept">
																	<br><label>Select Dept</label>
																	<select name="seldept" multiple="" class="form-control">
																		<?php echo $optdept; ?>
																	</select>
																</div>
																<br><input type="checkbox" name="isActive" class="form-control"> Include Inactive Employees
																<br><input type="checkbox" name="isExcel" class="form-control"> Output to Excel
															</div>
														
															
														
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<input type="submit" class="btn green" value="GENERATE">
										</div>
										</form>
									</div>
								</div>
							</div>

							
							<div id="r2" class="modal fade" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Employee Assigned Property Report</h4>
										</div>
										<div class="modal-body">
											<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
												<div class="row">
													<div class="col-md-12">
														<form method="post" action="Agusan-hr/masterlistByDept.php">
															<div class="col-md-12 form-group">
																<input type="checkbox" name="alldept" id="alldept" checked="checked" class="form-control"> All Dept 
																
																<div class="form-group display-hide sel_dept">
																	<br><label>Select Dept</label>
																	<select name="seldept" multiple="" class="form-control">
																		<?php echo $optdept; ?>
																	</select>
																</div>
																<br><input type="checkbox" name="isActive" class="form-control"> Include Inactive Employees
																<br><input type="checkbox" name="isExcel" class="form-control"> Output to Excel
															</div>
														
															
														</form>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" class="btn green">Generate</button>
										</div>
									</div>
								</div>
							</div>

							
							<div id="r3" class="modal fade" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Employee Certifications</h4>
										</div>
										<div class="modal-body">
											<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
												<div class="row">
													<div class="col-md-12">
														<form method="post" action="Agusan-hr/masterlistByDept.php">
															<div class="col-md-12 form-group">
																<input type="checkbox" name="alldept" id="alldept" checked="checked" class="form-control"> All Dept 
																
																<div class="form-group display-hide sel_dept">
																	<br><label>Select Dept</label>
																	<select name="seldept" multiple="" class="form-control">
																		<?php echo $optdept; ?>
																	</select>
																</div>
																<br><input type="checkbox" name="isActive" class="form-control"> Include Inactive Employees
																<br><input type="checkbox" name="isExcel" class="form-control"> Output to Excel
															</div>
														
															
														</form>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" class="btn green">Generate</button>
										</div>
									</div>
								</div>
							</div>

							
							<div id="r4" class="modal fade" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">List of Dependents per Employee</h4>
										</div>
										<div class="modal-body">
											<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
												<div class="row">
													<div class="col-md-12">
														<form method="post" action="Agusan-hr/masterlistByDept.php">
															<div class="col-md-12 form-group">
																<input type="checkbox" name="alldept" id="alldept" checked="checked" class="form-control"> All Dept 
																
																<div class="form-group display-hide sel_dept">
																	<br><label>Select Dept</label>
																	<select name="seldept" multiple="" class="form-control">
																		<?php echo $optdept; ?>
																	</select>
																</div>
																<br><input type="checkbox" name="isActive" class="form-control"> Include Inactive Employees
																<br><input type="checkbox" name="isExcel" class="form-control"> Output to Excel
															</div>
														
															
														</form>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" class="btn green">Generate</button>
										</div>
									</div>
								</div>
							</div>

							
							<div id="r5" class="modal fade" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Employee Evaluation</h4>
										</div>
										<div class="modal-body">
											<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
												<div class="row">
													<div class="col-md-12">
														<form method="post" action="Agusan-hr/masterlistByDept.php">
															<div class="col-md-12 form-group">
																<input type="checkbox" name="alldept" id="alldept" checked="checked" class="form-control"> All Dept 
																
																<div class="form-group display-hide sel_dept">
																	<br><label>Select Dept</label>
																	<select name="seldept" multiple="" class="form-control">
																		<?php echo $optdept; ?>
																	</select>
																</div>
																<br><input type="checkbox" name="isActive" class="form-control"> Include Inactive Employees
																<br><input type="checkbox" name="isExcel" class="form-control"> Output to Excel
															</div>
														
															
														</form>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" class="btn green">Generate</button>
										</div>
									</div>
								</div>
							</div>

							
							<div id="r6" class="modal fade" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Employee Medical Record</h4>
										</div>
										<div class="modal-body">
											<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
												<div class="row">
													<div class="col-md-12">
														<form method="post" action="Agusan-hr/masterlistByDept.php">
															<div class="col-md-12 form-group">
																<input type="checkbox" name="alldept" id="alldept" checked="checked" class="form-control"> All Dept 
																
																<div class="form-group display-hide sel_dept">
																	<br><label>Select Dept</label>
																	<select name="seldept" multiple="" class="form-control">
																		<?php echo $optdept; ?>
																	</select>
																</div>
																<br><input type="checkbox" name="isActive" class="form-control"> Include Inactive Employees
																<br><input type="checkbox" name="isExcel" class="form-control"> Output to Excel
															</div>
														
															
														</form>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" class="btn green">Generate</button>
										</div>
									</div>
								</div>
							</div>

							
							<div id="r7" class="modal fade" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Employee Memo</h4>
										</div>
										<div class="modal-body">
											<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
												<div class="row">
													<div class="col-md-12">
														<form method="post" action="Agusan-hr/masterlistByDept.php">
															<div class="col-md-12 form-group">
																<input type="checkbox" name="alldept" id="alldept" checked="checked" class="form-control"> All Dept 
																
																<div class="form-group display-hide sel_dept">
																	<br><label>Select Dept</label>
																	<select name="seldept" multiple="" class="form-control">
																		<?php echo $optdept; ?>
																	</select>
																</div>
																<br><input type="checkbox" name="isActive" class="form-control"> Include Inactive Employees
																<br><input type="checkbox" name="isExcel" class="form-control"> Output to Excel
															</div>
														
															
														</form>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" class="btn green">Generate</button>
										</div>
									</div>
								</div>
							</div>

							
							<div id="r8" class="modal fade" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Employee Offenses</h4>
										</div>
										<div class="modal-body">
											<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
												<div class="row">
													<div class="col-md-12">
														<form method="post" action="Agusan-hr/masterlistByDept.php">
															<div class="col-md-12 form-group">
																<input type="checkbox" name="alldept" id="alldept" checked="checked" class="form-control"> All Dept 
																
																<div class="form-group display-hide sel_dept">
																	<br><label>Select Dept</label>
																	<select name="seldept" multiple="" class="form-control">
																		<?php echo $optdept; ?>
																	</select>
																</div>
																<br><input type="checkbox" name="isActive" class="form-control"> Include Inactive Employees
																<br><input type="checkbox" name="isExcel" class="form-control"> Output to Excel
															</div>
														
															
														</form>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" class="btn green">Generate</button>
										</div>
									</div>
								</div>
							</div>

							
							<div id="r9" class="modal fade" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Employee Previous Employment Report</h4>
										</div>
										<div class="modal-body">
											<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
												<div class="row">
													<div class="col-md-12">
														<form method="post" action="Agusan-hr/masterlistByDept.php">
															<div class="col-md-12 form-group">
																<input type="checkbox" name="alldept" id="alldept" checked="checked" class="form-control"> All Dept 
																
																<div class="form-group display-hide sel_dept">
																	<br><label>Select Dept</label>
																	<select name="seldept" multiple="" class="form-control">
																		<?php echo $optdept; ?>
																	</select>
																</div>
																<br><input type="checkbox" name="isActive" class="form-control"> Include Inactive Employees
																<br><input type="checkbox" name="isExcel" class="form-control"> Output to Excel
															</div>
														
															
														</form>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" class="btn green">Generate</button>
										</div>
									</div>
								</div>
							</div>


						</div>
					</div>
					<!-- END PORTLET-->
	
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<?php include('footer.php');?>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="metronic/assets/global/plugins/respond.min.js"></script>
<script src="metronic/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="metronic/assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="metronic/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="metronic/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="metronic/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="metronic/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="metronic/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="metronic/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="metronic/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="metronic/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   QuickSidebar.init() // init quick sidebar
   Index.init();   
   Index.initDashboardDaterange();
   Index.initJQVMAP(); // init index page's custom scripts
   Index.initCalendar(); // init index page's custom scripts
   Index.initCharts(); // init index page's custom scripts
   Index.initChat();
   Index.initMiniCharts();
   Index.initIntro();
   Tasks.initDashboardWidget();
   $('#alldept').click(function(){
    if (this.checked) {
         $(".sel_dept").hide();
    }
    else{
    	$(".sel_dept").show();	
    }
}) 
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>