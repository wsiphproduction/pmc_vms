@extends('layout.forms')

@section('content')
<div class="page-content-wrapper">
   <div class="page-content">
      @if(Session::has('success'))

      <script>
         setTimeout(function() {
            $('#success').fadeOut();
         }, 3000);
      </script>

      <div id="success" class="alert alert-success alert-dismissable">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
         <strong><span class="fa fa-check-square-o"></span> Success!</strong> {{ Session::get('success') }}
      </div>
      @endif

      @if(Session::has('error'))

      <script>
         setTimeout(function() {
            $('#error').fadeOut();
         }, 3000);
      </script>
      <div id="error" class="alert alert-danger alert-dismissable">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
         <strong><span class="fa fa-warning"></span> Error!</strong> {{ Session::get('error') }}
      </div>

      @endif
      @if ($errors->any())
      <script>
         $('#error_any').fadeOut();
      </script>
      <div id="error_any" class="alert alert-danger alert-dismissable">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
         <strong><span class="fa fa-warning"></span> Error!</strong> {{ $errors->first() }}
      </div>
      @endif
      <form method="get" action="{{ route('form.dashboard') }}">
         <div class="row">
            <div class="col-md-12">
               <!-- BEGIN PAGE TITLE & BREADCRUMB-->
               <h3 class="page-title">
                  Vehicle <small>Downtime Records</small>
               </h3>
               <ul class="page-breadcrumb breadcrumb">
                  <li>
                     <a href="#">Range:</a>
                  </li>
                  <li>
                     <input type="date" name="startDate" value="{{ Request::get('startDate') }}">
                  </li>
                  <li id="typelist">
                     <input type="date" name="endDate" value="{{ Request::get('endDate') }}">
                  </li>
                  <li>
                     <input type="submit" class="btn green btn-sm" value="Go">
                     <a href="{{ route('form.dashboard') }}" class="btn purple btn-sm" style="color:white;">Reset</a>
                  </li>
                  <li class="pull-right" style="position:relative;top:5px;">
                     <div id="dashboard-report-range" class="dashboard-date-range tooltips" data-placement="top" data-original-title="Change dashboard date range">
                        <i class="icon-calendar"></i>
                        <span></span>
                        <i class="fa fa-angle-down"></i>
                     </div>
                  </li>
               </ul>
               <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
         </div>
      </form>
      <input type="hidden" name="hiddenstart" id="hiddenstart" value="">
      <input type="hidden" name="hiddenend" id="hiddenend" value="">
      <div class="clearfix">
      </div>

      <div class="row ">
         <div class="col-md-6 col-sm-6">
            <div class="portlet box blue-steel">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-download"></i>Recent Downtime Logs
                  </div>
               </div>
               <div class="portlet-body">
                  <table class="table table-striped table-bordered table-hover" id="sample_1" style="font-size:11px;">
                     <thead>
                        <tr>
                           <th>ID</th>
                           <th>Unit</th>
                           <th>Start</th>
                           <th>End</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($result as $item)
                        <tr>
                           <td>{{$item->id}} </td>
                           <td>{{$item->uni}} ({{$item->type}})</td>
                           <td>{{$item->ds}} </td>
                           <td>{{$item->de}} </td>
                           <td style="width:100px;"><a href="#" class="btn purple btn-xs" onclick='window.open("{{ route('downtime.downtime_edit', ["id" => $item->id ]) }}","displayWindow","toolbar=no,scrollbars=yes,width=1200,height=700");return false;'><i class="fa fa-edit"></i></a>
                              <a href="#" class="btn red btn-xs deletedl" data="{{ $item->id }}"><i class="fa fa-minus-circle" data-toggle="modal" href="#delete{{$item->id}}"></i></a>
                              <div class="modal fade" id="delete{{$item->id}}" tabindex="-1" role="basic" aria-hidden="true">
                                 <div class="modal-dialog">
                                    <form action="{{route('downtime.downtime_destroy',  ['id' =>  $item->id])}}"  method="POST">
                                       @csrf

                                       @method('DELETE')
                                       <div class="modal-content">
                                          <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                             <h4 class="modal-title"><b>Confirmation</b></h4>
                                          </div>
                                          <div class="modal-body"> Are you sure you want to <b>delete</b> this downtime? </div>
                                          <div class="modal-footer">
                                             <button type="button" class="btn btn-circle dark btn-outline" data-dismiss="modal">Close</button>
                                             <button type="submit" name="delete_downtime" class="btn btn-circle red"> Delete</button>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-sm-6">
            <div class="portlet box  green-haze">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-check-square-o"></i>Repair Hours by Category
                  </div>
               </div>
               <div class="portlet-body">
                  <iframe src="{{ route('downtime.repairhours', ['start' =>  request()->get('start'), 'end' =>  request()->get('end')]) }}" style="overflow : hidden;" frameborder="0" width="100%" scrolling="no" height="400" style="-webkit-transform:scale(1.1);-moz-transform-scale(1.1);">
                  </iframe>
               </div>
            </div>
         </div>
      </div>
      <div class="clearfix">
      </div>

      <div class="row">
         <div class="col-md-6 col-sm-6">
            <div class="portlet solid grey-cararra bordered">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-check-square-o"></i>MTD % Availability Due to Breakdown: Light Vehicle
                  </div>
               </div>
               <div class="portlet-body">
                  <iframe src="{{ route('downtime.mtdLightVehicle', ['start' =>  request()->get('start'), 'end' =>  request()->get('end')]) }}" style="overflow : hidden;" frameborder="0" width="100%" scrolling="no" height="200" style="-webkit-transform:scale(1.1);-moz-transform-scale(1.1);"></iframe>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-sm-6">
            <div class="portlet solid grey-cararra bordered">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-check-square-o"></i>MTD % Availability Due to Breakdown: Medium Vehicle
                  </div>
               </div>
               <div class="portlet-body">
                  <iframe src="{{ route('downtime.mtdMediumVehicle', ['start' =>  request()->get('start'), 'end' =>  request()->get('end')]) }}" style="overflow : hidden;" frameborder="0" width="100%" scrolling="no" height="200" style="-webkit-transform:scale(1.1);-moz-transform-scale(1.1);"></iframe>
               </div>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-md-6 col-sm-6">
            <div class="portlet solid grey-cararra bordered">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-check-square-o"></i>Repair Hours by Repair Type
                  </div>
               </div>
               <div class="portlet-body">
                  <iframe src="{{ route('downtime.repairtype', ['start' =>  request()->get('start'), 'end' =>  request()->get('end')]) }}" style="overflow : hidden;" frameborder="0" width="100%" scrolling="no" height="200" style="-webkit-transform:scale(1.1);-moz-transform-scale(1.1);"></iframe>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-sm-6">
            <div class="portlet solid grey-cararra bordered">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-check-square-o"></i>MTD % Availability Due to Breakdown: Heavy Vehicle
                  </div>
               </div>
               <div class="portlet-body">
                  <iframe src="{{ route('downtime.mtdHeavyVehicle', ['start' =>  request()->get('start'), 'end' =>  request()->get('end')]) }}" style="overflow : hidden;" frameborder="0" width="100%" scrolling="no" height="200" style="-webkit-transform:scale(1.1);-moz-transform-scale(1.1);"></iframe>
               </div>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-md-6 col-sm-6">
            <div class="portlet solid grey-cararra bordered">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-check-square-o"></i>Man Hours Distribution
                  </div>
               </div>
               <div class="portlet-body">
                  <iframe src="{{ route('downtime.manhours', ['start' =>  request()->get('start'), 'end' =>  request()->get('end')]) }}" style="overflow : hidden;" frameborder="0" width="100%" scrolling="no" height="200" style="-webkit-transform:scale(1.1);-moz-transform-scale(1.1);"></iframe>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-sm-6">
            <div class="portlet solid grey-cararra bordered">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-check-square-o"></i>MTD % Availability Due to Breakdown: Motorcycle
                  </div>
               </div>
               <div class="portlet-body">
                  <iframe src="{{ route('downtime.mtdMotor', ['start' =>  request()->get('start'), 'end' =>  request()->get('end')]) }}" style="overflow : hidden;" frameborder="0" width="100%" scrolling="no" height="200" style="-webkit-transform:scale(1.1);-moz-transform-scale(1.1);"></iframe>
               </div>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-md-6 col-sm-6">
            <div class="portlet solid grey-cararra bordered">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-check-square-o"></i>Top 10 Repair Hours: Light Vehicle
                  </div>
               </div>
               <div class="portlet-body">
                  <iframe src="{{ route('downtime.rpLightVehicle', ['start' =>  request()->get('start'), 'end' =>  request()->get('end')]) }}" style="overflow : hidden;" frameborder="0" width="100%" scrolling="no" height="200" style="-webkit-transform:scale(1.1);-moz-transform-scale(1.1);"></iframe>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-sm-6">
            <div class="portlet solid grey-cararra bordered">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-check-square-o"></i>Top 10 Repair Hours: Medium Vehicle
                  </div>
               </div>
               <div class="portlet-body">
                  <iframe src="{{ route('downtime.rpMediumVehicle', ['start' =>  request()->get('start'), 'end' =>  request()->get('end')]) }}" style="overflow : hidden;" frameborder="0" width="100%" scrolling="no" height="200" style="-webkit-transform:scale(1.1);-moz-transform-scale(1.1);"></iframe>
               </div>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-md-6 col-sm-6">
            <div class="portlet solid grey-cararra bordered">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-check-square-o"></i>Top 10 Repair Hours: Heavy Equipment
                  </div>
               </div>
               <div class="portlet-body">
                  <iframe src="{{ route('downtime.rpHeavyVehicle', ['start' =>  request()->get('start'), 'end' =>  request()->get('end')] ) }}" style="overflow : hidden;" frameborder="0" width="100%" scrolling="no" height="200" style="-webkit-transform:scale(1.1);-moz-transform-scale(1.1);"></iframe>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-sm-6">
            <div class="portlet solid grey-cararra bordered">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-check-square-o"></i>Top 10 Repair Hours: Motorcycle
                  </div>
               </div>
               <div class="portlet-body">
                  <iframe src="{{ route('downtime.rpMotor', ['start' =>  request()->get('start'), 'end' =>  request()->get('end')]) }}" style="overflow : hidden;" frameborder="0" width="100%" scrolling="no" height="200" style="-webkit-transform:scale(1.1);-moz-transform-scale(1.1);"></iframe>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection

@push('javascript')
<script>
   jQuery(document).ready(function() {
      Metronic.init(); // init metronic core components
      Layout.init(); // init current layout
      TableManaged.init();
   });
</script>
<script>
   let TableManaged = function() {

      let initTable1 = function() {

         let table = $('#sample_1');

         // begin first table
         table.dataTable({
            "columns": [{
               "orderable": true
            }, {
               "orderable": true
            }, {
               "orderable": true
            }, {
               "orderable": true
            }, {
               "orderable": false
            }],
            "lengthMenu": [
               [5, 15, 20, -1],
               [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 5,
            "pagingType": "bootstrap_full_number",
            "language": {
               "lengthMenu": "  _MENU_ records",
               "paginate": {
                  "previous": "Prev",
                  "next": "Next",
                  "last": "Last",
                  "first": "First"
               }
            },
            "columnDefs": [{ // set default column settings
               'orderable': false,
               'targets': [0]
            }, {
               "searchable": false,
               "targets": [0]
            }],
            "order": [
               [0, "desc"]
            ] // set first column as a default sort by asc
         });

         let tableWrapper = jQuery('#sample_1_wrapper');

         table.find('.group-checkable').change(function() {
            let set = jQuery(this).attr("data-set");
            let checked = jQuery(this).is(":checked");
            jQuery(set).each(function() {
               if (checked) {
                  $(this).attr("checked", true);
                  $(this).parents('tr').addClass("active");
               } else {
                  $(this).attr("checked", false);
                  $(this).parents('tr').removeClass("active");
               }
            });
            jQuery.uniform.update(set);
         });

         table.on('change', 'tbody tr .checkboxes', function() {
            $(this).parents('tr').toggleClass("active");
         });

         tableWrapper.find('.dataTables_length select').addClass("form-control input-xsmall input-inline"); // modify table per page dropdown
      }

      return {
         //main function to initiate the module
         init: function() {
            if (!jQuery().dataTable) {
               return;
            }
            initTable1();
         }
      };

   }();
</script>
@endpush