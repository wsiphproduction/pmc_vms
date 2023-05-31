
<html>
    <head>
        {{-- This file is not provided therefore causes errors on view --}}
        <link rel="stylesheet" type="text/css" href="{{ asset('js/themes/fusioncharts.theme.fusion.css') }}"></link> 
        <title></title>
        <script type="text/javascript" src="{{ asset('js/fusioncharts.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/themes/fusioncharts.theme.fusion.js') }}"></script>
    </head>
    <body>
    
        <div class="col-md-6" id="chart-3"> </div>
       
        <script>
            FusionCharts.ready(function(){
                FusionCharts.printManager.enabled(true);
                let fusioncharts = new FusionCharts({
                    type: 'column2D',
                    renderAt: 'chart-3',
                    width: '100%',
                    height: '500',
                    dataFormat: 'json',
                    dataSource: {!! json_encode($jsondata ?? '')  !!}
                });
                fusioncharts.render();
            });
        </script>
        
    </body>
    </html>