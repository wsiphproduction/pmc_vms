<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>ECS Vehicle Request</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />


    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    @include('layout.head.styles.globalstyles')
    <!-- END GLOBAL MANDATORY STYLES -->

    <link href="{{ asset('metronic/assets/global/plugins/select2/select2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/assets/admin/pages/css/login-soft.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/assets/global/css/components.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css" />
    <link id="style_color" href="{{ asset('metronic/assets/admin/layout/css/themes/default.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/assets/admin/layout/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico" />
    
</head>

<body class="login">

    <div class="logo" style="font-size:30px;color:white;">
        @if(Request::path() !== 'request')
        Vehicle Monitoring System
        @else
        <img src="{{ asset('metronic/ecs.png') }}" alt="" width="400">
        @endif
    </div>

    <div class="menu-toggler sidebar-toggler">
    </div>

    <!-- Content -->

    <div class="content">
       
        @yield('content')
    </div>

    <!-- Content -->

    <!-- END LOGIN -->
    <!-- BEGIN COPYRIGHT -->
    <div class="copyright">
        {{ date('Y') }} &copy; Philsaga Mining Corporation
    </div>
    <!-- END COPYRIGHT -->
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    <!--[if lt IE 9]>
    <script src="metronic/assets/global/plugins/respond.min.js"></script>
    <script src="metronic/assets/global/plugins/excanvas.min.js"></script> 
    <![endif]-->
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
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{ asset('metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/global/plugins/backstretch/jquery.backstretch.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="metronic/assets/global/plugins/select2/select2.min.js"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ asset('metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/admin/pages/scripts/login-soft.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
        jQuery(document).ready(function() {
            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout
            QuickSidebar.init() // init quick sidebar
            Login.init();

            // init background slide images
            $.backstretch([
                "{{ asset('metronic/assets/admin/pages/media/bg/1.jpg') }}",
                "{{ asset('metronic/assets/admin/pages/media/bg/2.jpg') }}",
                "{{ asset('metronic/assets/admin/pages/media/bg/3.jpg') }}",
                "{{ asset('metronic/assets/admin/pages/media/bg/4.jpg') }}"
            ], {
                fade: 1000,
                duration: 8000
            });
        });
    </script>
    <script>
        jQuery('#noaccount').click(function() {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
        });

        
    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->

</html>