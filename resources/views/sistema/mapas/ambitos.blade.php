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
                <strong>AMBITOS INDUSTRIALES</strong>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <strong><span id="etiqueta">GENERAL</span></strong><br>

                @if($request->has('edo'))
                    <a href="#" onclick="location.href = '{{ route('sistema.mapasKmzAmbitos') }}?edo={!! $request->edo !!}'" >Descarcar KMZ</a>
                @elseif($request->has('id'))
                    <a href="#" onclick="location.href = '{{ route('sistema.mapasKmzAmbitos') }}?id={!! $request->id !!}'" >Descarcar KMZ</a>
                @else
                    <a href="#" onclick="location.href = '{{ route('sistema.mapasKmzAmbitos') }}'" >Descarcar KMZ</a>
                @endif


            </div>
        </div>
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
                center: {lat: 8.094056, lng: -66.349830},
                mapTypeId: 'terrain',
                zoom: 7
            });

            infoBubble = new InfoBubble({
                maxWidth: 600,
                minWidth:320,
                maxHeight: 600,
                minHeight:220,
                shadowStyle: 1,
                padding: 5,
                borderRadius: 4,
                arrowSize: 20,
                borderWidth: 2,
                borderColor: '#CCCCCC',
                disableAutoPan: true,
                hideCloseButton: false,
                arrowPosition: 50,
                arrowStyle: 0
            });
            infowindow = new google.maps.InfoWindow({});


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
                }
            });
            google.maps.event.addListener(myParser,'parsed', function() {
                /*var b = performance.now();
                 document.getElementById('perf').innerHTML = 'load time ' + ((b - a)/1000).toFixed(2) + ' seconds';*/
                hideLoad();
            });

            //myParser.parse(['{{ URL::to('/kml/ambitos.kml') }}']);


            @if($request->has('edo'))
            myParser.parse(['{{ route('sistema.mapasKmzAmbitos') }}?edo={!! $request->edo !!}']);
            $('#etiqueta').empty().html('ESTADO: {!! $request->edo !!}');
            @elseif($request->has('id'))
            myParser.parse(['{{ route('sistema.mapasKmzAmbitos') }}?id={!! $request->id !!}']);
            $('#etiqueta').empty().html('AMBITOS ESPECIFICO');
            @else
            myParser.parse(['{{ route('sistema.mapasKmzAmbitos') }}']);
            $('#etiqueta').empty().html('GENERAL');
            @endif
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