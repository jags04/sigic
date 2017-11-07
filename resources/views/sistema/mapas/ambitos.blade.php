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
                <br>
                <button  class="btn btn-no-border btn-outline green" onclick="javascript:location.reload()">Actualizar mapa</button>


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
                singleInfoWindow: true,
                suppressInfoWindows: true,
                createPolygon: function(placemark) {

                    var bounds = new google.maps.LatLngBounds();
                    var pathsLength = 0;
                    var paths = [];
                    for (var polygonPart=0;polygonPart<placemark.Polygon.length;polygonPart++) {
                        for (var j=0; j<placemark.Polygon[polygonPart].outerBoundaryIs.length; j++) {
                            var coords = placemark.Polygon[polygonPart].outerBoundaryIs[j].coordinates;
                            var path = [];
                            for (var i=0;i<coords.length;i++) {
                                var pt = new google.maps.LatLng(coords[i].lat, coords[i].lng);
                                path.push(pt);
                                bounds.extend(pt);
                            }
                            paths.push(path);
                            pathsLength += path.length;
                        }
                        for (var j=0; j<placemark.Polygon[polygonPart].innerBoundaryIs.length; j++) {
                            var coords = placemark.Polygon[polygonPart].innerBoundaryIs[j].coordinates;
                            var path = [];
                            for (var i=0;i<coords.length;i++) {
                                var pt = new google.maps.LatLng(coords[i].lat, coords[i].lng);
                                path.push(pt);
                                bounds.extend(pt);
                            }
                            paths.push(path);
                            pathsLength += path.length;
                        }
                    }
                    var polygon = myParser.createPolygon(placemark);

                    google.maps.event.addListener(polygon, 'click', function(event) {


                        @if(Auth::user()->rol == 10 || Auth::user()->rol == 1)

                        if(confirm('Desea editar el poligono?')){
                            var ids = placemark.name.split('-');
                            var param = { 'amb_id' : ids[0],'pol_id' : ids[1], 'pol' : paths, '_token': '{!! csrf_token() !!}'};

                            OpenWindowWithPost("{{ route('sistema.ambitos.editPol') }}",
                                'height=700, width='+(screen.width-50),
                                "NewFile", param);
                        }
                        else{
                            var myLatlng = event.latLng;
                            infowindow.setContent("<h1>"+placemark.name+"</h1><br>"+placemark.description);
                            infowindow.setPosition(myLatlng);
                            infowindow.open(myMap);
                        }
                        @else
                            var myLatlng = event.latLng;
                            infowindow.setContent("<h1>"+placemark.name+"</h1><br>"+placemark.description);
                            infowindow.setPosition(myLatlng);
                            infowindow.open(myMap);
                        @endif

                    });
                    return polygon;
                    //event.latLng.toUrlValue(6)
                }/**/
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
            $('#etiqueta').empty().html('AMBITOS ESPECIFICO - {{ $request->amb }}');
            @else
            myParser.parse(['{{ route('sistema.mapasKmzAmbitos') }}']);
            $('#etiqueta').empty().html('GENERAL');
            @endif
        }
        $(function () {
            initialize();
        })

        function OpenWindowWithPost(url, windowoption, name, params){
            var form = document.createElement("form");
            form.setAttribute("method", "post");
            form.setAttribute("action", url);
            form.setAttribute("target", name);

            for (var i in params) {
                if (params.hasOwnProperty(i)) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = i;
                    input.value = params[i];
                    form.appendChild(input);
                }
            }
            document.body.appendChild(form);
            //note I am using a post.htm page since I did not want to make double request to the page
            //it might have some Page_Load call which might screw things up.
            window.open(url, name, windowoption);
            form.submit();
            document.body.removeChild(form);
        }



        /*function gmapPrint() {
            var content = window.document.body; // get you map details
            var newWindow = window.open(); // open a new window
            newWindow.document.write(content.innerHTML); // write the map into the new window
            newWindow.print(); // print the new window
        }*/

    </script>
@endsection