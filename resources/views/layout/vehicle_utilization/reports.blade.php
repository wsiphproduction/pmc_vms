<head>
    <meta charset="utf-8" />
    <title>Vehicle Monitoring System</title>
    
    @include('layout.head.styles.globalstyles');
    <!-- END GLOBAL MANDATORY STYLES -->


    <link rel="stylesheet" type="text/css" href="{{asset('metronic/assets/global/plugins/bootstrap-select/bootstrap-select.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('metronic/assets/global/plugins/select2/select2.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('metronic/assets/global/plugins/jquery-multi-select/css/multi-select.css')}}" />


    <!-- BEGIN THEME STYLES -->
    <link href="{{asset('metronic/assets/global/css/components.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic/assets/global/css/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic/assets/admin/layout/css/layout.css')}}" rel="stylesheet" type="text/css" />
    <link id="style_color" href="{{asset('metronic/assets/admin/layout/css/themes/default.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic/assets/admin/layout/css/custom.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('metronic/datepicker/bootstrap/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" media="screen">

    <script src="{{asset('charts/chart/js/fusioncharts.js')}}"></script>
    <script src="{{asset('charts/chart/js/themes1/fusioncharts.theme.fusion.js')}}"></script>

    <script src="{{asset('js/jquery.min.js')}}"></script>


    <style type="text/css">
        @page {
            size: auto;
            margin: 0;
        }

        @media print {
            #chart-1 {
                display: none;
            }

            #form {
                display: none;
            }

            #print-b {
                display: none;
            }

            #excel-b {
                display: none;
            }

        }
    </style>
</head>

<body class="page-header-fixed page-quick-sidebar-over-content page-full-width">
    <!-- BEGIN HEADER -->
    @include('layout.header')
    <div class="clearfix"></div>
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN CONTENT -->
        @yield('content')
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
    <script src="{{asset('metronic/assets/global/plugins/jquery-1.11.0.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('metronic/assets/global/plugins/jquery-migrate-1.2.1.min.js')}}" type="text/javascript"></script>
    <!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
    <script src="{{asset('metronic/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('metronic/assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('metronic/assets/global/plugins/jquery.cokie.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('metronic/assets/global/plugins/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>

    <script src="{{asset('metronic/assets/global/plugins/jquery.pulsate.min.js')}}" type="text/javascript"></script>

    <script type="text/javascript" src="{{asset('metronic/assets/global/plugins/select2/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('metronic/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('metronic/assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('metronic/assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('metronic/assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('metronic/assets/global/plugins/bootstrap-toastr/toastr.min.js')}}"></script>


    <script src="{{asset('metronic/assets/global/scripts/metronic.js')}}" type="text/javascript"></script>
    <script src="{{asset('metronic/assets/admin/layout/scripts/layout.js')}}" type="text/javascript"></script>
    <script src="{{asset('metronic/assets/admin/layout/scripts/quick-sidebar.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/excel/src/jquery.table2excel.js')}}"></script>

    <script type="text/javascript" src="{{asset('metronic/datepicker/js/bootstrap-datetimepicker.js')}}" charset="UTF-8"></script>
    <script src="{{asset('js/notifications.js')}}"></script>
    <script src="{{asset('js/comments.js')}}"></script>
    @yield('javascript')
</body>
<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        ComponentsDropdowns.init();

    });

    $('.form_date').datetimepicker({
        language: 'en',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
</script>
<!-- END BODY -->

</html>