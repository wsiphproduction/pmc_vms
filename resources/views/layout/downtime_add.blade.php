<!DOCTYPE html>
<html lang="en">
<html>
	<head>
		<title>Add Downtime</title>
		<!-- BEGIN GLOBAL MANDATORY STYLES -->
		@include('layout.head.styles.globalstyles')
		<!-- END GLOBAL MANDATORY STYLES -->

		<link rel="stylesheet" type="text/css" href="{{ asset('metronic/assets/global/plugins/chosen/chosen.min.css') }}"/>
		<link rel="stylesheet" type="text/css" href="{{ asset('metronic/assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
		<link rel="stylesheet" type="text/css" href="{{ asset('metronic/assets/global/plugins/select2/select2.css') }}"/>
		<link rel="stylesheet" type="text/css" href="{{ asset('metronic/assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>

		<!-- BEGIN THEME STYLES -->
		<link href="{{ asset('metronic/assets/global/css/components.css') }}" rel="stylesheet" type="text/css"/>
		<link href="{{ asset('metronic/assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
		<link href="{{ asset('metronic/assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css"/>
		<link id="style_color" href="{{ asset('metronic/assets/admin/layout/css/themes/default.css') }}" rel="stylesheet" type="text/css"/>
		<link href="{{ asset('metronic/assets/admin/layout/css/custom.css') }}" rel="stylesheet" type="text/css"/>
	</head>

	<style>
	.chosen-container {
		width: 100% !important;
	}
	</style>

    <body style="background-color:white;">
		<!-- BEGIN CONTAINER -->
		@yield('content')
		<!-- END CONTAINER -->
    </body>

	<script src="{{ asset('metronic/assets/global/plugins/jquery-1.11.0.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/jquery-migrate-1.2.1.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/jquery.cokie.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
	<!-- END CORE PLUGINS -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/select2/select2.min.js') }}"></script>
   	<script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/chosen/chosen.jquery.min.js') }}"></script>
   	<script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/chosen/chosen.proto.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"></script>
	<script src="{{ asset('metronic/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>

	<script src="{{ asset('metronic/assets/global/plugins/jquery.pulsate.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/notifications.js') }}"></script>
	<script src="{{ asset('js/comments.js') }}"></script> 

	@stack('javascript')

</html>