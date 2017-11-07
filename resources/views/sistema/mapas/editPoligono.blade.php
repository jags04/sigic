@extends('layouts.mapa')

@section('styles')
    <style>
        #mapa{
            width:99.5%;
            height:95vh;
            /*border: dashed 1px #666666;*/
        }
        .delete-menu {
            position: absolute;
            background: white;
            padding: 3px;
            color: #666;
            font-weight: bold;
            border: 1px solid #999;
            font-family: sans-serif;
            font-size: 12px;
            box-shadow: 1px 3px 3px rgba(0, 0, 0, .3);
            margin-top: -10px;
            margin-left: 10px;
            cursor: pointer;
        }
        .delete-menu:hover {
            background: #eee;
        }

    </style>
@endsection

@section('content')
    <div id="mapa"></div>
@endsection

@section('scripts')
    <script src="http://maps.google.com/maps/api/js?libraries=drawing&key={{ env('GOOGLE_MAP_KEY') }}" type="text/javascript"></script>
    <script src="{{ URL::to('assets/global/plugins/gmaps/gmaps.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('assets/global/plugins/gmaps/maps.utilities.js') }}" type="text/javascript"></script>
@endsection


@section('script-body')
    <script>
        google.maps.Polygon.prototype.my_getBounds=function(){
            var bounds = new google.maps.LatLngBounds()
            this.getPath().forEach(function(element,index){bounds.extend(element)})
            return bounds
        }


        /**
         * A menu that lets a user delete a selected vertex of a path.
         * @constructor
         */
        function DeleteMenu() {
            this.div_ = document.createElement('div');
            this.div_.className = 'delete-menu';
            this.div_.innerHTML = 'Eliminar punto';

            var menu = this;
            google.maps.event.addDomListener(this.div_, 'click', function() {
                menu.removeVertex();
            });
        }
        DeleteMenu.prototype = new google.maps.OverlayView();

        DeleteMenu.prototype.onAdd = function() {
            var deleteMenu = this;
            var map = this.getMap();
            this.getPanes().floatPane.appendChild(this.div_);

            // mousedown anywhere on the map except on the menu div will close the
            // menu.
            this.divListener_ = google.maps.event.addDomListener(map.getDiv(), 'mousedown', function(e) {
                if (e.target != deleteMenu.div_) {
                    deleteMenu.close();
                }
            }, true);
        };

        DeleteMenu.prototype.onRemove = function() {
            google.maps.event.removeListener(this.divListener_);
            this.div_.parentNode.removeChild(this.div_);

            // clean up
            this.set('position');
            this.set('path');
            this.set('vertex');
        };

        DeleteMenu.prototype.close = function() {
            this.setMap(null);
        };

        DeleteMenu.prototype.draw = function() {
            var position = this.get('position');
            var projection = this.getProjection();

            if (!position || !projection) {
                return;
            }

            var point = projection.fromLatLngToDivPixel(position);
            this.div_.style.top = point.y + 'px';
            this.div_.style.left = point.x + 'px';
        };

        /**
         * Opens the menu at a vertex of a given path.
         */
        DeleteMenu.prototype.open = function(map, path, vertex) {
            this.set('position', path.getAt(vertex));
            this.set('path', path);
            this.set('vertex', vertex);
            this.setMap(map);
            this.draw();
        };

        /**
         * Deletes the vertex from the path.
         */
        DeleteMenu.prototype.removeVertex = function() {
            var path = this.get('path');
            var vertex = this.get('vertex');

            if (!path || vertex == undefined) {
                this.close();
                return;
            }

            path.removeAt(vertex);
            this.close();
        };

        function initMap() {

            // Define the LatLng coordinates for the polygon's  outer path.
            var coords = [
                {!! $fpol !!}
            ];

            var poligono = new google.maps.Polygon({
                paths: coords,
                strokeColor: '#6E6E6E',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#00FFFF',
                fillOpacity: 0.35,
                draggable: true,
                editable: true
            });

            var lt = poligono.my_getBounds().getCenter().lat();
            var lg = poligono.my_getBounds().getCenter().lng();

            var latlngbounds = new google.maps.LatLngBounds();
            for (var i = 0; i < coords.length; i++) {
                latlngbounds.extend(coords[i]);
            }

            var map = new google.maps.Map(document.getElementById('mapa'), {
                zoom: 5,
                mapTypeId: 'hybrid',
                center: {lat: lt, lng: lg},
                disableDoubleClickZoom: true
            });

            poligono.setMap(map);
            map.fitBounds(latlngbounds);

           /* google.maps.event.addListener(poligono, "dragend", function(){
                if(confirm('Desea guardar los cambios en el poligono?')){
                    var len = poligono.getPath().getLength();
                    var htmlStr = "";
                    for (var i=0; i<len; i++) {
                        var coord = poligono.getPath().getAt(i).toUrlValue(10).split(',');
                        htmlStr += coord[1]+","+coord[0]+" ";
                    }
                    setCoordenadas(htmlStr, '{{ $pol_id }}')
                }

            });*/

            google.maps.event.addListener(poligono, 'dblclick', function(event) {
                if(confirm('Desea guardar los cambios en el poligono?')){
                    var len = poligono.getPath().getLength();
                    var htmlStr = "";
                    for (var i=0; i<len; i++) {
                        var coord = poligono.getPath().getAt(i).toUrlValue(10).split(',');
                        htmlStr += coord[1]+","+coord[0]+" ";
                    }
                    setCoordenadas(htmlStr, '{{ $pol_id }}')
                }
            });

            var deleteMenu = new DeleteMenu();

            google.maps.event.addListener(poligono, 'rightclick', function(e) {
                // Check if click was on a vertex control point
                if (e.vertex == undefined) {
                    return;
                }
                deleteMenu.open(map, poligono.getPath(), e.vertex);
            });

        }

        function setCoordenadas(coord, pol_id){
            $.post( "{!! route('sistema.plantas.actCoordPol') !!}",
                {id: pol_id, coordenadas: coord, rnd: Math.random(), _token: '{{ csrf_token() }}' },
                function( data ) {
                    alert(data);
                });
        }




        $(function () {
            initMap();
        })

    </script>
@endsection