@extends('layout.downtime_charts')

@section('content')

<div class="portlet-body" id="chartContainer6">									
	<img src="../metronic/assets/admin/layout/img/loading.gif" alt="loading" />				
</div>

@endsection


@push('scripts')

<script type="text/javascript">
    FusionCharts.ready(function(){
        var revenueChart = new FusionCharts({
            "type": "column2d",
            "renderAt": "chartContainer6",
            "width": "100%",
            "height": "200",
            "dataFormat": "json",
            "dataSource": {
                "chart": {
                "caption": "",
                "subCaption": "",
                "numbersuffix": "%",
                "yaxismaxvalue": "100",
                "theme": "fint",
                "palettecolors": "#0075c2",
                "alignCaptionWithCanvas": "0",
                "captionHorizontalPadding": "2",
                "captionOnTop": "0",
                "captionAlignment": "right"
                },
            "data": [
                {!! json_encode($str ?? '')  !!}
            ]
           }
       });
   
       revenueChart.render();
   })
   </script>

@endpush