<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Highcharts</title>

    <!--<link href="{{ URL::to('assets/global/plugins/highcharts_5.0.4/css/highcharts.css') }}" rel="stylesheet" type="text/css" />-->
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

<script src="{{ URL::to('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/highcharts.6.0.2/highmaps.js') }}"></script>
<script src="{{ URL::to('assets/global/plugins/highcharts.6.0.2/modules/exporting.js') }}" type="text/javascript"></script>



<div id="container">
    <div class="loading">
        <i class="icon-spinner icon-spin icon-large"></i>
        Loading data from Google Spreadsheets...
    </div>
</div>



<script type="text/javascript">

    $(function () {

        mapData = {!! $datos[0] !!};
        dataMap= {!! $datos[1] !!};
        label  = {!! $datos[2] !!};

        // Initiate the chart
        Highcharts.mapChart('container', {
            chart: {
                borderWidth: 0
            },
            title: {
                text: 'Productividad por estado'
            },
            subtitle: {
                text: '{{ $datos[3] }} al {{ $datos[4] }}'
            },

            mapNavigation: {
                enabled: true
            },

            legend: {
                title: {
                    text: '% Productividad',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                    }
                },
                align: 'left',
                verticalAlign: 'bottom',
                floating: true,
                layout: 'vertical',
                valueDecimals: 0,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || 'rgba(255, 255, 255, 0.85)',
                symbolRadius: 7,
                symbolHeight: 14
            },

            colorAxis: {
                dataClasses: label
            },

            series: [{
                data: mapData,
                mapData: dataMap,
                joinBy: ['id', 'id'],
                animation: true,
                name: 'Productividad/estado',
                states: {
                    hover: {
                        color: '#AF2D2D'
                    }
                },
                tooltip: {
                    valueSuffix: '%'
                },
                shadow: false
            }]
        });

    });


</script>










<!--
<div id="container"></div>

<script src="{{ URL::to('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/highcharts_5.0.4/js/highmaps.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/highcharts_5.0.4/js/modules/exporting.js') }}" type="text/javascript"></script>
<script>

    $(function () {

        mapData = {!! $datos[0] !!};
        dataMap= {!! $datos[1] !!};

                // Initiate the chart
        Highcharts.mapChart('container', {
            chart: {
                borderWidth: 1
            },

            colors: ['rgba(19,64,117,0.05)', 'rgba(19,64,117,0.2)', 'rgba(19,64,117,0.4)',
                'rgba(19,64,117,0.5)', 'rgba(19,64,117,0.6)', 'rgba(19,64,117,0.8)', 'rgba(19,64,117,1)'],

            title: {
                text: 'Population density by country (/km²)'
            },

            mapNavigation: {
                enabled: true
            },

            legend: {
                title: {
                    text: 'Individuals per km²',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                    }
                },
                align: 'left',
                verticalAlign: 'bottom',
                floating: true,
                layout: 'vertical',
                valueDecimals: 0,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || 'rgba(255, 255, 255, 0.85)',
                symbolRadius: 0,
                symbolHeight: 14
            },

            colorAxis: {
                dataClasses: [{
                    to: 3
                }, {
                    from: 3,
                    to: 10
                }, {
                    from: 10,
                    to: 30
                }, {
                    from: 30,
                    to: 100
                }, {
                    from: 100,
                    to: 300
                }, {
                    from: 300,
                    to: 1000
                }, {
                    from: 1000
                }]
            },

            series: [{
                data: mapData,
                mapData: dataMap,
                joinBy: ['id', 'id'],
                animation: true,
                name: 'Productividad/estado',
                states: {
                    hover: {
                        color: '#a4edba'
                    }
                },
                tooltip: {
                    valueSuffix: '%'
                },
                shadow: false
            }]
        });








       /* Highcharts.mapChart('container', {
            title: {
                text: 'GeoJSON in Highmaps'
            },
            mapNavigation: {
                enabled: true,
                buttonOptions: {
                    verticalAlign: 'bottom'
                }
            },

            colorAxis: {
                tickPixelInterval: 100
            },

            series: [{
                data: mapData,
                mapData: dataMap,
                joinBy: ['id', 'id'],
                name: 'Random data',
                states: {
                    hover: {
                        color: '#a4edba'
                    }
                },
                dataLabels: {
                    enabled: true,
                    //format: '{point.properties.cant}'
                }
            }]
        });





     var data = [
            ['DE.SH', 728],
            ['DE.BE', 710],
            ['DE.MV', 963],
            ['DE.HB', 541],
            ['DE.HH', 622],
            ['DE.RP', 866],
            ['DE.SL', 398],
            ['DE.BY', 785],
            ['DE.SN', 223],
            ['DE.ST', 605],
            ['DE.NW', 237],
            ['DE.BW', 157],
            ['DE.HE', 134],
            ['DE.NI', 136],
            ['DE.TH', 704],
            ['DE.', 361]
        ];

        $.getJSON('https://www.highcharts.com/samples/data/jsonp.php?filename=germany.geo.json&callback=?', function (geojson) {

            // Initiate the chart
            Highcharts.mapChart('container', {

                title: {
                    text: 'GeoJSON in Highmaps'
                },

                mapNavigation: {
                    enabled: true,
                    buttonOptions: {
                        verticalAlign: 'bottom'
                    }
                },

                colorAxis: {
                    tickPixelInterval: 100
                },

                series: [{
                    data: data,
                    mapData: geojson,
                    joinBy: ['code_hasc', 0],
                    keys: ['code_hasc', 'value'],
                    name: 'Random data',
                    states: {
                        hover: {
                            color: '#a4edba'
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        format: '{point.properties.postal}'
                    }
                }]
            });
        });*/


       /* mapData = {!! $datos[0] !!};
        dataMap= {!! $datos[1] !!};
        label  = {!! $datos[2] !!};

        Highcharts.mapChart('container', {
            title : {
                text : 'Productividad por Estados'
            },
            colors: ['rgba(19,64,117,0.05)', 'rgba(19,64,117,0.2)', 'rgba(19,64,117,0.4)',
                'rgba(19,64,117,0.5)', 'rgba(19,64,117,0.6)', 'rgba(19,64,117,0.8)', 'rgba(19,64,117,1)'],


            mapNavigation: {
                enabled: true,
                buttonOptions: {
                    verticalAlign: 'top'
                }
            },
            legend: {
                title: {
                    text: 'Productividad:'
                },
                align: 'left',
                verticalAlign: 'bottom',
                floating: true,
                labelFormatter: function () {

                    var f=Highcharts.numberFormat(this.from,0, ',', '.');
                    if(typeof(this.to) === "undefined"){
                        var t='o Más'
                    }
                    else{
                        var t=Highcharts.numberFormat(this.to,0, ',', '.') ;
                    }

                    return (f) + ' - ' + (t);
                },
                layout: 'vertical',
                valueDecimals: 0,
                backgroundColor: 'rgba(255,255,255,0.9)',
                padding: 12,
                itemMarginTop: 0,
                itemMarginBottom: 0,
                symbolRadius: 0,
                symbolHeight: 14,
                symbolWidth: 24
            },

            colorAxis: {
                dataClasses: [{
                    to: 3
                }, {
                    from: 3,
                    to: 10
                }, {
                    from: 10,
                    to: 30
                }, {
                    from: 30,
                    to: 40
                }, {
                    from: 40,
                    to: 60
                }, {
                    from: 60,
                    to: 90
                }, {
                    from: 90
                }]
            },
            series:[{
                animation: { duration: 1000},
                data: mapData,
                mapData: dataMap,
                joinBy: ['id', 'id']
            }]
        });*/

    })
</script>-->
</body>
</html>
