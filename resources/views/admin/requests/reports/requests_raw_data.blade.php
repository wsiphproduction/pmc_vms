@extends('layout.vehicle_utilization.reports')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">

                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div id="form" class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <i class="fa fa-list font-red-sunglo"></i>
                            <span class="caption-subject bold uppercase"> Generate Report</span>
                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <!-- PERSONAL INFO TAB -->
                            <div class="tab-pane active">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <form role="form" action="{{route('vehicle.report.request.raw')}}" method="GET">
                                            <div class="col-md-2">
                                                <label class="control-label">From <span class="font-red">*</span></label>
                                                <div class="input-group date form_date col-md-12" data-date="" data-date-format="yyyy-mm-dd" data-link-field="date_from" data-link-format="yyyy-mm-dd">
                                                    
                                                    @if(isset($start))
                                                    
                                                    <div class="input-icon">
                                                        <i class="fa fa-calendar font-yellow"></i>
                                                        <input class="form-control" size="10" type="text" value="{{request()->query('start')}}" readonly>
                                                    </div>
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                    <input type="hidden" name="start" id="date_from" value="{{request()->query('start')}}" />
                                                    
                                                    @else

                                                    <div class="input-icon">
                                                        <i class="fa fa-calendar font-yellow"></i>
                                                        <input class="form-control" size="10" type="text" value="" readonly>
                                                    </div>
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                    <input type="hidden" name="start" id="date_from" value="" />
                                                    
                                                    @endif
                                                    

                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="control-label">To <span class="font-red">*</span></label>
                                                <div class="input-group date form_date col-md-12" data-date="" data-date-format="yyyy-mm-dd" data-link-field="date_to" data-link-format="yyyy-mm-dd">
                                                    
                                                    @if(isset($end))

                                                    <div class="input-icon">
                                                            <i class="fa fa-calendar font-yellow"></i>
                                                            <input class="form-control" size="10" type="text" value="{{request()->query('end')}}" readonly>
                                                    </div>
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                    <input type="hidden" name="end" id="date_to" value="{{request()->query('end')}}" />
                                                    
                                                    @else
                                                    
                                                    <div class="input-icon">
                                                            <i class="fa fa-calendar font-yellow"></i>
                                                            <input class="form-control" size="10" type="text" value="" readonly>
                                                        </div>
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                        <input type="hidden" name="end" id="date_to" value="" />
                                                   
                                                    @endif

                                                </div>
                                            </div>
                                           
                                            <div class="col-md-2">
                                                <label class="control-label">&nbsp;</label>
                                                <button class="btn btn blue form-control" type="submit">
                                                    <span class="glyphicon glyphicon-refresh"></span> Generate
                                                </button>
                                            </div>
                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="fa fa-tags font-dark"></i>
                                    <span class="caption-subject bold uppercase"> Trip Tickets</span>
                                </div>
                                <div class="actions">
                                    <ul class="list-inline">
                                        <li>
                                            <form method="POST" action="{{route('vehicle.report.exportToExcel')}}">
                                                @csrf
                                                <input type="hidden" name="date_from" value="{{request()->query('start')}}">
                                                <input type="hidden" name="date_to" value="{{request()->query('end')}}">
                                                <button type="submit" class="btn btn-circle blue" name="vehicle_request_raw_data" id="excel-b"><i class="fa fa-file-excel-o"></i> Excel</button>
                                            </form>
                                        </li>
                                        <li>
                                            <a class="btn btn-circle purple" id="print-b" href="javascript:window.print()"><span class="fa fa-print"></span> Print</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="portlet-body table-scrollable">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th style="font-size:10px;">Request No. </th>
                                            <th style="font-size:10px; ">Vehicle Cost Code</th>
                                            <th style="font-size:10px;">Cost Code </th>
                                            <th style="font-size:10px;">Dept </th>
                                            <th style="font-size:10px;" >Date Needed </th>
                                            <th style="font-size:10px;" >Time Needed </th>
                                            <th style="font-size:10px;" >Date Requested </th>
                                            <th style="font-size:10px;" >Time Requested </th>
                                            <th style="font-size:10px;" >Purpose</th>
                                            <th style="font-size:10px;">Trip Ticket </th>
                                            <th style="font-size:10px;" >Status </th>
                                            <th style="font-size:10px;" >Vehicle </th>
                                            <th style="font-size:10px;">Fuel Added Qty </th>
                                            <th style="font-size:10px;" >Driver </th>
                                            <th style="font-size:10px;">Passengers </th>
                                            <th style="font-size:10px;">Contact Person </th>
                                            <th style="font-size:10px;">Vehicle Date Out </th>
                                            <th style="font-size:10px;">Time Out </th>
                                            <th style="font-size:10px;">Vehicle Date Return </th>
                                            <th style="font-size:10px;">Time Returned </th>
                                            <th style="font-size:10px;">Distance Travelled </th>
                                            <th style="font-size:10px;">Odometer Start </th>
                                            <th style="font-size:10px;">Odometer End </th>
                                            <th style="font-size:10px;">Ave. Fuel Consumed </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(isset($requests))

                                        <div style="visibility: hidden">
                                            {{$count = 0}}
                                        </div>
                                        
                                        @foreach ($requests as $item)
                                        
                                            <tr>
                                                <td>{{ $item->refcode }}</td>
                                                <td>{{ $item->vehicle_cost_code }}</td>
                                                <td>{{ $item->costcode }}</td>
                                                <td>{{ $item->dept }}</td>
                                                <td>{{ isset($item->date_needed) ? Carbon\Carbon::parse($item->date_needed)->format('m/d/Y') : '' }}</td>
                                                <td>{{ isset($item->date_needed) ? Carbon\Carbon::parse($item->date_needed)->format('h:i A') : '' }}</td>
                                                <td>{{ isset($item->addedAt) ? Carbon\Carbon::parse($item->addedAt)->format('m/d/Y') : '' }}</td>
                                                <td>{{ isset($item->addedAt) ? Carbon\Carbon::parse($item->addedAt)->format('h:i A') : '' }}</td>
                                                <td>{{ $item->purpose }}</td>
                                                <td>{{ isset($item->tripTicket) ? $item->tripTicket : '' }}</td>
                                                <td>{{ isset($item->Status) ? $item->Status : '' }}</td>
                                                <td>{{ isset($item->type) ? $item->type : '' }}</td>
                                                <td>{{ $item->fuel_added_qty == '.00' ? '': round($item->fuel_added_qty).' L' }}</td>
                                                <td>{{ isset($item->driver_name) ? $item->driver_name : '' }}</td>
                                                <td>{{ isset($item->passengers) ? $item->passengers : '' }}</td>
                                                <td>{{ isset($item->contact_person) ? $item->contact_person : '' }}</td>
                                                <td style="width: 80px;">
                                                    @if(isset($item->Status))
                                                        @if($item->Status == 'Cancelled')
                                                            <span style="font-size:10px;color:red;">CANCELLED</span>
                                                        @else
                                                        {{ \Carbon\Carbon::parse($item->dateStart)->format('Y-m-d') }}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($item->Status))
                                                        @if($item->Status == 'Cancelled')
                                                            <span style="font-size:10px;color:red;"> N/A</span>
                                                        @else
                                                            {{ \Carbon\Carbon::parse($item->dateStart_time)->format('h:i A') }}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($item->Status))
                                                        @if($item->Status == 'Cancelled')
                                                            <span style="font-size:10px;color:red;"> N/A</span>
                                                        @else
                                                            @if($item->dateEnd == '')
                                                                <span style="font-size:10px;color:red;">NOT YET RETURNED</span>
                                                            @else
                                                                {{ \Carbon\Carbon::parse($item->dateEnd)->format('Y-m-d') }}
                                                            @endif
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($item->Status))
                                                        @if($item->Status == 'Cancelled')
                                                            <span style="font-size:10px;color:red;"> N/A</span>
                                                        @else
                                                            @if($item->dateEnd == '')
                                                                
                                                            @else
                                                                {{ \Carbon\Carbon::parse($item->dateEnd_time)->format('h:i A') }}
                                                            @endif
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($item->Status))
                                                        @if($item->Status == 'Cancelled')
                                                            <span style="font-size:10px;color:red;"> Cancelled</span>
                                                        @else
                                                            {{-- {{ number_format((float) $item->odometer_end - $item->odometer_start, 4, '.', ''). 'KM' }} --}}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td style="width: 80px;">{{ isset($item->odometer_start) ? $item->odometer_start : ''}}</td>
                                                <td style="width: 80px;">{{ isset($item->odometer_end) ? $item->odometer_end : '' }}</td>
                                                <td>
                                                    @if(isset($item->Status))
                                                        @if($item->odometer_start == '' || $item->odometer_end == '')

                                                        @else
                                                            @if(($item->odometer_end - $item->odometer_start) == '0.0000')
                                                        
                                                            @else
                                                                @if($item->fuel_added_qty == '0.00')

                                                                @else
                                                                    {{-- {{ number_format((float) ($item->odometer_end - $item->odometer_start)/ $item->fuel_added_qty, 4, '.', ''). ' Km/Liter' }} --}}
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                </td>
 
                                            </tr>
                                            
                                        @endforeach

                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection