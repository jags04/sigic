<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Highcharts</title>

  <!-- <link href="{{ URL::to('assets/global/plugins/highcharts_5.0.4/css/highcharts.css') }}" rel="stylesheet" type="text/css" />-->
    <style type="text/css">
        body, html {
            height: 100%;
        }

        #container {
            height: 90%;
            width: 100%;
        }
    </style>
</head>
<body>

<div id="container"></div>

<!--<script src="{{ URL::to('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>-->
<script src="{{ URL::to('assets/global/plugins/highcharts.6.0.2/highcharts.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/highcharts.6.0.2/highcharts-3d.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/highcharts.6.0.2/highcharts-more.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/highcharts.6.0.2/modules/exporting.js') }}" type="text/javascript"></script>

<script type="text/javascript">

    Highcharts.setOptions({
        colors: [
            '#50B432',
            '#ED561B',
            '#DDDF00',
            '#24CBE5',
            '#64E572',
            '#FF9655',
            '#FFF263',
            '#6AF9C4'
        ]
    });

       Highcharts.chart('container', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 30,
                    beta: 0
                }
            },
            title: {
                text: 'Segmentación de las plantas ( {{ $datos[0]['f1']}} al {{ $datos[1]['f2'] }})'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    depth: 45,
                    dataLabels: {
                        enabled: true,
                        format: '{point.name} ({point.percentage:.1f}%)'
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Seg. cant.',
                data: [ {!! $datos[2]['data'] !!} ]
            }]
        });

</script>
</body>
</html>