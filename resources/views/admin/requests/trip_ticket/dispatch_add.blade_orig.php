@extends('layout.utilization')

@section('content')
<div class="clearfix"></div>
   <div class="page-container">
      <!-- BEGIN CONTENT -->
      <div class="page-content-wrapper">
         <div class="page-content">
            <div class="row">
               <div class="col-md-12">
                  <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                  <div class="breadcrumbs">
                    <h3><i class="fa fa-truck"></i> VEHICLE REQUEST</h3>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/"><i class="fa fa-home"></i> HOME</a>
                        </li>
                        <li>
                            <a href="{{ route('vehicle.request.list') }}"><i class="fa fa-list"></i> REQUEST LIST</a>
                        </li>
                        <li class="active"><i class="fa fa-edit"></i> TICKET CREATION</li>
                    </ol>
                  </div>
               </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
               <div class="col-md-12">

                  <?php 
                     if (isset($successMSG)) {
                         ?>
                         <div class="alert alert-success alert-dismissable">
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                 <span class="fa fa-check-square-o"></span><b> Success :</b> <?php echo $successMSG; $tid;?>
                         </div>
                             <?php }
                     else if (isset($errorMSG)) { ?>
                        <div class="alert alert-danger alert-dismissable">
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                             <span class="fa fa-exclamation"></span><b> Error :</b> <?php echo $errorMSG; ?>
                         </div>
                     <?php }
                  ?>
                  <!-- BEGIN SAMPLE FORM PORTLET-->
                  <div id="form" class="portlet light bordered">
                     <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                           <i class="fa fa-automobile font-red-sunglo"></i>
                           <span class="caption-subject bold uppercase"> Vehicle Dispatch Form Request # : {{ $id }}</span>
                        </div>
                        <div style="float:right;" class="caption font-blue-sunglo">
                           <i class="fa fa-tag font-blu-sunglo"></i>
                           <span class="caption-subject"> Status : {{ $request->status }}</span>
                        </div>
                     </div>
                     <div class="portlet-body">
                        <div class="tab-content">
                           <!-- PERSONAL INFO TAB -->
                           <div class="tab-pane active">
                              <div class="row">
                                 <div class="form-group col-md-12">
                                    {{-- /vehicle/dispatch/create?deptId={{ $request->dept }} --}}
                                    <form role="form" action="{{ route('vehicle.dispatch.create', ['deptId' => $request->dept]) }}" method="POST">
                                        @csrf
                                       <div class="form-group col-md-12">
                                            <input type="hidden" name="requestor" value="{{ $request->name }}">
                                            <input type="hidden" name="rid" value="{{ $request->id }}">
                                            <div class="alert alert-info"><center style="font-family: times;"><b>TRIP TICKET FORM</b><br><small style="color:red;">Note: Trip ticket number will be given after submission of this form</small></center></div>

                                            <div class="col-md-3">
                                                <label class="control-label">Date Out <i class="font-red"> *</i></label>
                                                @if($status == 'Cancelled')
                                                    <div class="input-group col-md-12">
                                                        <div class="input-icon">
                                                         <i class="fa fa-calendar font-yellow"></i>
                                                         <input name="do" class="form-control" size="16" type="text" disabled>
                                                        </div>
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                    </div>
                                                @else
                                                    <div class="input-group date form_datetime col-md-12" data-date="" data-date-format="yyyy-mm-dd HH:ii p" data-link-field="date_out">
                                                        <div class="input-icon">
                                                         <i class="fa fa-calendar font-yellow"></i>
                                                         <input name="do" class="form-control" size="16" type="text" value="" required="required" readonly>
                                                        </div>
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                        <input type="hidden" name="date_out" id="date_out" value="" />
                                                    </div>
                                                @endif
                                            </div>
                                             

                                          <div class="col-md-3">
                                             <label class="control-label">Department <i class="font-red"> *</i></label>
                                             <div class="input-icon">
                                                <i class="fa fa-building-o font-yellow"></i>
                                                <input readonly type="text" class="form-control" name="deparment" value="{{ $request->dept }}" >
                                             </div>
                                          </div>

                                          <div class="form-group">
                                             <label class="control-label col-md-3">Vehicle <i class="font-red"> *</i></label>
                                             <div class="col-md-4">
                                                <select required name="vehicles" class="bs-select form-control" id="vcostcode" onchange="update_vehiclecostcode();">
                                                   <optgroup label="Available">{!! $available_units !!}</optgroup>
                                                   <optgroup label="Unavailable">{!! $unavailable_units !!}</optgroup>
                                                </select>
                                              </div>
                                          </div>
                                       </div>

                                       <div class="form-group col-md-12">
                                          <div class="col-md-3">
                                             <label class="control-label">Date Needed <i class="font-red"> *</i></label>
                                             <input required class="form-control" name="app_date" size="16" type="text" value="{{ $request->date_needed }}" readonly>
                                          </div>

                                          <div class="col-md-3">
                                             <label class="control-label">Driver <i class="font-red"> *</i></label>
                                             <select readonly required name="driver" class="form-control">
                                                <option value="">-- Select Driver --</option>
                                                @foreach($drivers as $driver)
                                                    <option value="{{ $driver->id }}">{{ $driver->driver_name }}</option>
                                                @endforeach
                                             </select>
                                          </div>

                                          <div class="col-md-3">
                                             <label class="control-label">From <i class="font-red"> *</i></label>
                                             <div class="input-icon">
                                                <i class="fa fa-globe font-yellow"></i>
                                                <input readonly required type="text" class="form-control" name="origin" placeholder="Origin" value="{{ Session::get('esdvms_dept') }}"> 
                                             </div>
                                          </div>

                                          <div class="col-md-3">
                                             <label class="control-label">To <i class="font-red"> *</i></label>
                                             <div class="input-icon">
                                                <i class="fa fa-globe font-yellow"></i>
                                                <input required type="text" class="form-control" name="destination" placeholder="Destination" value="{{ $request->requestOtherInfo->destination ?? ''}}"> 
                                             </div>
                                          </div>
                                       </div>

                                       <div class="form-group col-md-12">
                                          <div class="col-md-12">
                                             <label class="control-label">Purpose <i class="font-red"> *</i></label>
                                             <div class="input-icon">
                                                <i class="fa fa-comment-o font-yellow"></i>
                                                <textarea readonly required name="purpose" class="form-control">{{ $request->purpose }}</textarea>
                                             </div>

                                          </div>
                                       </div>

                                       <div class="form-group col-md-12">
                                          <div class="col-md-3">
                                             <label class="control-label">Odometer Start <i class="font-red"> *</i></label>
                                             <div class="input-icon">
                                                <i class="fa fa-tachometer font-yellow"></i>
                                                {{-- <input type="number" step="0.1" id="odom_start" class="form-control" name="odom_start" placeholder="Odometer Start"> --}}
                                                 <input type="number" step="any" min="0.00001" id="odom_start" class="form-control" name="odom_start" placeholder="Odometer Start">
                                             </div>
                                          </div>

                                          <div class="col-md-6">
                                             <div class="form-group multiple-form-group">
                                                <label>Passengers</label>
                                                <div class="form-group input-group input-icon">
                                                   <i class="fa fa-users font-yellow"></i>
                                                   <input type="text" class="form-control" name="passenger[]" placeholder="Passengers">
                                                   <span class="input-group-btn"><button  type="button" class="btn btn-primary btn-add">Add
                                                   </button></span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>

                                       <div class="form-group col-md-12">
                                          <!-- <div class="alert alert-info"><center style="font-family: times;"><b>FUEL SLIP FORM </b></center> -->
                                          </div>
                                       </div>

                                       <div class="form-group col-md-12">
                                          <div class="col-md-4">
                                             <label class="control-label">Request Cost Code <i class="font-red"> *</i></label>
                                             <div class="input-icon">
                                                <i class="fa fa-tachometer font-yellow"></i>
                                                <input readonly type="text" class="form-control" value="{{ $request->costcode }}">
                                             </div>
                                          </div>

                                          <div class="col-md-4">
                                             <label class="control-label">Vehicle Cost Code <i class="font-red"> *</i></label>
                                             <div class="input-icon">
                                                <i class="fa fa-tachometer font-yellow"></i>
                                                <input type="text" class="form-control" name="cost_code" id="cost_code">
                                             </div>
                                          </div>

                                          <div class="col-md-4">
                                             <label class="control-label">RQ Number <i class="font-red"> *</i></label>
                                             <div class="input-icon">
                                                <i class="fa fa-tachometer font-yellow"></i>
                                                <input required type="text" class="form-control" name="rq_num" placeholder="RQ Number">
                                             </div>
                                          </div>

                                       </div>

                                       <div class="form-group col-md-12">
                                          <div class="col-md-3">
                                             <label class="control-label">Fuel Type <i class="font-red"> *</i></label>
                                             <select required name="fueltyp" id="fuel" class="form-control" onchange="update_itemcode();">
                                                <option value="">-- Select Fuel --</option>
                                                @foreach($fuel_types as $type)
                                                    <option value="{{ isset($type->code) ? $type->code.'|': '' }}{{ $type->name }}">{{ $type->name }}</option>
                                                @endforeach
                                             </select>
                                          </div>
                                          <div class="col-md-3">
                                             <label class="control-label">Item Code <i class="font-red"> *</i></label>
                                             <div class="input-icon">
                                                <i class="fa fa-tachometer font-yellow"></i>
                                                <input type="text" class="form-control" id="item_code" name="item_code" placeholder="Item Code" readonly>
                                             </div>
                                          </div>
                                          <div class="col-md-3">
                                             <label class="control-label">Requested Fuel Qty <i class="font-red"> *</i></label>
                                             <div class="input-icon">
                                                <i class="fa fa-tachometer font-yellow"></i>
                                                <input required  type="number" class="form-control" name="req_qty" placeholder="Quantity">
                                             </div>
                                          </div>
                                          <div class="col-md-3">
                                             <label class="control-label">UOM <i class="font-red"> *</i></label>
                                             <div class="input-icon">
                                                <i class="fa fa-tachometer font-yellow"></i>
                                                <input type="text" class="form-control" name="uom" placeholder="Unit of Measurement" value="Liter">
                                             </div>
                                          </div>
                                       </div>

                                       <div class="form-group col-md-12">
                                    
                                          <a style="float: right;" data-toggle='modal' class='btn yellow' href='#close-{{ $request->id }}'><span class='glyphicon glyphicon-remove-circle'></span> Close
                                          </a>
                                          <a style="float: right;" data-toggle='modal' class='btn red' href='#cancel-{{ $request->id }}'><span class='glyphicon glyphicon-remove-circle'></span> Cancel
                                          </a>
                                          <button style="float: right;" class="btn btn-primary" type="submit" name="dispatch">
                                             <span class="glyphicon glyphicon-send"></span> Submit 
                                          </button>
                                       </div>
                                    </form>


                                    <!--- ### Modals ### -->
                                       <div class="modal fade" id="cancel-{{ $request->id }}" tabindex="-1" role="basic" aria-hidden="true">
                                          <div class="modal-dialog">
                                             <form action="" method="POST">
                                                <div class="modal-content">
                                                   <div class="modal-header">
                                                      <input type="hidden" name="tid" value="{{ $request->id }}">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                      <h4 class="modal-title"><b>Confirmation</b></h4>
                                                   </div>
                                                      <div class="modal-body"> Are you sure you want to <b>Cancel</b> this Vehicle Request? </div>
                                                   <div class="modal-footer">
                                                      <button type="button" class="btn btn-circle dark btn-outline" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                                                      <button type="submit" name="cancel_vid" class="btn btn-circle blue"><span class="glyphicon glyphicon-remove-circle"></span> Yes</button>
                                                   </div>
                                                </div>
                                             </form>
                                          </div>
                                       </div>

                                       <div class="modal fade" id="close-{{ $request->id }}" tabindex="-1" role="basic" aria-hidden="true">
                                          <div class="modal-dialog">
                                             <form action="" method="POST">
                                                <div class="modal-content">
                                                   <div class="modal-header">
                                                      <input type="hidden" name="tid" value="{{ $request->id }}">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                      <h4 class="modal-title"><b>Confirmation</b></h4>
                                                   </div>
                                                      <div class="modal-body"> Are you sure you want to <b>Close</b> this Vehicle Request? </div>
                                                   <div class="modal-footer">
                                                      <button type="button" class="btn btn-circle dark btn-outline" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                                                      <button type="submit" name="close_vid" class="btn btn-circle blue"><span class="glyphicon glyphicon-remove-circle"></span> Yes</button>
                                                   </div>
                                                </div>
                                             </form>
                                          </div>
                                       </div>
                                    <!--- ### Modals ### -->
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- END SAMPLE FORM PORTLET-->                                                                              
               </div>                    
            </div> 
         </div>
      </div>
      <!-- END CONTENT -->
   </div>


@endsection

@section('javascript')
<script>

   (function ($) {
      $(function () {

         let addFormGroup = function (event) {
            event.preventDefault();

            let $formGroup = $(this).closest('.form-group');
            let $multipleFormGroup = $formGroup.closest('.multiple-form-group');
            let $formGroupClone = $formGroup.clone();
            $(this)
            .toggleClass('btn-default btn-add btn-danger btn-remove')
            .html('Remove');
            $formGroupClone.find('input').val('');
            $formGroupClone.insertAfter($formGroup);
         };

         let removeFormGroup = function (event) {
            event.preventDefault();

            let $formGroup = $(this).closest('.form-group');
            let $multipleFormGroup = $formGroup.closest('.multiple-form-group');
            $formGroup.remove();
         };

         $(document).on('click', '.btn-add', addFormGroup);
         $(document).on('click', '.btn-remove', removeFormGroup);
      });
   })
   
   (jQuery);


   jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core components
   Layout.init(); // init current layout
   ComponentsDropdowns.init();

   });
   
   $('#odom_start').change(function () {
     $(this).val(parseFloat($(this).val()).toFixed(2))
   });

   let todayDate = new Date().getDate();
   let endD = new Date(new Date().setDate(todayDate));
   $('.form_datetime').datetimepicker({
      language:  'en',
      startDate : endD,
      weekStart: 7,
      todayBtn:  1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      forceParse: 0,
      showMeridian: 1,
      minView: 0
   });

     
   function update_itemcode(){
      let x = $('#fuel').val();
      let i = x.split("|");
      $('#item_code').val(i[0]);
   }

   function update_vehiclecostcode(){
      let x = $('#vcostcode').val();
      let i = x.split("|");
      $('#cost_code').val(i[2]);
   }
</script>
@endsection