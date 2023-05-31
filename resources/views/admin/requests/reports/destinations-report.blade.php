@extends('layout.vehicle_utilization.reports')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <i class="fa fa-certificate"></i> TOP 10 <small>&nbsp;&nbsp;most frequest destinations</small>
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
                                        <form role="form" action="{{route('vehicle.report.topdestination')}}" method="GET">
                                            <div class="col-md-3">
                                                <label class="control-label">From <span class="font-red">*</span></label>
                                                <div class="input-group date form_date col-md-12" data-date="" data-date-format="yyyy-mm-dd" data-link-field="date_from" data-link-format="yyyy-mm-dd">

                                                    @if( isset($start))

                                                        <div class="input-icon">
                                                            <i class="fa fa-calendar font-yellow"></i>
                                                            <input class="form-control" size="10" type="text" value="{{app('request')->input('start')}}" readonly>
                                                        </div>
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                        <input type="hidden" name="start" id="date_from" value="{{app('request')->input('start')}}" />
                                                    
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

                                            <div class="col-md-3">

                                                <label class="control-label">To <span class="font-red">*</span></label>
                                                <div class="input-group date form_date col-md-12" data-date="" data-date-format="yyyy-mm-dd" data-link-field="date_to" data-link-format="yyyy-mm-dd">

                                                    @if( isset($end))
                                                   
                                                        <div class="input-icon">
                                                            <i class="fa fa-calendar font-yellow"></i>
                                                            <input class="form-control" size="10" type="text" value="{{app('request')->input('end')}}" readonly>
                                                        </div>
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                        <input type="hidden" name="end" id="date_to" value="{{app('request')->input('end')}}" />
                                                   
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
                                            <div class="col-md-3">
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
            <div class="col-md-6">
                <br>
                
                @if( true)

                    <div class="col-md-12" id="frequentChart"> </div>

                @endif

                <div class="col-md-12" id="chart-1"> </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="fa fa-globe font-dark"></i>
                                    <span class="caption-subject bold uppercase"> Destinations</span>
                                </div>
                                <div class="actions">
                                    <ul class="list-inline">
                                        <li>
                                            <form method="POST" action="{{route('vehicle.report.exportToExcel')}} ">
                                                @csrf
                                                <input type="hidden" name="date_fr" value="{{request()->query('start')}}">
                                                <input type="hidden" name="date_to" value="{{request()->query('end')}}">
                                                <button class="btn btn-circle blue" name="frequent_dest" id="excel-b"><i class="fa fa-file-excel-o"></i> Excel</button>
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
                                            <th>Destinations</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @if( isset($start))
                                            
                                            @foreach ($destinationTbl as $item)

                                                <tr>
                                                    <td>{{$item->dest}}</td>
                                                    <td>{{$item->total}}</td>
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

@section('javascript')
<script>

    FusionCharts.ready(function(){
    	FusionCharts.printManager.enabled(true);
	    let fusioncharts = new FusionCharts({
            type: 'column2D',
            renderAt: 'frequentChart',
            width: '100%',
            height: '500',
            dataFormat: 'json',
            dataSource: {!! json_encode($jsondata ?? '')  !!}
	    });
	    fusioncharts.render();
	});
</script>
@endsection
