<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Vehicle | Monitoring</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />

  <!-- BEGIN GLOBAL MANDATORY STYLES -->
  @include('layout.head.styles.globalstyles')
  <!-- END GLOBAL MANDATORY STYLES -->

  <link rel="stylesheet" type="text/css" href="{{ asset('metronic/assets/global/plugins/select2/select2.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}" />


  <!-- BEGIN THEME STYLES -->
  <link href="{{ asset('metronic/assets/global/css/components.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('metronic/assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('metronic/assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css" />
  <link id="style_color" href="{{ asset('metronic/assets/admin/layout/css/themes/default.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('metronic/assets/admin/layout/css/custom.css') }}" rel="stylesheet" type="text/css" />
  

<link href="{{ url('plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
  <!-- END THEME STYLES -->
  <link rel="shortcut icon" href="favicon.ico" />
  <style>
    .popover-title {
      color: black;
    }

    .popover-content {
      color: black;
    }

    #dashboard_div {
      padding-left: 340px;
    }

    #dashboard_div table {
      border-collapse: separate;
      /*border-top: 3px solid; */
    }

    #dashboard_div td,
    th {
      margin: 0;
      /*  border:3px solid grey;
         border-top-width:0px;*/
      white-space: nowrap;
    }

    #dashboard_div .headcol {
      position: absolute;
      width: 28em;
      left: 28px;
      top: auto;
      border-right: 0px none;
      /* border-top-width:3px; 
         margin-top:-3px; compensate for top border*/
      background-color: white;
    }

    #dashboard_div .headcol:before {
      content: '';
    }

    #dashboard_div .long {
      background: yellow;
      letter-spacing: 1em;
    }

    /* The Modal (background) */
    #myModal1 {
      display: none;
      /* Hidden by default */
      position: fixed;
      /* Stay in place */
      z-index: 1;
      /* Sit on top */
      left: 0;
      top: 0;
      width: 100%;
      /* Full width */
      height: 100%;
      /* Full height */
      overflow: auto;
      /* Enable scroll if needed */
      background-color: rgb(0, 0, 0);
      /* Fallback color */
      background-color: rgba(0, 0, 0, 0.4);
      /* Black w/ opacity */
    }

    /* Modal Content/Box */
    #content {
      background-color: #fefefe;
      margin: 15% auto;
      /* 15% from the top and centered */
      padding: 20px;
      border: 1px solid #888;
      width: 45%;
      /* Could be more or less, depending on screen size */
    }

    /* The Close Button */
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }
  </style>
</head>

<body class="page-header-fixed page-quick-sidebar-over-content page-full-width">
  <!-- BEGIN HEADER -->
  <div class="clearfix">
    @include('layout.header')
  </div>
  <!-- BEGIN CONTAINER -->
  <div class="page-container">
    <!-- BEGIN CONTENT -->
    <div id="myModal1" class="modal">
      <!-- Modal content -->
      <div class="modal-content" id="content">
        <span class="close" id="close">&times;</span>
        <p style="font-size: 18px; font-weight:bold;">In exactly 1 hour the system will undergo maitenance! Please save your work!</p>
      </div>
    </div>
    <div>
      @if($reason)
      <div class="alert alert-danger alert-dismissable">
        <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button> -->
        <span class="fa fa-exclamation"></span>
        <label aria-labelledby="notifications" id="notifications">{{ $reason }} </label>
        <label aria-labelledby="countdown" id="countdown" style="float:right; font-weight:bold">Time Remaining : </label>
        <label aria-labelledby="datetime" id="datetime" style="display:block">Shutdown Date : {{ $scheduledate }} {{ $scheduletime}} </label>
      </div>
      @else
      <label aria-labelledby="countdown" id="countdown" style="display:none; font-weight:bold">Time Remaining : </label>
      @endif
    </div>
    @yield('content')
    <!-- END CONTENT -->
  </div>
  <!-- END CONTAINER -->
  <!-- BEGIN FOOTER -->
  <div class="page-footer">
    <div class="page-footer-inner">
      {{ date('Y') }} &copy; PMC - ICT.
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
  <script src="{{ asset('metronic/assets/global/plugins/jquery.cokie.min.js')}}" type="text/javascript"></script>
  <script src="{{ asset('metronic/assets/global/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>

  <script src="{{ asset('metronic/assets/global/plugins/jquery.pulsate.min.js') }}" type="text/javascript"></script>

  <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/select2/select2.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>
  <script src="{{ asset('metronic/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>

  <script src="{{ asset('metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
  <script src="{{ asset('metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
  <script src="{{ asset('metronic/assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
  <script src="{{ asset('metronic/assets/admin/pages/scripts/table-managed.js') }}"></script>
  <script src="{{ asset('js/notifications.js') }}"></script>
  <script src="{{ asset('js/comments.js') }}"></script>
<script src="{{ url('plugins/datatables/datatable.js') }}" type="text/javascript"></script>
<script src="{{ url('plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>

<script src="{{ url('plugins/datatables/table-datatables-buttons.js') }}" type="text/javascript"></script>

  @stack('javascript')
  <script>
    var modal = document.getElementById("myModal1");
    var tday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var tmonth = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var shown = 0;
    var span = document.getElementById("close");
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }

    function GetClock() {
      var d = new Date();
      var nday = d.getDay(),
        nmonth = d.getMonth(),
        ndate = d.getDate(),
        nyear = d.getFullYear();
      var nhour = d.getHours(),
        nmin = d.getMinutes(),
        nsec = d.getSeconds(),
        ap;
      var ohour = nhour + 1;
      if (nhour <= 9) nhour = "0" + nhour;
      if (nhour == 0) {
        ap = " AM";
        nhour = 12;
      } else if (nhour < 12) {
        ap = " AM";
      } else if (nhour == 12) {
        ap = " PM";
      } else if (nhour > 12) {
        ap = " PM";
        nhour -= 12;
      }

      if (nmin <= 9) nmin = "0" + nmin;
      if (nsec <= 9) nsec = "0" + nsec;

      var clocktext = "" + tday[nday] + ", " + tmonth[nmonth] + " " + ndate + ", " + nyear + " " + nhour + ":" + nmin + ":" + nsec + ap + "";
      // document.getElementById('clockbox').innerHTML = clocktext;
      var schedule = {!!json_encode($scheduledate) !!} + ' ' + {!!json_encode($scheduletime) !!};
      // dt = dt.replace(':00.0000000','');
      var mnth = nmonth + 1;
      var dte = ndate;
      if (mnth <= 9) mnth = "0" + mnth;
      if (dte <= 9) dte = "0" + dte;
      var curDateless1hour = nyear + '-' + mnth + '-' + dte + ' ' + ohour + ":" + nmin;
      var curDate = nyear + '-' + mnth + '-' + dte + ' ' + (ohour - 1) + ":" + nmin;
      // console.log(dt);
      // console.log(dd2);
      if (schedule == curDateless1hour && shown == 0) {
        shown = 1;
        //    alert("In exactly 1 hour the system will undergo maitenance! Please save your work.");

        modal.style.display = "block";
        return false;
      }
      if (schedule == curDate) {
        $.ajax({
          url: '{!! route('maintenance.application.systemDown') !!}',
          type: 'GET',
          async: false,
          success: function(response) {}
        });
      }
      // console.log(schedule);
      // console.log(curDate);
      if (schedule > curDate) {
        var TimeDiff = timeDiffCalc(new Date(schedule), new Date());
      } else {
        TimeDiff = "Maintenance is in progress!";
      }

      document.getElementById('countdown').innerHTML = "Time Remaining : " + TimeDiff;
    }
    GetClock();
    setInterval(GetClock, 1000);

    function timeDiffCalc(dateFuture, dateNow) {
      // console.log(dateNow);
      let diffInMilliSeconds = Math.abs(dateFuture - dateNow) / 1000;
      // calculate days
      const days = Math.floor(diffInMilliSeconds / 86400);
      diffInMilliSeconds -= days * 86400;

      // calculate hours
      const hours = Math.floor(diffInMilliSeconds / 3600) % 24;
      diffInMilliSeconds -= hours * 3600;

      // calculate minutes
      const minutes = Math.floor(diffInMilliSeconds / 60) % 60;
      diffInMilliSeconds -= minutes * 60;

      // calculate minutes
      const seconds = Math.floor(diffInMilliSeconds);
      diffInMilliSeconds -= seconds;
      // if(seconds > 0){

      let difference = '';
      if (days > 0) {
        difference += (days === 1) ? `${days} day, ` : `${days} days, `;
      }

      difference += (hours === 0 || hours === 1) ? `${hours} hour, ` : `${hours} hours, `;

      difference += (minutes === 0 || hours === 1) ? `${minutes} minute, ` : `${minutes} minutes, `;

      difference += (seconds === 0 || seconds === 1) ? `${seconds} seconds` : `${seconds} seconds`;

      return difference;
      // }
    }
  </script>

  <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->

</html>