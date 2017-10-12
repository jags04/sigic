@extends('layouts.graficos')

@section('styles')
    <link rel="stylesheet" href="{{ URL::to('assets/global/plugins/amcharts/amcharts/plugins/export/export.css') }}" type="text/css" media="all" />
    <style>
        .grafico{
            height:  50vh;
            width: 100%;
            margin: 0 auto;
        }
    </style>
@endsection

@section('content')
    <div id="grafico1" class="grafico"></div>
    <div id="grafico2" class="grafico"></div>
@endsection

@section('scripts')

    <script src="{{ URL::to('assets/global/plugins/amcharts/amcharts/amcharts.js') }}"></script>
    <script src="{{ URL::to('assets/global/plugins/amcharts/amcharts/serial.js') }}"></script>

    <script src="{{ URL::to('assets/global/plugins/amcharts/amcharts/plugins/responsive/responsive.min.js') }}"></script>
    <script src="{{ URL::to('assets/global/plugins/amcharts/amcharts/plugins/export/export.min.js') }}"></script>
    <script src="{{ URL::to('assets/global/plugins/amcharts/amcharts/themes/light.js') }}"></script>

@endsection


@section('script-body')
    <script>
        function initialize(){

            var chart = AmCharts.makeChart("grafico1", {
                /*"prefixesOfBigNumbers" : [{number:1e+3,prefix:"m"},{number:1e+6,prefix:"M"},{number:1e+9,prefix:"MM"},{number:1e+12,prefix:"B"},{number:1e+15,prefix:"P"},{number:1e+18,prefix:"E"},{number:1e+21,prefix:"Z"},{number:1e+24,prefix:"Y"}],
                 "usePrefixes" : true,*/
                "creditsPosition":"top-right",
                "decimalSeparator": ",",
                "thousandsSeparator": ".",
                "fontSize": 14,
                "theme": "light",
                "type": "serial",
                "startEffect" : 'bounce',
                "startDuration":0.3,
                "outlineColor": "",
                "allLabels": [{
                    "text": "{{ $result[1]['titulo'] }} (Producción)",
                    "align": "center",
                    "bold": true,
                    "size": 16,
                    "y": 10
                }],
                "marginTop": 50,
                "dataProvider": [
                    {!!  implode(" , ",$result[0]['des']) !!}
                ],
                "graphs": [{
                    "labelText": "[[value]]",
                    "labelPosition": "top",
                    "color": "#000",
                    "balloonText": "[[category]] : [[value]]",
                    "fillColorsField": "color",
                    "fillAlphas": 0.8,
                    "lineAlpha": 0.1,
                    "title": "Producción",
                    "type": "column",
                    "valueField": "produccion",
                    //"fixedColumnWidth": 100
                }],
                "depth3D": 25,
                "angle": 25.13,
                "categoryField": "anio",
                "categoryAxis": {
                    "gridPosition": "start",
                    "fillAlpha": 0.05,
                    "position": "left",
                    "fontSize": 14,
                    "gridCount" : {{ count($result[0]['des']) }},
                    "autoGridCount" : false,
                    /* "labelFunction": function(valueText, serialDataItem, categoryAxis) {
                     if (valueText.length > 30)
                     return valueText.substring(0, 30) + '...';
                     else
                     return valueText;
                     }*/
                },
                "valueAxes": [ {
                    "title": "",
                    "minimum": 0
                } ],
                "export": {
                    "enabled": true
                },
                "responsive": {
                    "enabled": true,
                    //"addDefaultRules": false,
                    "rules": [
                        {
                            "maxWidth": 300,
                            "overrides": {
                                "fontSize": 10,
                                "allLabels": [{
                                    "size": 8
                                }],
                                "categoryAxis": {
                                    "labelsEnabled": true
                                },
                                "depth3D": 5,
                                "valueAxes": {
                                    "labelsEnabled": false
                                },
                                "graphs": [{
                                    "labelText": "",
                                    "fixedColumnWidth": 20
                                }]
                            }
                        },
                        {
                            "maxHeight": 300,
                            "overrides": {
                                "fontSize": 10,
                                "allLabels": [{
                                    "size": 8
                                }],
                                "categoryAxis": {
                                    "labelsEnabled": true
                                },
                                "depth3D": 5,
                                "valueAxes": {
                                    "labelsEnabled": false
                                },
                                "graphs": [{
                                    "labelText": "",
                                    "fixedColumnWidth": 20
                                }]
                            }
                        }
                    ]
                }
            });


            var chart = AmCharts.makeChart("grafico2", {
                /*"prefixesOfBigNumbers" : [{number:1e+3,prefix:"m"},{number:1e+6,prefix:"M"},{number:1e+9,prefix:"MM"},{number:1e+12,prefix:"B"},{number:1e+15,prefix:"P"},{number:1e+18,prefix:"E"},{number:1e+21,prefix:"Z"},{number:1e+24,prefix:"Y"}],
                 "usePrefixes" : true,*/
                "creditsPosition":"top-right",
                "decimalSeparator": ",",
                "thousandsSeparator": ".",
                "fontSize": 14,
                "theme": "light",
                "type": "serial",
                "startEffect" : 'bounce',
                "startDuration":0.3,
                "outlineColor": "",
                "allLabels": [{
                    "text": "{{ $result[1]['titulo'] }} (Asignación de divisas)",
                    "align": "center",
                    "bold": true,
                    "size": 16,
                    "y": 10
                }],
                "marginTop": 50,
                "dataProvider": [
                    {!!  implode(" , ",$result[0]['des']) !!}
                ],
                "graphs": [{
                    "labelText": "[[value]]",
                    "labelPosition": "top",
                    "color": "#000",
                    "balloonText": "[[category]] : [[value]]",
                    "fillColorsField": "color2",
                    "fillAlphas": 0.8,
                    "lineAlpha": 0.1,
                    "title": "Asignación de divisas",
                    "type": "column",
                    "valueField": "asignacion",
                    //"fixedColumnWidth": 100
                }],
                "depth3D": 25,
                "angle": 25.13,
                "categoryField": "anio",
                "categoryAxis": {
                    "gridPosition": "start",
                    "fillAlpha": 0.05,
                    "position": "left",
                    "fontSize": 14,
                    "gridCount" : {{ count($result[0]['des']) }},
                    "autoGridCount" : false,
                    /* "labelFunction": function(valueText, serialDataItem, categoryAxis) {
                     if (valueText.length > 30)
                     return valueText.substring(0, 30) + '...';
                     else
                     return valueText;
                     }*/
                },
                "valueAxes": [ {
                    "title": "",
                    "minimum": 0
                } ],
                "export": {
                    "enabled": true
                },
                "responsive": {
                    "enabled": true,
                    //"addDefaultRules": false,
                    "rules": [
                        {
                            "maxWidth": 300,
                            "overrides": {
                                "fontSize": 10,
                                "allLabels": [{
                                    "size": 8
                                }],
                                "categoryAxis": {
                                    "labelsEnabled": true
                                },
                                "depth3D": 5,
                                "valueAxes": {
                                    "labelsEnabled": false
                                },
                                "graphs": [{
                                    "labelText": "",
                                    "fixedColumnWidth": 20
                                }]
                            }
                        },
                        {
                            "maxHeight": 300,
                            "overrides": {
                                "fontSize": 10,
                                "allLabels": [{
                                    "size": 8
                                }],
                                "categoryAxis": {
                                    "labelsEnabled": true
                                },
                                "depth3D": 5,
                                "valueAxes": {
                                    "labelsEnabled": false
                                },
                                "graphs": [{
                                    "labelText": "",
                                    "fixedColumnWidth": 20
                                }]
                            }
                        }
                    ]
                }
            });
        }

        $(function () {
            initialize();
        })


    </script>
@endsection