@extends('layout.utilization')

@section('content')

<div class="page-content-wrapper">
<div class="page-content">
<div class="modal fade" id="newrequest" tabindex="-1" role="newrequest" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<form method="post" action="request_list_requestor.php?act=submit">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title">New Vehicle Request</h4>
</div>
<div class="modal-body" style="height:300px">
<input type="hidden" name="action" value="add">
<table>
<tr>
<td> Date Needed: </td>
<td>
<div class="input-group date form_datetime">
<input type="text" size="16" readonly class="form-control" name="date_needed"
required="required">
<span class="input-group-btn">
<button class="btn default date-set" type="button"><i
class="fa fa-calendar"></i></button>
</span>
</div>
<br>
</td>
</tr>
<tr>
<td>Chargeable Cost Code:</td>
<td>
<input type="text" name="costcode" class="form-control" placeholder="Cost Code"><br>
</td>
</tr>
<tr>
<td>From: </td>
<td>
<input type="text" name="from" class="form-control" placeholder="Origin"><br>
</td>
</tr>
<tr>
<td>To:</td>
<td>
<input type="text" name="to" class="form-control" placeholder="Destination"><br>
</td>
</tr>
<tr>
<td>Purpose</td>
<td>
<textarea name="purpose" class="form-control" id="purpose" cols="50" rows="3"
required="required"></textarea>
</td>
</tr>
</table>
</div>
<div class="modal-footer" id="footermode">
<button type="button" class="btn default" data-dismiss="modal">Cancel</button>
<input type="submit" class="btn blue" value="Save">
</div>
</form>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<!-- BEGIN PAGE TITLE & BREADCRUMB-->
<a href="{{ route('vehicle.request.list') }}" class="btn btn blue"><i class="fa fa-list-alt"></i> Request List</a>
<br><br>
</div>
</div>
<div class="row">
<div class="col-md-6 col-sm-12">
<div class="portlet box red">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-bar-chart"></i> TOTAL DISPATCHES PER VEHICLES
</div>
<div class="tools">
<?php
$dt = date('y-m-d');
$dt1 = date("Y-m-01", strtotime($dt));
$dt2 = date("Y-m-t", strtotime($dt));
?>
<a href="{{ route('vehicle.report.total.dispatch', ['start' => $dt1, 'end' => $dt2]) }}" style="color:white;" target="_blank">
<i class="fa fa-file-o"></i>
</a>
<a href="" class="reload"></a>
<a href="javascript:;" class="collapse"> </a>
</div>
</div>
<div class="portlet-body">
<div class="row">
<div class="col-md-12 col-sm-12">
<iframe style="height:418px;" src="{{ route('utilization.dispatches-vehicle') }}" width="100%" class="iframe"
scrolling="yes" frameborder="0"></iframe>
</div>
</div>
</div>
</div>
</div>
<div class="col-md-6 col-sm-12">
<div class="portlet box red">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-pie-chart"></i> VEHICLES DISTANCE TRAVELLED
</div>
<div class="tools">
<a href="{{ route('vehicle.report.total.distance', ['start' => $dt1, 'end' => $dt2]) }}" style="color:white;" target="_blank">
<i class="fa fa-file-o"></i>
</a>
<a href="" class="reload"></a>
<a href="javascript:;" class="collapse"> </a>
</div>
</div>
<div class="portlet-body">
<div class="row">
<div class="col-md-12 col-sm-12">
<iframe style="height:418px;" src="{{ route('utilization.distance-travelled') }}" width="100%" class="iframe"
scrolling="yes" frameborder="0"></iframe>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<!-- <div class="col-md-10 col-md-offset-1 col-sm-12"> -->
<div class="col-md-6 col-sm-12">
<div class="portlet box red">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-bar-chart"></i> DISPATCH DISTRIBUTION PER DEPARTMENT
</div>
<div class="tools">
<a href="{{ route('vehicle.report.dipstachdepartment', ['start' => $dt1, 'end' => $dt2]) }}"
style="color:white;" target="_blank">
<i class="fa fa-file-o"></i>
</a>
<a href="" class="reload"></a>
<a href="javascript:;" class="collapse"> </a>
</div>
</div>
<div class="portlet-body">
<div class="row">
<div class="col-md-12 col-sm-12">
<iframe style="height:418px;" src="{{ route('utilization.dispatches-department') }}" width="100%" class="iframe"
scrolling="yes" frameborder="0"></iframe>
</div>
</div>
</div>
</div>
</div>
<!-- <div class="col-md-10 col-md-offset-1 col-sm-12"> -->
<div class="col-md-6 col-sm-12">
<div class="portlet box red">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-pie-chart"></i> FREQUENT DESTINATIONS
</div>
<div class="tools">
<a href="{{ route('vehicle.report.topdestination', ['start' => $dt1, 'end' => $dt2]) }}" style="color:white;" target="_blank">
<i class="fa fa-file-o"></i>
</a>
<a href="" class="reload"></a>
<a href="javascript:;" class="collapse"> </a>
</div>
</div>
<div class="portlet-body">
<div class="row">
<div class="col-md-12 col-sm-12">
<iframe style="height:418px;" src="{{ route('utilization.frequent-destination') }}" width="100%" class="iframe"
scrolling="yes" frameborder="0"></iframe>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="clearfix">
</div>
</div>
</div>

@endsection



@push('script')

<script>
function exportToExcel(table){
jQuery(table).table2excel({
name: "VMS",
filename: "VMS" //do not include extension
});
}
</script>

<script>
jQuery(document).ready(function() {
Metronic.init(); // init metronic core components
Layout.init(); // init current layout
TableAdvanced.init();
ComponentsPickers.init();
//exportToExcel('#maintenance_excel');
});
</script>
<script>
var TableAdvanced = function () {
var initTable4 = function () {
var table = $('#sample_4');

var oTable = table.dataTable({
"columnDefs": [{
"orderable": false,
"targets": [0]
}],
"order": [
[0, 'desc']
],
"lengthMenu": [
[5, 15, 20, -1],
[5, 15, 20, "All"]
],
"pageLength": 300,
});
}
return {
init: function () {
if (!jQuery().dataTable) {
return;
}
initTable4();
}
};
}();
</script>
<script>
function deleted(x){
var r = confirm("Are you sure you want to delete this record?");
if (r == true) {
window.location = "downtimes.php?act=delete&id="+x;
} else {
return false;
}
}
</script>


{{-- update utilization --}}

@endpush