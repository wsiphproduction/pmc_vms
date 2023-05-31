<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
	<meta charset="utf-8" />
	<title>ESD | Monitoring</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />

	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	@include('layout.head.styles.globalstyles')
	<!-- END GLOBAL MANDATORY STYLES -->

	<link rel="stylesheet" type="text/css"
		href="{{ asset('metronic/assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('metronic/assets/global/plugins/select2/select2.css') }}" />
	<link rel="stylesheet" type="text/css"
		href="{{ asset('metronic/assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" />

	<link rel="stylesheet" type="text/css"
		href="{{ asset('metronic/assets/global/plugins/clockface/css/clockface.css') }}" />
	<link rel="stylesheet" type="text/css"
		href="{{ asset('metronic/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}" />
	<link rel="stylesheet" type="text/css"
		href="{{ asset('metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" />
	<link rel="stylesheet" type="text/css"
		href="{{ asset('metronic/assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css') }}" />
	<link rel="stylesheet" type="text/css"
		href="{{ asset('metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css') }}" />
	<link rel="stylesheet" type="text/css"
		href="{{ asset('metronic/assets/global/plugins/bootstrap-datetimepicker/css/datetimepicker.css') }}" />

	<!-- END PAGE LEVEL PLUGIN STYLES -->
	<!-- BEGIN PAGE STYLES -->
	<link href="{{ asset('metronic/assets/admin/pages/css/tasks.css') }}" rel="stylesheet" type="text/css" />
	<!-- END PAGE STYLES -->
	<!-- BEGIN THEME STYLES -->
	<link href="{{ asset('metronic/assets/global/css/components.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('metronic/assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('metronic/assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css" />
	<link id="style_color" href="{{ asset('metronic/assets/admin/layout/css/themes/default.css') }}" rel="stylesheet"
		type="text/css" />
	<link href="{{ asset('metronic/assets/admin/layout/css/custom.css') }}" rel="stylesheet" type="text/css" />


	<!-- END THEME STYLES -->
	<link rel="shortcut icon" href="favicon.ico" />
	<style>
		.popover-title {
			color: black;

		}

		.popover-content {
			color: black;

		}
	</style>
</head>

<body style="background-color:white;">

	<!-- BEGIN CONTAINER -->
	@yield('content')
	<!-- END CONTAINER -->

	<script src="{{ asset('metronic/assets/global/plugins/jquery-1.11.0.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/jquery-migrate-1.2.1.min.js') }}" type="text/javascript">
	</script>
	<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="{{ asset('metronic/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}"
		type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript">
	</script>
	<script src="{{ asset('metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}"
		type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"
		type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/jquery.cokie.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript">
	</script>
	<script src="{{ asset('metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"
		type="text/javascript"></script>

	<script type="text/javascript"
		src="{{ asset('metronic/assets/global/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/select2/select2.min.js') }}"></script>
	<script type="text/javascript"
		src="{{ asset('metronic/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"></script>
	<script src="{{ asset('metronic/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>

	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="{{ asset('metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/notifications.js') }}"></script>
	<script src="{{ asset('js/comments.js') }}"></script>
	@stack('javascript')

	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->

</html>