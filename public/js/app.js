$(function() {
    $.ajax({

        url: 'http://localhost:81/sophos/ajax/virussummary.php?startdate=2016-05-01&enddate=2016-05-31',
        type: 'GET',
        success: function(data) {
            chartData = data;
            var chartProperties = {
                "caption": "Top 10 wicket takes ODI Cricket in 2015",
                "xAxisName": "Player",
                "yAxisName": "Wickets Taken",
                "rotatevalues": "1",
                "theme": "zune"
            };

            apiChart = new FusionCharts({
                type: 'column2d',
                renderAt: 'chart-container',
                width: '550',
                height: '350',
                dataFormat: 'json',
                dataSource: {
                    "chart": chartProperties,
                    "data": chartData
                }
            });
            apiChart.render();
        }
    });
});