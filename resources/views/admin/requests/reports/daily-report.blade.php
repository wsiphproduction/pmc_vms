@extends('layout.vehicle_utilization.reports')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <i class="fa fa-certificate"></i> <small>&nbsp;&nbsp;Daily Report</small>
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
                                            <div class="col-md-2">
                                                <input type="date" name="dyt" id="dyt" value="{{$dyt}}">
                                            </div>
                                            <div class="col-md-2">
                                                <a class="btn blue" href="#" onclick="generate_report($('#dyt').val());">Generate</a>
                                            </div>
                                            <div class="col-md-2">
                                                <form method="POST" action="{{route('vehicle.report.exportToExcel')}}">
                                                    @csrf
                                                    <input type="hidden" name="dyt" value="{{$dyt}}">
                                                    <button type="submit" class="btn btn-circle blue" name="daily_report" id="excel-b"><i class="fa fa-file-excel-o"></i> Excel</button>
                                                </form>
                                              
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
                                    <span class="caption-subject bold uppercase"> Trip Ticket Daily Checklist</span>
                                </div>                               
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th>Request No</th>
                                            <th>Date Needed</th>
                                            <th>Trip Ticket No</th>
                                            <th>Status</th>
                                            <th>Vehicle</th>
                                            <th>Vehicle Date Out</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(isset($rs))
                                            @foreach ($rs as $r)
                                                <tr>
                                                    <td>{{$r->refcode}}</td>
                                                    <td>{{ date('Y-m-d H:i A',strtotime($r->date_needed)) }}</td>
                                                    <td>{{$r->tripTicket}}</td>
                                                    <td>{{$r->Status}}</td>
                                                    <td>{{$r->name}} ({{$r->plateno}})</td>
                                                    <td>{{date('Y-m-d H:i A',strtotime($r->dateStart))}}</td>
                                                    <td>{{$r->purpose}}</td>
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

<script>
    function generate_report(d){
       window.location.href = "{{env('APP_URL')}}/vehicle/report/daily/"+d; 
    }
</script>
@endsection