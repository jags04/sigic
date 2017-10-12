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
            var chart1 = AmCharts.makeChart( "grafico1", {
                "type": "serial",
                "addClassNames": true,
                "theme": "light",
                "autoMargins": false,
                "marginLeft": 100,
                "marginRight": 50,
                "marginTop":50,
                "marginBottom": 50,
                "allLabels": [{
                    "text": "{{ $result[1]['titulo'] }} - Producción",
                    "align": "center",
                    "bold": true,
                    "size": 16,
                    "y": 10
                }],
                "balloon": {
                    "adjustBorderColor": false,
                    "horizontalPadding": 10,
                    "verticalPadding": 8,
                    "color": "#ffffff"
                },

                "dataProvider": [ {!!  implode(" , ",$result[0]['des']) !!} ],
                "valueAxes": [ {
                    "axisAlpha": 0,
                    "position": "left"
                } ],
                "startDuration": 1,
                "graphs": [ {
                    "alphaField": "alpha",
                    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                    "fillAlphas": 1,
                    "title": "Producción",
                    "type": "column",
                    "fillColorsField": "color",
                    "valueField": "produccion",
                    "dashLengthField": "dashLengthColumn"
                }/*, {
                    "id": "graph2",
                    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                    "bullet": "round",
                    "lineThickness": 3,
                    "bulletSize": 7,
                    "bulletBorderAlpha": 1,
                    "bulletColor": "#FFFFFF",
                    "useLineColorForBulletBorder": true,
                    "bulletBorderThickness": 3,
                    "fillAlphas": 0,
                    "lineAlpha": 1,
                    "title": "Expenses",
                    "valueField": "produccion",
                    "dashLengthField": "dashLengthLine"
                } */],
                "categoryField": "anio",
                "categoryAxis": {
                    "gridPosition": "start",
                    "axisAlpha": 0,
                    "tickLength": 0
                },
                "export": {
                    "enabled": true
                }
            } );

           var chart2 = AmCharts.makeChart( "grafico2", {
                "type": "serial",
                "addClassNames": true,
                "theme": "light",
                "autoMargins": false,
                "marginLeft": 100,
                "marginRight": 50,
                "marginTop":50,
                "marginBottom": 50,
               "allLabels": [{
                   "text": "{{ $result[1]['titulo'] }} - Asignación de divisas",
                   "align": "center",
                   "bold": true,
                   "size": 16,
                   "y": 10
               }],
                "balloon": {
                    "adjustBorderColor": false,
                    "horizontalPadding": 10,
                    "verticalPadding": 8,
                    "color": "#ffffff"
                },

                "dataProvider": [ {!!  implode(" , ",$result[0]['des']) !!} ],
                "valueAxes": [ {
                    "axisAlpha": 0,
                    "position": "left"
                } ],
                "startDuration": 1,
                "graphs": [ {
                    "alphaField": "alpha",
                    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                    "fillAlphas": 1,
                    "title": "Asignacion en divisas",
                    "fillColorsField": "color",
                    "type": "column",
                    "valueField": "asignacion",
                    "dashLengthField": "dashLengthColumn"
                }/*, {
                    "id": "graph2",
                    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                    "bullet": "round",
                    "lineThickness": 3,
                    "bulletSize": 7,
                    "bulletBorderAlpha": 1,
                    "bulletColor": "#FFFFFF",
                    "useLineColorForBulletBorder": true,
                    "bulletBorderThickness": 3,
                    "fillAlphas": 0,
                    "lineAlpha": 1,
                    "title": "Expenses",
                    "valueField": "produccion",
                    "dashLengthField": "dashLengthLine"
                }*/ ],
                "categoryField": "anio",
                "categoryAxis": {
                    "gridPosition": "start",
                    "axisAlpha": 0,
                    "tickLength": 0
                },
                "export": {
                    "enabled": true
                }
            } );
        }

        $(function () {
            initialize();
        })


        /**
         *
         * var chart1 = AmCharts.makeChart( "grafico1", {
                "type": "serial",
                "addClassNames": true,
                "theme": "light",
                "autoMargins": false,
                "marginLeft": 100,
                "marginRight": 50,
                "marginTop":50,
                "marginBottom": 50,
                "allLabels": [{
                    "text": "{{ $result[1]['titulo'] }}",
                    "align": "center",
                    "bold": true,
                    "size": 16,
                    "y": 10
                }],
                "balloon": {
                    "adjustBorderColor": false,
                    "horizontalPadding": 10,
                    "verticalPadding": 8,
                    "color": "#ffffff"
                },

                "dataProvider": [ {!!  implode(" , ",$result[0]['des']) !!} ],
                "valueAxes": [ {
                    "axisAlpha": 0,
                    "position": "left"
                } ],
                "startDuration": 1,
                "graphs": [ {
                    "alphaField": "alpha",
                    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                    "fillAlphas": 1,
                    "title": "Income",
                    "type": "column",
                    "valueField": "asignacion",
                    "dashLengthField": "dashLengthColumn"
                }, {
                    "id": "graph2",
                    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                    "bullet": "round",
                    "lineThickness": 3,
                    "bulletSize": 7,
                    "bulletBorderAlpha": 1,
                    "bulletColor": "#FFFFFF",
                    "useLineColorForBulletBorder": true,
                    "bulletBorderThickness": 3,
                    "fillAlphas": 0,
                    "lineAlpha": 1,
                    "title": "Expenses",
                    "valueField": "produccion",
                    "dashLengthField": "dashLengthLine"
                } ],
                "categoryField": "anio",
                "categoryAxis": {
                    "gridPosition": "start",
                    "axisAlpha": 0,
                    "tickLength": 0
                },
                "export": {
                    "enabled": true
                }
            } );
         */


    </script>
@endsection