<!DOCTYPE html>
<html lang="en">



<head>
   @if(Request::is('vehicle/dispatch/*'))
   @include('layout.head.dispatch')
   @else
   @include('layout.head.utilization')
   @endif
   <style>
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
   @include('layout.header')
   <div class="clearfix"></div>
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
         <?php echo date('Y'); ?> &copy; PMC - ICT.
      </div>
      <div class="page-footer-tools">
         <span class="go-top">
            <i class="fa fa-angle-up"></i>
         </span>
      </div>
   </div>

   @if(Request::is('vehicle/dispatch/*'))
   @else
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
   <!-- BEGIN PAGE LEVEL PLUGINS -->
   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/select2/select2.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>
   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/clockface/js/clockface.js')}}"></script>
   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/bootstrap-daterangepicker/moment.min.js')}}"></script>
   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>

   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
   
   <script src="{{ asset('metronic/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
   <script src="{{ asset('metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
   <script src="{{ asset('metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
   <script src="{{ asset('metronic/assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
   <script src="{{ asset('js/excel/src/jquery.table2excel.js') }}"></script>
   <script src="{{ asset('metronic/assets/admin/pages/scripts/components-pickers.js') }}"></script>
   <script src="{{ asset('js/notifications.js') }}"></script>
   <script src="{{ asset('js/comments.js') }}"></script>
   @yield('javascript')
   @stack('script')
   @endif


   <!-- END JAVASCRIPTS -->
</body>

@if (Request::is('vehicle/dispatch/*'))
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
<script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"></script>

<script src="{{ asset('metronic/assets/global/plugins/jquery.pulsate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('metronic/datepicker/js/jquery-1.8.3.min.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('metronic/datepicker/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
   <script src="{{ asset('js/excel/src/jquery.table2excel.js') }}"></script>
<script src="{{ asset('js/notifications.js') }}"></script>
<script src="{{ asset('js/comments.js') }}"></script>
@yield('javascript')
@stack('script')

@endif
<script>
      function exportToExcel(table){
         $('#filter_head').remove();
            jQuery(table).table2excel({
               name: "VMS",
               filename: "VMS" ,//do not include extension
               exclude_img: true,
               exclude_links: true,
               exclude_inputs: true,
               exclude: ".noExl",

            }); 
         }
   </script>

<script>
   jQuery(document).ready(function() {    
            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout
            TableAdvanced.init();
            //exportToExcel('#maintenance_excel');
         });
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
<script>
      var TableAdvanced = function () {


            var initTable4 = function () {
               var table = $('#sample_4');


               var oTable = table.dataTable({
                  "columnDefs": [{
                     "orderable": false,
                     "targets": [0]
                  }],
                  "order": [
                  [0, 'desc']
                  ],
                  "lengthMenu": [
                  [5, 15, 20, -1],
                  [5, 15, 20, "All"] 
                  ],
                  "pageLength": 300,
                  });

var tableWrapper = $('#sample_4_wrapper');
var tableColumnToggler = $('#sample_4_column_toggler');

tableWrapper.find('.dataTables_length select').select2(); 
//var hidden_fields = [4,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24];
var hidden_fields = [];
for (i = 0; i < hidden_fields.length; i++) {
    oTable.fnSetColumnVis(hidden_fields[i], false);
}

$('input[type="checkbox"]', tableColumnToggler).change(function () {
   /* Get the DataTables object again - this is not a recreation, just a get of the object */
   var iCol = parseInt($(this).attr("data-column"));
   var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
   //alert(iCol+' = '+bVis);
   oTable.fnSetColumnVis(iCol, (bVis ? false : true));
});
}



return {


   init: function () {

      if (!jQuery().dataTable) {
         return;
      }

      initTable4();
      
   }

};

}();
   </script>
<!-- END BODY -->

</html>