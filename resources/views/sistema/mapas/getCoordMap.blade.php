@extends('layouts.mapa')

@section('styles')
    <style>
        #mapa{
            width:99.5%;
            height:440px;
            /*border: dashed 1px #666666;*/
        }
        #botonera{
            text-align:center !important;
            margin-top: 20px;
        }
        #coord{
            width:99.5%;
            height:20px;
        }

        #crd{
            width:99.5%;
            height:20px;
            position: absolute;/*this will position the div according to its parent div "map"*/
            top: 440px;
            left: 1px;
            background-color: rgba(255, 255, 255, 0.9);
            z-index:3;
            text-align:center;
            font-size:1em;
            font-weight:bold;
        }

        #bsqGeo{
            width:180px;
            padding: 5px;
            background-color: rgba(255, 255, 255, 0.9);
            text-align:center !important;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        #geocoder{
            margin-bottom: 4px;
        }
    </style>
@endsection

@section('content')
    <div id="mapa"></div>
    <div id="crd"></div>
    <div id="botonera">
        <button type='button' id="ag" class="btn btn-no-border btn-outline green">Agregar ubicación</button>
        <button type='button' id="el" class="btn btn-no-border btn-outline red">Eliminar ubicación</button>
    </div>
    <div id="nav"></div>

    <div id='bsqGeo'>
        <input type='text' id='geocoder'>
        <button type='button' id="srcGeo" class="btn btn-no-border btn-outline green" onClick='codeAddress()'>Buscar</button>
    </div>
@endsection

@section('scripts')
    <script src="http://maps.google.com/maps/api/js?libraries=drawing&key={{ env('GOOGLE_MAP_KEY') }}" type="text/javascript"></script>
    <script src="{{ URL::to('assets/global/plugins/gmaps/gmaps.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('assets/global/plugins/gmaps/maps.utilities.js') }}" type="text/javascript"></script>
@endsection


@section('script-body')
    <script>
        var geocoder = null;
        var customerMarker = null;
        var gmarkers = [];
        var closest = [];
        var directionsDisplay = new google.maps.DirectionsRenderer();;
        var directionsService = new google.maps.DirectionsService();



        function trunc(x) {
            return Math.round(x * 1000000) / 1000000;
        }

        function getLocationText(location) {
            return getDD2DMS(location.lat(),'lat')+' ||| '+getDD2DMS(location.lng(),'lon');
            // return 'long: ' + trunc(location.lng()) + ', lat: ' + trunc(location.lat());
        }

        function getLatLngByOffset( map, offsetX, offsetY ){
            var currentBounds = map.getBounds();
            var topLeftLatLng = new google.maps.LatLng( currentBounds.getNorthEast().lat(),currentBounds.getSouthWest().lng());
            var point = map.getProjection().fromLatLngToPoint( topLeftLatLng );
            point.x += offsetX / ( 1<<map.getZoom() );
            point.y += offsetY / ( 1<<map.getZoom() );
            return map.getProjection().fromPointToLatLng( point );
        }

        function getDD2DMS(dms, type){

            var sign = 1, Abs=0;
            var days, minutes, secounds, direction;

            if(dms < 0)  { sign = -1; }
            Abs = Math.abs( Math.round(dms * 1000000.));
            //Math.round is used to eliminate the small error caused by rounding in the computer:
            //e.g. 0.2 is not the same as 0.20000000000284
            //Error checks
            if(type == "lat" && Abs > (90 * 1000000)){
                //alert(" Degrees Latitude must be in the range of -90. to 90. ");
                return false;
            } else if(type == "lon" && Abs > (180 * 1000000)){
                //alert(" Degrees Longitude must be in the range of -180 to 180. ");
                return false;
            }

            days = Math.floor(Abs / 1000000);
            minutes = Math.floor(((Abs/1000000) - days) * 60);
            secounds = ( Math.floor((( ((Abs/1000000) - days) * 60) - minutes) * 100000) *60/100000 ).toFixed();
            days = days * sign;
            if(type == 'lat') direction = days<0 ? 'S' : 'N';
            if(type == 'lon') direction = days<0 ? 'W' : 'E';
            return (days * sign) + 'º ' + minutes + "' " + secounds + "'' " + direction;
        }

        $(document).ready(function(){
            $("#geocoder").addClass('md-input');

            var myMap = new google.maps.Map(document.getElementById('mapa'), {
                center: {lat: 8.094056, lng: -66.349830},
                zoom: 8
            });

            /****************************************************/
            geocoder = new google.maps.Geocoder();

            codeAddress = function() {
                var address = $('#geocoder').val();
                geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        myMap.setCenter(results[0].geometry.location);
                        myMap.setZoom(15);
                        if (customerMarker) customerMarker.setMap(null);
                        customerMarker = new google.maps.Marker({
                            map: myMap,
                            position: results[0].geometry.location
                        });

                    } else {
                        alert('Geocoder no funciono por: ' + status);
                    }
                });
            }

            /******************************************/


            // var poly;
            var drawingManager;
            var selectedShape;
            drawingManager = new google.maps.drawing.DrawingManager({
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [google.maps.drawing.OverlayType.POLYGON]
                },
                polygonOptions: {
                    editable: true,
                    strokeColor: "#005500",
                    strokeOpacity: 0.8,
                    strokeWeight: 3,
                    fillColor: "#009900",
                    fillOpacity: 0.35
                }
            });
            drawingManager.setMap(myMap);
            google.maps.event.addListener(drawingManager, "overlaycomplete", function(event) {
                drawingManager.setDrawingMode(null);
                var newShape = event.overlay;
                newShape.type = event.type;

                $("#ag").click(function(){setSelection(newShape);setArea(newShape);})
                setSelection(newShape);
            });

            function setSelection(shape) {
                clearSelection();
                selectedShape = shape;
                shape.setEditable(true);
            }
            function setArea(shape) {
                var vertices = shape.getPath();
                var contentString = '';
                for (var i =0; i < vertices.getLength(); i++) {
                    var xy = vertices.getAt(i);
                    contentString +=  xy.lng().toFixed(6)+',' + xy.lat().toFixed(6);
                }
                if(vertices.getLength()>1){
                    var pxy = vertices.getAt(0);
                    contentString +=  pxy.lng().toFixed(6)+',' + pxy.lat().toFixed(6);
                }


                parent.$('#mapaModal').modal('hide');
                parent.$("#{{ $id }}").val(contentString);
                contentString='';
            }
            function clearSelection() {
                if (selectedShape) {
                    selectedShape.setEditable(false);
                    selectedShape = null;
                }
            }
            function deleteSelectedShape() {
                if (selectedShape) {
                    selectedShape.setMap(null);

                    parent.$("#{{ $id }}").val('');
                }
            }

            $('#mapa').mousemove(function(evt){
                var posx = evt.pageX-this.offsetLeft;
                var posy = evt.pageY-this.offsetTop;
                point = getLatLngByOffset(myMap,posx,posy);
                $('#crd').html( 'Lat: '+point.lat().toFixed(6)+'  Lon: '+point.lng().toFixed(6));
            });

            $("#el").click(function(){deleteSelectedShape();})
        })

    </script>
@endsection