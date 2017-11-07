@extends('layouts.mapa')

@section('styles')
    <style>
        #legend{
            /*color: #FFF;*/
            background: rgba( 255, 255, 255 , 0.9);
            position: fixed;
            bottom: 20px;
            left: 20px;
            width: 30%;
            padding: 5px;
        }
    </style>
@endsection

@section('content')
    <div id="map"></div>
    <div id="legend" style="text-align: center !important;">
        <div class="row">
            <div class="col-md-12">
                <strong>MAPA PRODUCTIVO</strong>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <strong><span id="etiqueta">GENERAL</span></strong><br>
                @if(isset($request->rif))
                    <a href="#" onclick="location.href = '{{ route('sistema.mapasKmzIndustria') }}?rif={!! $request->rif !!}'" >Descarcar KMZ</a>
                @elseif(isset($request->edo))
                    <a href="#" onclick="location.href = '{{ route('sistema.mapasKmzIndustria') }}?edo={!! $request->edo !!}'" >Descarcar KMZ</a>
                @elseif(isset($request->sec))
                    <a href="#" onclick="location.href = '{{ route('sistema.mapasKmzIndustria') }}?sector={!! $request->sec !!}'" >Descarcar KMZ</a>
                @elseif(isset($request->subsector))
                    <a href="#" onclick="location.href = '{{ route('sistema.mapasKmzIndustria') }}?sec_cla={!! $request->sec_cla !!}&subsector={{ $request->subsector }}'" >Descarcar KMZ</a>
                @else
                    <a href="#" onclick="location.href = '{{ route('sistema.mapasKmzIndustria') }}'" >Descarcar KMZ</a>
                @endif
            </div>
        </div>
        <br>

        <button  class="btn btn-no-border btn-outline green" id="cargaAmb">Cargar ambitos</button>
    </div>
@endsection

@section('scripts')
    <script src="http://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}" type="text/javascript"></script>
    <script src="{{ URL::to('assets/global/plugins/gmaps/gmaps.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('assets/global/plugins/gmaps/ZipFile.complete.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('assets/global/plugins/gmaps/maps.utilities.js') }}" type="text/javascript"></script>
@endsection


@section('script-body')
    <script>
        function initialize(){
            var myMap = new google.maps.Map(document.getElementById('map'), {
                //center: {lat: 8.094056, lng: -66.349830},
                mapTypeId: 'terrain',
               // zoom: 7
            });

            infoBubble = new InfoBubble({
                maxWidth: 600, minWidth:600,
                maxHeight: 500, minHeight:500,
                shadowStyle: 1, padding: 5, borderRadius: 4,
                arrowSize: 20, borderWidth: 2, borderColor: '#CCCCCC',
                disableAutoPan: true, hideCloseButton: false, arrowPosition: 50,arrowStyle: 0
            });
            //infowindow = new google.maps.InfoWindow({});


            var clusterStyles = [
                {
                    textColor: 'black',
                    url: '{{ URL::to('assets/layouts/layout/img/markers/markerclusterer/g1.png') }}',
                    height: 40,
                    width: 40
                },
                {
                    textColor: 'black',
                    url: '{{ URL::to('assets/layouts/layout/img/markers/markerclusterer/g2.png') }}',
                    height: 50,
                    width: 50
                },
                {
                    textColor: 'black',
                    url: '{{ URL::to('assets/layouts/layout/img/markers/markerclusterer/g3.png') }}',
                    height: 60,
                    width: 60
                },
                {
                    textColor: 'black',
                    url: '{{ URL::to('assets/layouts/layout/img/markers/markerclusterer/g4.png') }}',
                    height: 70,
                    width: 70
                },
                {
                    textColor: 'black',
                    url: '{{ URL::to('assets/layouts/layout/img/markers/markerclusterer/g5.png') }}',
                    height: 80,
                    width: 80
                },
                {
                    textColor: 'black',
                    url: '{{ URL::to('assets/layouts/layout/img/markers/markerclusterer/g6.png') }}',
                    height: 90,
                    width: 90
                }
            ];

            var mcOptions = {gridSize: 80, styles: clusterStyles, maxZoom: 15};
            var markerclusterer  = new MarkerClusterer(myMap, [], mcOptions);
            showLoad();
            var myParser = new geoXML3.parser({
                map: myMap,
                zoom: true,
                createMarker:function(placemark){
                    var point = placemark.latlng;
                    var marker = new google.maps.Marker({position:point,icon: placemark.style.icon});
                    var info = "<div class='tinfo'>" + placemark.description + "</div>";
                    google.maps.event.addListener(marker, "click", function(){
                        infoBubble.setContent(info);
                        infoBubble.open(myMap, marker);
                    });
                    markerclusterer.addMarker(marker);
                }
            });

            estados = ["AMAZONAS","ANZOATEGUI","APURE","ARAGUA","BARINAS","BOLIVAR","CARABOBO","COJEDES","DELTA AMACURO","DTTO. CAPITAL","FALCON","GUARICO","LARA","MERIDA","MIRANDA","MONAGAS","NUEVA ESPARTA","PORTUGUESA","SUCRE","TACHIRA","TRUJILLO","VARGAS","YARACUY","ZULIA"];


            @if(isset($request->rif))
            myParser.parse(['{{ route('sistema.mapasKmzIndustria') }}?rif={!! $request->rif !!}']);
            $('#etiqueta').empty().html('EMPRESA ESPECÍFICA');
            $('#cargaAmb').click(function(){
                showLoad();
                myParser.parse(['{{ route('sistema.mapasKmzAmbitos') }}']);
            })
            @elseif(isset($request->edo))
            myParser.parse(['{{ route('sistema.mapasKmzIndustria') }}?edo={!! $request->edo !!}']);
            $('#etiqueta').empty().html('ESTADO: {!! $request->edo !!}');
            $('#cargaAmb').click(function(){
                showLoad();
                myParser.parse(['{{ route('sistema.mapasKmzAmbitos') }}?edo={!! $request->edo !!}']);
            })
            @elseif(isset($request->sec))
            myParser.parse(['{{ route('sistema.mapasKmzIndustria') }}?sector={!! $request->sec !!}']);
            $('#etiqueta').empty().html('SECTOR: {!! $request->sec !!}');
            $('#cargaAmb').click(function(){
                showLoad();
                myParser.parse(['{{ route('sistema.mapasKmzAmbitos') }}']);
            })
            @elseif(isset($request->subsector))
            myParser.parse(['{{ route('sistema.mapasKmzIndustria') }}?sec_cla={!! $request->sec_cla !!}&subsector={{ $request->subsector }}']);
            $('#etiqueta').empty().html('SECTOR: {{ $request->sec_cla }} - SUBSECTOR: {{ $request->subsector }}');
            $('#cargaAmb').click(function(){
                showLoad();
                myParser.parse(['{{ route('sistema.mapasKmzAmbitos') }}']);
            })
            @else
            myParser.parse(['{{ route('sistema.mapasKmzIndustria') }}']);
            $('#etiqueta').empty().html('GENERAL');
            $('#cargaAmb').click(function(){
                showLoad();
                myParser.parse(['{{ route('sistema.mapasKmzAmbitos') }}']);
            })
            @endif

            google.maps.event.addListener(myParser,'parsed', function() {
                /*var b = performance.now();
                document.getElementById('perf').innerHTML = 'load time ' + ((b - a)/1000).toFixed(2) + ' seconds';*/
                hideLoad();
            });

        }

        $(function () {
            initialize();
        })

        /*function gmapPrint() {
            var content = window.document.body; // get you map details
            var newWindow = window.open(); // open a new window
            newWindow.document.write(content.innerHTML); // write the map into the new window
            newWindow.print(); // print the new window
        }*/

    </script>
@endsection