@extends('layout.downtimes')

@section('content')
<!-- BEGIN CONTAINER -->
<div class="page-container">
   <!-- BEGIN CONTENT -->
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
         <form method="get" action="{{ route('downtime.downtimes') }}">
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
                        <a href="{{ route('downtime.downtimes') }}" class="btn purple btn-sm" style="color:white;">Reset</a>
                     </li>

                  </ul>
               </div>
            </div>
         </form>

         <div class="clearfix">
         </div>

         <div class="row ">
            <div class="col-md-12">
               <div class="portlet box blue-steel">
                  <div class="portlet-title">
                     <div class="caption">
                        <i class="fa fa-download"></i>Recent Downtime Logs
                     </div>
                     <div class="actions">
                        <div class="btn-group">

                           <a class="btn default" href="#" data-toggle="dropdown">
                              Columns <i class="fa fa-angle-down"></i>
                           </a>

                           <div id="sample_4_column_toggler" class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
                              <label><input type="checkbox" checked data-column="0">ID</label>
                              <label><input type="checkbox" checked data-column="1">Unit</label>
                              <label><input type="checkbox" checked data-column="2">Category</label>
                              <label><input type="checkbox" checked data-column="3">Status</label>
                              <label><input type="checkbox" data-column="4">Reported</label>
                              <label><input type="checkbox" checked data-column="5">Start</label>
                              <label><input type="checkbox" checked data-column="6">End</label>
                              <label><input type="checkbox" data-column="7">Assigned To</label>
                              <label><input type="checkbox" data-column="8">Remarks</label>
                              <label><input type="checkbox" data-column="9">Type</label>
                              <label><input type="checkbox" data-column="10">Work Order</label>
                              <label><input type="checkbox" data-column="11">Repair Type</label>
                              <label><input type="checkbox" data-column="12">Work Details</label>
                              <label><input type="checkbox" data-column="13">Mechanics</label>
                              <label><input type="checkbox" data-column="14">From 12 AM</label>
                              <label><input type="checkbox" data-column="15">From 7 AM</label>
                              <label><input type="checkbox" data-column="16">Repair Days</label>
                              <label><input type="checkbox" data-column="17">Repair Hours</label>
                              <label><input type="checkbox" data-column="18">Shop Days</label>
                              <label><input type="checkbox" data-column="19">Shop Hours</label>
                              <label><input type="checkbox" data-column="20">Man Hours</label>
                              <label><input type="checkbox" data-column="21">Required Daily Availability</label>
                              <label><input type="checkbox" data-column="22">Downtime</label>
                              <label><input type="checkbox" data-column="23">Added By</label>
                              <label><input type="checkbox" data-column="24">Added Date</label>
                              <label><input type="checkbox" checked data-column="25">Action</label>
                           </div>
                           <a class="btn green" href="#" style="margin-left: 10px;" onclick="exportToExcel('#sample_4')">
                              Download
                           </a>
                           <a class="btn green" target="_blank" href="{{ route('maintenance.export', 'raw_data') }}" style="margin-left: 10px;">
                              Raw Data
                           </a>
                        </div>
                     </div>

                  </div>
                  <div class="portlet-body">
                     <br>

                     <table style="font-size:11px;" class="table table-bordered table-hover" id="sample_4">
                        <thead>
                           <tr>
                              <th scope="col">ID</th>
                              <th scope="col">Unit</th>
                              <th scope="col">Category</th>
                              <th scope="col">Status</th>
                              <th scope="col">Reported</th>
                              <th scope="col">Start</th>
                              <th scope="col">End</th>
                              <th scope="col">Assigned To</th>
                              <th scope="col">Remarks</th>
                              <th scope="col">Type</th>
                              <th scope="col">Work Order</th>
                              <th scope="col">Repair Type</th>
                              <th scope="col">Downtime Category</th>
                              <th scope="col">Work Details</th>
                              <th scope="col">Mechanics</th>
                              <th scope="col">From 12 AM</th>
                              <th scope="col">From 7 AM</th>
                              <th scope="col">Repair Days</th>
                              <th scope="col">Repair Hours</th>
                              <th scope="col">Shop Days</th>
                              <th scope="col">Shop Hours</th>
                              <th scope="col">Man Hours</th>
                              <th scope="col">Required Daily Availability</th>
                              <th scope="col">Downtime</th>
                              <th scope="col">Added By</th>
                              <th scope="col">Added Date</th>
                              <th scope="col">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($downtimes as $item)
                           <tr>
                              <td>{{$item->id}}</td>
                              <td>{{$item->uni}}</td>
                              <td>{{$item->type}}</td>
                              <td>{{$item->status}}</td>
                              <td>{!! date('Y-m-d', strtotime($item->reported)) !!}</td>
                              <td>{{$item->ds}}</td>
                              <td>{{$item->de}}</td>
                              <td>{{$item->assignedTo}}</td>
                              <td>{{$item->remarks}}</td>

                              @if($item->isScheduled == 1)
                              <td>Corrective/PM</td>
                              @else
                              <td>Breakdown</td>
                              @endif

                              <td>{{$item->workOrder}}</td>
                              <td>{{$item->repairType}}</td>
                              <td>{{$item->downtimeCategory}}</td>
                              <td>{{$item->workDetails}}</td>
                              <td>{!! str_replace("|", ", ", $item->mechanics) !!}</td>
                              <td>{{$item->from12}}</td>
                              <td>{{$item->from7}}</td>
                              <td>{{$item->trepair_days}}</td>
                              <td>{{$item->trepair_hours}}</td>
                              <td>{{$item->shop_days}}</td>
                              <td>{{$item->shop_hours}}</td>
                              <td>{{$item->man_hours}}</td>
                              <td>{{$item->required_daily_availability}}</td>
                              <td>{{$item->tdowntime}}</td>
                              <td>{{$item->addedBy}}</td>
                              <td>{{date('Y-m-d H:i:s', strtotime($item->added))}}</td>
                              <td style="width:100px;"><a href="#" class="btn purple btn-xs" onclick='window.open("{{ route('downtime.downtime_edit', ['id' => $item->id]) }}","displayWindow","toolbar=no,scrollbars=yes,width=1200,height=700");' return false;><i class="fa fa-edit"></i></a>
                                 <a href="#" class="btn red btn-xs deletedl" data="{{ $item->id }}"><i class="fa fa-minus-circle" data-toggle="modal" href="#delete{{$item->id}}"></i></a>
                                 <div class="modal fade" id="delete{{$item->id}}" tabindex="-1" role="basic" aria-hidden="true">
                                    <div class="modal-dialog">
                                       <form action="{{route('downtime.downtime_destroy',  ['id' =>  $item->id])}}" method="POST">
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

         </div>
         <div class="clearfix">
         </div>



      </div>
   </div>
   <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
@endsection