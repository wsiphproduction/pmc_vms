<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="index.php" style="color:white;">
				<br>ECS Vehicle Request
			</a>
		</div>

		
		<div class="hor-menu hidden-sm hidden-xs">
			<ul class="nav navbar-nav">	
				<li class="classic-menu-dropdown">
					<a href="{{ route('form.home') }}">
					<i class="fa fa-home"></i> Home
					</a>
				</li>
				<li class="mega-menu-dropdown">
					<a data-hover="dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
					<i class="icon-speedometer"></i> Vehicle Downtime <i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
						<li>
							<!-- Content container to add padding -->
							<div class="mega-menu-content">
								<div class="row">
									<ul class="col-md-6 mega-menu-submenu">
										<li>
											<h3>Downtime</h3>
										</li>
										<li>
											<a href="{{ route('form.dashboard') }}">
											<i class="fa fa-tasks"></i> Dashboard
											</a>
										</li>
										<li>
											<a href="{{ route('form.downtimes') }}">
											<i class="fa fa-list-alt"></i> Downtime List
											</a>
										</li>
										<li>
											<a href="#" onclick='window.open("{{ route('form.downtime_add') }}","displayWindow","toolbar=no,scrollbars=yes,width=1200,height=700");'>
											<i class="fa fa-plus"></i> Add Downtime
											</a>
										</li>
										
									</ul>
									<ul class="col-md-6 mega-menu-submenu">
										<li>
											<h3>Reports</h3>
										</li>
										<li><a href="#" onclick='window.open("maintenance/export.php?act=raw_data&startDate=2018-01-01&endDate={{ date('Y-m-d') }}","displayWindow","toolbar=no,scrollbars=yes,width=1200,height=500");'>Downtime Report</a></li>
										
									</ul>
									
								</div>
							</div>
						</li>
					</ul>
				</li>
				<li><a>|</a></li>	
				<li class="mega-menu-dropdown">
					<a data-hover="dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
					<i class="fa fa-automobile"></i> Vehicle Utilization <i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
						<li>
							<!-- Content container to add padding -->
							<div class="mega-menu-content">
								<div class="row">
									<ul class="col-md-6 mega-menu-submenu">
										<li>
											<h3>Utilization</h3>
										</li>
										<li>
											<a href="utilization/index.php">
											<i class="fa fa-tasks"></i> Dashboard
											</a>
										</li>
										<li>
											<a href="utilization/request_list.php">
											<i class="fa fa-list-alt"></i> Request List
											</a>
										</li>
										<li>
											<a href="utilization/request_list.php?addNewRequest=go">
											<i class="fa fa-plus"></i> Add Request
											</a>
										</li>
										<li>
											<a href="utilization/drivers.php">
											<i class="fa fa-group"></i> Drivers
											</a>
										</li>
										
									</ul>
									<ul class="col-md-6 mega-menu-submenu">
										<li>
											<h3>Reports</h3>
										</li>									
										<li><a href="dispatch-per-department-report.php"><i class="fa fa-building-o"></i> Dispatchs Distribution per Department</a></li>
										<li><a href="vehicles-no-dispatches-report.php"><i class="fa fa-send"></i> Top Vehicles by number of Dispatches</a></li>
										<li><a href="vehicles-distance-travelled-report.php"><i class="fa fa-truck"></i> Top Vehicles by Distance Travelled</a></li>
										<li><a href="destinations-report.php"><i class="fa fa-globe"></i> Top Frequent Destinations</a></li>
										<li><a href="rpt-trip-ticket-no.php"><i class="fa fa-tags"></i> Trip Tickets</a></li>
										<li><a href="vehicle-request-raw-data.php"><i class="fa fa-tags"></i> Vehicle Request Raw Data</a></li>
									</ul>
									
								</div>
							</div>
						</li>
					</ul>
				</li>

				<li><a>|</a></li>
				<li class="mega-menu-dropdown">
					<a data-hover="dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
					<i class="fa fa-cogs"></i> System Maintenance <i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
						<li>
							<!-- Content container to add padding -->
							<div class="mega-menu-content">
								<div class="row">
									<ul class="col-md-6 mega-menu-submenu">
										<li><a href="maintenance.php"><i class="fa fa-file"></i> Vehicle Maintenance</a></li>
										<li class="dropdown-submenu">
											<a href="javascript:;">
												<i class="fa fa-lock"></i> User Maintenance </a>
												<ul class="dropdown-menu">	
						          					<li><a href="user-maintenance.php"><i class="fa fa-user"></i> Individual User Maintenance</a></li>
						          					<!-- <li><a href="fuel-maintenance.php"><i class="fa fa-fire"></i> Fuel Maintenance</a></li> -->
						          					<li><a href="department-user-maintenance.php"><i class="fa fa-users"></i> Department User Maintenance</a></li>
						          				</ul>
				          				</li>
									</ul>
									
								</div>
							</div>
						</li>
					</ul>
				</li>										
			</ul>
		</div>
	
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<div class="top-menu">
			<ul class="nav navbar-nav pull-right">				
				<!-- BEGIN USER LOGIN DROPDOWN -->
				<li class="dropdown dropdown-extended dropdown-inbox" id="header_notification_bar">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="icon-bell"></i>
					<span class="badge badge-default" id="notification_total">
					0 </span>
					</a>
					
				</li>
				<li class="dropdown dropdown-quick-sidebar-toggler" style="color:white;">
					<br>
					<input type="hidden" value="" name="hidden_url" id="hidden_url">
				</li>
				<!-- END USER LOGIN DROPDOWN -->
				<!-- BEGIN QUICK SIDEBAR TOGGLER -->
				<li class="dropdown">
					<a href="login.php?act=logout" class="dropdown-toggle">
					<i class="icon-logout"></i>
					</a>
				</li>
				<!-- END QUICK SIDEBAR TOGGLER -->
			</ul>
		</div>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>
<div class="page-quick-sidebar-wrapper">
	<div class="page-quick-sidebar">
		<div class="nav-justified">	
			Messages 
			<a class="dropdown-quick-sidebar-toggler pull-right" href="#">Close</a>
			<div class="tab-content">
				<div class="tab-pane active page-quick-sidebar-alerts" id="quick_sidebar_tab_1">
					<div class="page-quick-sidebar-alerts-list">
						<div id="msg_chatarea"></div>
						<div id="msg_contents"></div>
					</div>
				</div>				
			</div>
		</div>
	</div>
</div>
<link rel="stylesheet" type="text/css" href="{{ asset('metronic/assets/global/plugins/bootstrap-toastr/toastr.min.css') }}"/>




<!-- END QUICK SIDEBAR -->




