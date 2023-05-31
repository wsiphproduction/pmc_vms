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
   <link rel="stylesheet" type="text/css" href="{{ asset('metronic/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }}" />
   <link rel="stylesheet" type="text/css" href="{{ asset('metronic/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css') }}" />
   <link rel="stylesheet" type="text/css" href="{{ asset('metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}" />


   <!-- BEGIN THEME STYLES -->
   <link href="{{ asset('metronic/assets/global/css/components.css') }}" rel="stylesheet" type="text/css" />
   <link href="{{ asset('metronic/assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css" />
   <link href="{{ asset('metronic/assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css" />
   <link id="style_color" href="{{ asset('metronic/assets/admin/layout/css/themes/default.css') }}" rel="stylesheet" type="text/css" />
   <link href="{{ asset('metronic/assets/admin/layout/css/custom.css') }}" rel="stylesheet" type="text/css" />

   <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />
   <link href="{{ asset('css/requests-vehicle.css') }}" rel="stylesheet" type="text/css" />
   <link rel="stylesheet" href="{{ asset('datatables/dataTables.bootstrap4.min.css') }}">
   <link rel="stylesheet" href="{{ asset('datatables/jquery.dataTables.min.css') }}">
   <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->

   <!-- END THEME STYLES -->
   <link rel="shortcut icon" href="favicon.ico" />

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/css/uikit.min.css" />
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

<body style="background-color: #fff;" class="page-header-fixed page-quick-sidebar-over-content page-full-width">
   <!-- BEGIN HEADER -->
   @include('layout.header')
   <!-- END HEADER -->

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

   <!-- Scripts -->
   <!-- UIkit JS -->
   <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/js/uikit.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/js/uikit-icons.min.js"></script>
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="{{ asset('datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
   <script src="{{ asset('datatables/dataTables.bootstrap4.min.js') }}" type="text/javascript"></script>
   <script src="{{ asset('js/vehicle_requests/requests-vehicle.js') }}" type="text/javascript"></script>

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

   <script src="{{ asset('metronic/assets/global/plugins/jquery.pulsate.min.js') }}" type="text/javascript"></script>

   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/select2/select2.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>
   <script src="{{ asset('metronic/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>


   <script src="{{ asset('metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
   <script src="{{ asset('metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
   <script src="{{ asset('metronic/assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
   <script src="{{ asset('js/excel/src/jquery.table2excel.js') }}"></script>
   <script src="{{ asset('js/notifications.js') }}"></script>
   <script src="{{ asset('js/comments.js') }}"></script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

   <!-- END JAVASCRIPTS -->
   <script>
      $(document).ready(function() {
         function setSelectedIndex(s, i) {
            console.log(i)
            s.options[i].selected = true
            return
         }

         $('#dataTableRequests').DataTable({
            initComplete: function(settings, json) {
               $('.edit-btn').click(function() {
                  var id = $(this).attr('value')
                  $('#edit-request-modal').modal({
                     'show': true
                  })

                  $.ajax({
                     url: `/vehicle/${id}/request`,
                     type: 'GET',
                     success: function(data) {
                        document.getElementById('vehicle-request-form-edit').value = data.id
                        setSelectedIndex(document.getElementById('departments-select-edit'), data.dept_id)
                        document.getElementById("date_needed-edit").value = data.date_needed
                        $('#costCode-edit').attr('value', data.costcode)
                        $('#purpose-edit').attr('value', data.purpose)
                     }
                  })
               })

               $('.comment-action-btn').click(function() {
                  var id = $(this).attr('value')
                  $('#add-message-modal').modal({
                     'show': true
                  })

                  $('#vehicle-request-message').attr('action', '/vehicle/request/' + id + '/message')
               })
            },
            processing: true,
            language: {
               processing: '<span>Processing'
            },
            responsive: true,
            order: [
               [0, 'desc']
            ],
            // serverSide: true,
            searching: false,
            lengthChange: false,
            ajax: '{{ empty($route) ? '
            ':route($route) }}',
            columns: [{
                  data: 'id'
               },
               {
                  data: 'dept'
               },
               {
                  data: 'date_needed'
               },
               {
                  data: 'created_at'
               },
               {
                  data: 'purpose'
               },
               {
                  data: 'last_message'
               },
               {
                  data: 'status'
               },
               {
                  data: 'tripTicket',
                  render: function(data) {
                     return $('<textarea />').html(data).text()
                  }
               },
               {
                  data: 'action',
                  searchable: true,
                  orderable: false
               },
            ]
         })

      })
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
</body>
<!-- END BODY -->

</html>