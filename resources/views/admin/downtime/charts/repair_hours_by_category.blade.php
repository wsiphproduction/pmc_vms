@extends('layout.downtime_charts')

@section('content')

<div class="portlet-body" id="chartContainer">									
	<img src="../metronic/assets/admin/layout/img/loading.gif" alt="loading"/>								
</div>

@endsection

@push('scripts')

<script type="text/javascript">
FusionCharts.ready(function(){
    var revenueChart = new FusionCharts({
    "type": "pie2d",
    "renderAt": "chartContainer",
    "width": "100%",
    "height": "400",
    "dataFormat": "json",
    "dataSource": {
        "chart": {
            "caption": "",
            "subCaption": "",
            "showpercentvalues": "1",
        },
        "data": [
            {!! json_encode($str ?? '')  !!}
        ]
    }
    });

    revenueChart.render();
});
</script>

@endpush