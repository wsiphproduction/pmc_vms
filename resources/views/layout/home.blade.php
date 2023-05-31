<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="utf-8"/>
	<title>VMS - PMC</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
	<meta content="" name="description"/>
	<meta content="" name="author"/>

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	@include('layout.head.styles.globalstyles')
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="{{ asset('metronic/assets/global/plugins/select2/select2.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('metronic/assets/admin/pages/css/login-soft.css') }}" rel="stylesheet" type="text/css"/>
	<!-- END PAGE LEVEL SCRIPTS -->
	<!-- BEGIN THEME STYLES -->
	<link href="{{ asset('metronic/assets/global/css/components.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('metronic/assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('metronic/assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css"/>
	<link id="style_color" href="{{ asset('metronic/assets/admin/layout/css/themes/default.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('metronic/assets/admin/layout/css/custom.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('css/requests-vehicle.css') }}" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- END THEME STYLES -->
	<link rel="shortcut icon" href="favicon.ico"/>
</head>

<!-- BEGIN INTERNAL STYLE -->
<style>
#clock {
    position: absolute;
    top: 0px;
    right: 0px;
    color:white;
    margin-right: 10px;
}
</style>
<!-- END INTERNAL STYLE -->

<!-- BEGIN SCRIPT -->
<script>
	function startTime() {
		var today = new Date();
		var h = today.getHours();
		var m = today.getMinutes();
		var s = today.getSeconds();
		m = checkTime(m);
		s = checkTime(s);
		document.getElementById('clock').innerHTML =
		"{{ date('F d Y') }}" + '&nbsp;' + h + ":" + m + ":" + s;
		var t = setTimeout(startTime, 500);
	}
	function checkTime(i) {
if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
return i;
}
</script>
<!-- END SCRIPT -->

<!-- BEGIN HOME -->
<body class="login" onload="startTime()">

	<div class="navbar navbar-trans navbar-fixed-top" role="navigation">
		<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
				{{-- <li class="dropdown">
					<a href="{{ route('logout') }}">
						<i style="color:orange;" class="icon-logout"></i>
						<strong style="color:orange"> {{ strtoupper(Auth::user()->fullname) ?? "" }}</strong>
						<img style="height:20px;" src="">
					</a>
				</li> --}}
				<li>&nbsp;</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				{{-- <li class="dropdown">
					<!-- <a href="/change-password"> -->
					 <a href="{{ route('change-pass') }}">
						<i style="color:orange;" class="icon-settings"></i>
						<strong style="color:orange"> CHANGE PASSWORD</strong>
						<img style="height:20px;" src="">
					</a> 
				</li> --}}
				<li>&nbsp;</li>
			</ul>

		</div>
	</div>      
	<div style="margin-top:60px;margin-right:3px;padding:15px;"class="bg-blue bg-font-blue" id="clock"></div>    

	<!-- BEGIN LOGO -->
	<div class="logo"><br><br></div>

	<div class="menu-toggler sidebar-toggler"></div>

    {{-- CONTENT --}}
    <div class="home">
        @yield('content')
    </div>
	<!-- END HOME -->
	<!-- BEGIN COPYRIGHT -->
	<div class="copyright">
		{{ date('Y') }} &copy; Philsaga Mining Corp.
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="{{ asset('metronic/assets/global/plugins/jquery-1.11.0.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/jquery-migrate-1.2.1.min.js' )}}" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
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
	<script src="{{ asset('metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/backstretch/jquery.backstretch.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/global/plugins/select2/select2.min.js') }}" type="text/javascript"></script>
	
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="{{ asset('metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
	<script src="{{ asset('metronic/assets/admin/pages/scripts/login-soft.js') }}" type="text/javascript"></script>
	
	<script src="{{ asset('hotkey/jquery.hotkeys.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<script src="{{ asset('js/vehicle_requests/requests-vehicle.js') }}" type="text/javascript"></script>
	<!-- END PAGE LEVEL SCRIPTS -->
	<script>
		jQuery(document).ready(function() {     
			Metronic.init(); // init metronic core components
			Layout.init(); // init current layout
			QuickSidebar.init() // init quick sidebar
			Login.init();

			// init background slide images
			$.backstretch([
				"metronic/assets/admin/pages/media/bg/1.jpg",
				"metronic/assets/admin/pages/media/bg/2.jpg",
				"metronic/assets/admin/pages/media/bg/3.jpg",
				"metronic/assets/admin/pages/media/bg/4.jpg"
				], {
					fade: 1000,
					duration: 8000
				});

			$(document).bind('keyup', '1', dashboard);
			$(document).bind('keyup', '2', downtime_list);
			$(document).bind('keyup', '3', add_new);
			$(document).bind('keyup', '4', maintenance);
			$(document).bind('keyup', '5', reports);
			$(document).bind('keyup', '6', user_manual);
			$(document).bind('keyup', '7', logout);

		});

		function dashboard(){
			window.location.href='{!! route('form.dashboard') !!}';
		}
		function downtime_list(){
			window.location.href='{!! route('downtime.downtimes') !!}';
		}
		function add_new(){
			window.open('{!! route('downtime.create') !!}','displayWindow","toolbar=no,scrollbars=yes,width=1200,height=700');
		}
		function maintenance(){
			window.location.href='{!! route('form.maintenance') !!}';
		}
		function reports(){
			window.open('{!! route('maintenance.export', ['type' => 'raw_data']) !!}','displayWindow','toolbar=no,scrollbars=yes,width=1200,height=500');
		}
		function user_manual(){
			window.open("http://mlappsvr.philsaga.com/PMC-VMS/public/storage/VMS%20Manual.pdf","displayWindow","toolbar=no,scrollbars=yes,width=1200,height=500");
		}
		function logout(){
			window.location.href='{!! route('logout') !!}';
		}
		

	</script>

</body>

</html>
