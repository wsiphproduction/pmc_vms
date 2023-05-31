@extends('layout.vehicle_utilization.reports')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <i class="fa fa-certificate"></i> <small>&nbsp;&nbsp;List of Trip Tickets</small>
                </h3>
            </div>
        </div>
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
                                        <form role="form" action="{{route('vehicle.report.trip')}}" method="GET">
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
                                                <label class="control-label">Driver</label>
                                                <select name="driver" class="form-control">
                                                    <option value="">-- Select Driver --</option>
                                                   
                                                    @if(isset($drivers))

                                                        @foreach ($drivers as $item)

                                                            @if( $item->id == request()->query('driver') )

                                                            <option value="{{$item->id}}" selected="selected">{{$item->driver_name}}</option>

                                                            @else

                                                            <option value="{{$item->id}}">{{$item->driver_name}}</option>

                                                            @endif

                                                        @endforeach
                                                        
                                                    @endif

                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="control-label">Vehicle</label>
                                                <select name="unit" class="form-control">
                                                    <option value="">-- Select Vehicle --</option>

                                                    @if (isset($unit))

                                                        @foreach ($unit as $item)

                                                        @if( $item->id == request()->query('unit'))
                                                        
                                                        <option value="{{$item->id}}" selected="selected">{{$item->name}}</option>

                                                        @else
                                                        
                                                        <option value="{{$item->id}}" >{{$item->name}}</option>

                                                        @endif
                                                            
                                                        @endforeach
                                                        
                                                    @endif

                                                </select>
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
                                                <input type="hidden" name="driver" value="{{request()->query('driver')}}">
                                                <input type="hidden" name="unit" value="{{request()->query('unit')}}">
                                                <button type="submit" class="btn btn-circle blue" name="trip_tickets" id="excel-b"><i class="fa fa-file-excel-o"></i> Excel</button>
                                            </form>
                                        </li>
                                        <li>
                                            <a class="btn btn-circle purple" id="print-b" href="javascript:window.print()"><span class="fa fa-print"></span> Print</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th width="60px">Seq #</th>
                                            <th>Ticket #</th>
                                            <th>Driver</th>
                                            <th>Vehicle</th>
                                            <th>Purpose</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(isset($driverResult))

                                        <div style="visibility: hidden">
                                            {{$count = 0}}
                                        </div>

                                        @foreach ($driverResult as $item)

                                            <tr>
                                                <td>{{$count++}}</td>
                                                <td>{{$item->tripTicket}}</td>
                                                <td>{{$item->driver_name}}</td>
                                                <td>{{$item->type}}</td>
                                                <td>{{$item->purpose}}</td>
                                                <td>{{$item->Status}}</td>
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