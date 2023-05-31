<html>

<head>
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

    <link href="{{ asset('metronic/datepicker/bootstrap/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" media="screen">

    <script src="{{ asset('js/jquery.min.js') }}"></script>

</head>

<body class="page-header-fixed page-quick-sidebar-over-content page-full-width">
    <!-- BEGIN HEADER -->
    @include('layout.header')
    <!-- END HEADER -->
    <div class="clearfix"></div>
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
                                    <a href="{{ route('vehicle.request.list') }}"><i class="fa fa-list"></i> REQUEST
                                        LIST</a>
                                </li>
                                <li>
                                    <a href=""><i class="fa fa-tags"></i> TRIP DETAILS</a>
                                </li>
                                @if(strpos(Request::url(), 'edit') !== false)
                                    <li class="active"><i class="fa fa-edit"></i> UPDATE TRIP DETAILS</li>
                                @endif
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    @yield('content')
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

    </div>

</body>

@stack('metronic-scripts')
@stack('javascript')

</html>
