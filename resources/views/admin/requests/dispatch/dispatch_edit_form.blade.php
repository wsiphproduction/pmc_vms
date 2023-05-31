<meta name="csrf-token" content="{{ csrf_token() }}">

<form method="post" action="{{ route('vehicle.request.update.dispatch_details', ['id' => $id]) }}" id="ddform">
   @csrf
   <div class="form-group col-md-12">
      <div class="col-md-12">
         <div style="height:45px;;" class="alert alert-success"><center><strong>Trip Ticket Form {{ $dispatch->tripTicket }}</strong></center></div>
      </div>
   </div>

   <div class="form-group col-md-12">
      <input type="hidden" name="requestor" value="{{ $vehicleRequest->name }}">
      
      @if($history)
      <input type="hidden" name="last_odo" id="last_odo" value="{{ $history->odometer_end }}">
      @else
      <input type="hidden" name="last_odo" id="last_odo" value="">
      @endif

      <div class="col-md-4">
         <label class="control-label">Date Out<i class="font-red"> *</i></label>  
		  @if($dispatch->isPrinted == 1)

      <input readonly type="text" class="form-control" value="{{ \Carbon\Carbon::parse($dispatch->dateStart)->format('Y-m-d h:i:s') }}"> 
       {{-- <input readonly type="text" class="form-control" value="{{ \Carbon\Carbon::parse($dispatch->addedDate)->format('Y-m-d h:i:s') }}"> --}}
      @else

      <div class="input-group date form_datetime col-md-12" data-date="" data-date-format="yyyy-mm-dd HH:ii p" data-link-field="date_out">
         <div class="input-icon">
            <i class="fa fa-calendar font-yellow"></i>
           <input required class="form-control" size="16" type="text" value="{{ \Carbon\Carbon::parse($dispatch->dateStart)->format('Y-m-d h:i:s') }}" readonly> 
            {{--  <input required class="form-control" size="16" type="text" value="{{ \Carbon\Carbon::parse($dispatch->addedDate)->format('Y-m-d h:i:s') }}" readonly> --}}
         </div>
         <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
          <input type="hidden" name="date_out" id="date_out" value="{{ \Carbon\Carbon::parse($dispatch->dateStart)->format('Y-m-d h:i:s') }}" /> 
         {{-- <input type="hidden" name="date_out" id="date_out" value="{{ \Carbon\Carbon::parse($dispatch->addedDate)->format('Y-m-d h:i:s') }}" /> --}}
      </div>

      @endif
      </div>
     

      <div class="col-md-4">
         <label class="control-label">Date Needed<i class="font-red"> *</i></label>
         <input required type="text" name="app_date" class="form-control" id="dt_from" value="{{ \Carbon\Carbon::parse($dispatch->addedDate)->format('Y-m-d h:i:s') }}" readonly  />
      </div>

      <div class="col-md-4">
         <label class="control-label">Department<i class="font-red"> *</i></label>
         <div class="input-icon">
            <i class="fa fa-building-o font-yellow"></i>
            <input {{ $isReadOnly }} id="dept" required type="text" class="form-control" name="department" value="{{ $dispatch->deptId }}" >
         </div>
      </div>
   </div>

   <div class="form-group col-md-12">
      <div class="col-md-4">
         <label class="control-label">Vehicle<i class="font-red"> *</i></label>
         @if($dispatch->isPrinted == 1)
            
            <input readonly type="text" class="form-control" value="{{ $dispatch->type }}">
            <input readonly type="hidden" name="vehicle" class="form-control" value="{{ $dispatch->unitId }} | {{ $dispatch->type }}">
            
         @else

            <select required="required" name="vehicle" id="vcostcode" class="bs-select form-control" onchange="update_vehiclecostcode();">
               <optgroup label="Available">{!! $available_units ?? '' !!}</optgroup>
               <optgroup label="In-use">{!! $in_used_units ?? '' !!}</optgroup>
               <optgroup label="Unavailable">{!! $unavailable_units ?? '' !!}</optgroup>
            </select>

         @endif
      </div>


      <input type="text" class="form-control" name="ticket_no" value="{{ $dispatch->tripTicket }}" readonly style="display:none;">
   
      <div class="col-md-4">
         <label class="control-label">Vehicle Cost Code<i class="font-red"> *</i></label>
         <div class="input-icon">
            <i class="fa fa-tachometer font-yellow"></i>
            <input required type="text" class="form-control" name="cost_code" id="cost_code" value="{{ $dispatch->vehicle_cost_code }}">
         </div>
      </div>

      <div class="col-md-4">
         <label class="control-label">Driver<i class="font-red"> * </i></label>
         
         @if($dispatch->isPrinted == 1)
            @if($drivers)
            <input type="text" class="form-control" value="{{$drivers->driver_name}}" readonly>
            @else
            <input type="text" class="form-control" value="" readonly>
            @endif
         @else
         
         <select required name="driver" class="form-control">
            <option>-- Select Driver --</option>

            @foreach ($activeDrivers as $item)
               <option value="{{$item->id}}" @if($dispatch->driver_id == $item->id) selected @endif >{{$item->driver_name." ".$item->type}}</option>
            @endforeach
         </select>
         @endif
         
      </div>

      
   </div>

   <div class="form-group col-md-12">
      <div class="col-md-4">
         <label class="control-label">From<i class="font-red"> *</i></label>
         <div class="input-icon">
            <i class="fa fa-globe font-yellow"></i>
            <input required type="text" class="form-control" name="origin" value="{{ $origin }}"> 
         </div>
      </div>

      <div class="col-md-4">
         <label class="control-label">To<i class="font-red"> *</i></label>
         <div class="input-icon">
            <i class="fa fa-globe font-yellow"></i>
            <input required type="text" class="form-control" name="destination" value="{{ $destination }}"> 
         </div>
      </div>

      <div class="col-md-4">
         <label class="control-label">Odometer Start<i class="font-red"> *</i></label>
         <div class="input-icon">
            <i class="fa fa-tachometer font-yellow"></i>
            <input type="number" class="form-control text-right" name="odom_start" id="odom_start" value="{{ number_format($dispatch->odometer_start, 2, '.','') }}">
            @if($history)
            <span class="help-block" id="odo_help">Previous trip odometer: {{ number_format($history->odometer_end, 2) }} </span>
            @else
            <span class="help-block" id="odo_help">Previous trip odometer: </span>
            @endif
         </div>
      </div>
   </div>
   <div class="col-md-12">
      <div class="col-md-4">
         <div class="form-group multiple-form-group">
            <label>Passengers</label>

               @if($passengers != null)
                  @foreach($passengers as $item)
                     @if($item != '')
                     <div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        {{ $item }}
                        <input type="hidden" class="form-control" name="passengers[]" value="{{ $item }}">
                     </div>
                     @endif
                  @endforeach
               @endif

               <div class="form-group input-group input-icon">
                  <i class="fa fa-user font-yellow"></i>
                  <input type="text" class="form-control" name="passengers[]" placeholder="Passengers">
                  <span class="input-group-btn"><button type="button" class="btn btn-primary btn-add"><i class="fa fa-plus"></i>
                  </button></span>
               </div>
         </div>
      </div>

      <div class="col-md-8">
         <label class="control-label">Purpose<i class="font-red"> *</i></label>
         <div class="input-icon">
            <i class="fa fa-comment-o font-yellow"></i>
            <textarea {{$isReadOnly}} required name="purpose" class="form-control">{{ $dispatch->purpose }}</textarea>
            
         </div>

      </div>
   </div>
   <div style="text-align: right; margin-top: 10px;" class="col-md-12">
      <input type="hidden" name="dispatch_edit">

      <button class="btn green" type="button" onclick="formsubmit();">
         <span class="fa fa-save"></span> Update 
      </button>

      <button class="btn yellow" type="button" onclick="$('#is_print').val(1); formsubmit();">
          <span class="fa fa-print"></span> Update & Print
      </button>

      <a class="btn red" href="{{ route('vehicle.request.dispatch_details', ['id' => $id]) }}">
         <span class="fa fa-backward"></span> Cancel 
      </a>
   </div>
</form>



<!-- ############### Return Slip Form ############### -->

<div class="form-group col-md-12">
   <div class="col-md-12">
      <hr>
   </div>
   <div class="col-md-12">
      <div style="height:45px;" class="alert alert-info"><center><strong>Return Slip Form </strong></center></div>

   </div>
</div>

@if($dispatch->Status == 'Closed')

      <div class="form-group col-md-12">
         <div class="col-md-3">
            <label class="control-label">Status :<i class="font-red">{{ ($dispatch->Closed_by != '') ? 'Closed' : $dispatch->Status }}</i></label>
         </div>
      </div>

      <div class="form-group col-md-12">
         <div class="col-md-3">
            <label class="control-label">Return Date<i class="font-red"> *</i></label>
            <input required class="form-control" size="16" type="text" value="{{ \Carbon\Carbon::parse($dispatch->dateEnd)->format('Y-m-d h:i a') }}" readonly>
         </div>

         <div class="col-md-3">
            <label class="control-label">Odometer End<i class="font-red"> *</i></label>
            <div class="input-icon">
               <i class="fa fa-tachometer font-yellow"></i>
               <input readonly type="text" class="form-control" value="{{ $dispatch->odometer_end }}">
            </div>
         </div>

      </div>
     
   <div style="text-align:right;">
      <button disabled class="btn btn-circle blue" type="submit">
         <span class="glyphicon glyphicon-remove"></span> Close Trip Ticket 
      </button>
   </div>

@else

   <form method="post" action="{{ route('vehicle.request.update.dispatch_details', ['id' => $id]) }}" id="form_closing">
      @csrf
      <div class="form-group col-md-12">

         <input type="hidden" id="date_out" value="{{ \Carbon\Carbon::parse($dispatch->dateStart)->format('Y-m-d') }}">
         <input type="hidden" class="form-control" name="ticket_no" value="{{$dispatch->tripTicket}}">
         <!-- Added 9/7/2019 -->
         <input type="hidden" name="request_id" value="{{$dispatch->request_id}}">
         
         <div class="col-md-4">

            <input type="hidden" name="odom_startn" id="odom_startn" value="{{$dispatch->odometer_start}}">
            <label class="control-label">Odometer End<i class="font-red"> *</i></label>
            <div class="input-icon">
               <i class="fa fa-tachometer font-yellow"></i>
               <input  type="text" class="form-control" id="odom_e" name="odom_end" value="{{ $dispatch->odometer_end }}">
            </div>
         </div>
		 <div class="col-md-4">
            <label class="control-label">Number of Trips<i class="font-red"> *</i></label>
            <div class="input-icon">
               <i class="fa fa-exchange font-yellow"></i>
               <input {{$isPrinted}} type="number" class="form-control text-right" min="1" id="numberOfTrips" name="numberOfTrips" value="{{ strlen($dispatch->numberOfTrips) == 0 ? 1 : $dispatch->numberOfTrips}}">
            </div>
         </div>
      </div>

      <div class="form-group col-md-12">
         <div class="col-md-4">
            <label class="control-label">Return Date<i class="font-red"> *</i></label>
            <div class="input-group">
               <div class="input-icon">
                  <i class="fa fa-calendar font-yellow"></i>
                  <input class="form-control" name="return_date" id="date_return" size="16" type="date" 
                     max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                     value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                  >
               </div>
               <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
            </div>
         </div>

         <div class="col-md-4">
            <label class="control-label">Return Time<i class="font-red"> *</i></label>
            <div class="input-icon">
               <i class="fa fa-clock-o font-yellow"></i>
               <select required="required" id="r_time" name="return_time" class="bs-select form-control">
                  <option value=''>-- Select Time --</option>		
                  @if($dispatch->dateEnd)
                  
                  <option value="{{ \Carbon\Carbon::parse($dispatch->dateEnd)->format('H:i') }}" selected="selected"> {{ \Carbon\Carbon::parse($dispatch->dateEnd)->format('H:i') }} </option> 
                  @endif
                  		
                  <optgroup label="AM">
                     <option value="24:00">12:00</option>
                     <option value="01:00">01:00</option>
                     <option value="02:00">02:00</option>
                     <option value="03:00">03:00</option>
                     <option value="04:00">04:00</option>
                     <option value="05:00">05:00</option>
                     <option value="06:00">06:00</option>
                     <option value="07:00">07:00</option>
                     <option value="08:00">08:00</option>
                     <option value="09:00">09:00</option>
                     <option value="10:00">10:00</option>
                     <option value="11:00">11:00</option>
                  </optgroup>
                  <optgroup label="PM">
                     <option value="12:00">12:00</option>
                     <option value="13:00">01:00</option>
                     <option value="14:00">02:00</option>
                     <option value="15:00">03:00</option>
                     <option value="16:00">04:00</option>
                     <option value="17:00">05:00</option>
                     <option value="18:00">06:00</option>
                     <option value="19:00">07:00</option>
                     <option value="20:00">08:00</option>
                     <option value="21:00">09:00</option>
                     <option value="22:00">10:00</option>
                     <option value="23:00">11:00</option>
                  </optgroup>

                </select>
            </div>
         </div>

         

      </div>

   <div style="text-align:right;">
      <button class="btn btn-circle blue" type="submit" id="btnClose" name="return_edit">
         <span class="glyphicon glyphicon-remove"></span> Close Trip Ticket 
      </button>
   </div>
</form>
@endif

<script>

   function update_vehiclecostcode(){
      var x = $('#vcostcode').val();
      var i = x.split("|");
      $('#cost_code').val(i[2]);
    
      var odo = $('option:selected', $('#vcostcode')).attr('title');
      $('#odo_help').html('Previous trip odometer: '+addCommas(odo));
      $('#last_odo').val(odo);
   }

   function addCommas(nStr)
   {
       nStr += '';
       x = nStr.split('.');
       x1 = x[0];
       x2 = x.length > 1 ? '.' + x[1] : '';
       var rgx = /(\d+)(\d{3})/;
       while (rgx.test(x1)) {
           x1 = x1.replace(rgx, '$1' + ',' + '$2');
       }
       return x1 + x2;
   }

   function formValidation(oEvent) { 

      oEvent = oEvent || window.event;

      var t1ck=true;
     
      if(document.getElementById("odom_e").value.length < 1 ) {
         t1ck=false; 
      }
      if(document.getElementById("r_time").value.length < 1 ) { 
         t1ck=false; 
      }
     
      if(document.getElementById("date_return").value.length < 1 ) { 
         t1ck=false; 
      }

      if(t1ck){
         document.getElementById("btnClose").disabled = false; 
      }
      else{
         document.getElementById("btnClose").disabled = true; 
      }
   } 

   window.onload = function () { 

      var btnClose = document.getElementById("btnClose"); 
      var odom_e = document.getElementById("odom_e");
      var t_return = document.getElementById("r_time");
      var dt_return = document.getElementById("date_return");

      var t1ck = false;

      document.getElementById("btnClose").disabled = true;
         t_return.onclick  = formValidation;
         odom_e.onkeyup  = formValidation; 
         dt_return.change  = formValidation;
      }



      var todayDate = new Date().getDate();
      var dateOut = document.getElementById('date_out').value;
      var startD = new Date(new Date().setDate(todayDate));
      var endD   = new Date(dateOut);

      $('.form_date').datetimepicker({
         language:  'en',
         endDate : startD,
         startDate : endD,
         weekStart: 1,
         todayBtn:  1,
         autoclose: 1,
         todayHighlight: 1,
         startView: 2,
         minView: 2,
         forceParse: 0
       });

      $('.form_datetime').datetimepicker({
         language:  'en',
         weekStart: 7,
         todayBtn:  1,
         autoclose: 1,
         todayHighlight: 1,
         startView: 2,
         forceParse: 0,
         showMeridian: 1,
         minView: 0
      });

      function formsubmit(){
         var odoe = $('#last_odo').val();
         var odos = $('#odom_start').val();

         $('form#ddform').submit();
      }

      $('#form_closing').on('submit', function() {
         var odoe = $('#odom_e').val();
         var odos = $('#odom_startn').val();

            return true;
      });

      $('#odom_start').on('change', function(){
         $('#odom_startn').val($(this).val());
      });
</script>