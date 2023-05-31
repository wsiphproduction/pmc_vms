@extends('layout.vehicle_utilization.reports')
<style>
    .printOnly {
       display : none;
    }

    @media print {
        .printOnly {
           display : block;
        }
        .page-content-wrapper{
            padding-right:50px;
        }
    }
</style>

@section('content')
<div class="printOnly" style="float:left;z-index:1000;position: absolute;top: 160px;width:100%;">
    <p style="float:right;font-size:30px;font-weight:bold;text-orientation: mixed; writing-mode: vertical-rl;">        
    </p>
</div>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <i class="fa fa-certificate"></i> <small>&nbsp;&nbsp;ESC</small>
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
                                        <form role="form" action="{{route('vehicle.report.dispatch_weekly')}}" method="GET">
                                            {{-- <div class="col-md-3">
                                                <label class="control-label">Departments</label>
                                                <select name="weekno" id="weekno" class="form-control" required>
                                                    <!-- <option value="">-- Select Department --</option> -->
                                                   
                                                </select>
                                               
                                            </div>                                                                                 
                                            <div class="col-md-2">
                                                <label class="control-label">&nbsp;</label>
                                                <button class="btn btn blue form-control" type="submit">
                                                    <span class="glyphicon glyphicon-refresh"></span> Generate
                                                </button>
                                            </div> --}}
                                            <div class="col-md-2 pull-right">
                                                <label class="control-label">&nbsp;</label>
                                                 <a class="btn purple form-control" href="javascript:window.print()"><span class="fa fa-print"></span> Print</a>
                                            </div>
                                            </form>                                            
                                            <div class="col-md-3" style="display: none;">
                                                <label class="control-label">&nbsp;</label>
                                                <ul class="list-inline">
                                                    {{-- <li>
                                                        <form method="POST" action="{{route('vehicle.report.exportToExcel')}}">
                                                            @csrf
                                                            <input type="hidden" name="date_from" value="{{request()->query('start')}}">
                                                            <input type="hidden" name="date_to" value="{{request()->query('end')}}">
                                                            <input type="hidden" name="driver" value="{{request()->query('driver')}}">
                                                            <input type="hidden" name="unit" value="{{request()->query('unit')}}">
                                                            <button type="submit" class="btn btn-circle blue" name="trip_tickets" id="excel-b"><i class="fa fa-file-excel-o"></i> Excel</button>
                                                        </form>
                                                    </li> --}}
                                                    <li>
                                                       
                                                    </li>
                                                </ul>
                                            </div>
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
                                    <span class="caption-subject bold uppercase"> ESC Vehicle List </span>
                                </div>                             
                            <div class="portlet-body">
                               <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>                                            
                                            <th>Vehicle Description</th>                                           
                                            <th>Type</th>      
                                            <th>Plate No.</th>      
                                            <th>Vehicle Code</th>                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                         @foreach ($units as $unit)
                                            <tr>                                                
                                                <td>{{ $unit->name}}</td>
                                                <td>{{ $unit->type }} </td>
                                                <td>{{ $unit->plateno}}</td>
                                                <td>{{ $unit->vechile_code}}</td>                 
                                            </tr>                                                
                                        @endforeach      
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
@endsection