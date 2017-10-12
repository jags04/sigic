@extends('layouts.mapa')

@section('styles')
    <style>
        #legend{
            color: #FFF;
            background: rgba( 255, 255, 255 , 0.7);
            position: fixed;
            bottom: 20px;
            left: 20px;
            width:20%;
            padding: 20px;
        }
    </style>
@endsection

@section('content')
    <div id="map"></div>
@endsection

@section('scripts')
    <script src="http://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}" type="text/javascript"></script>
    <script src="{{ URL::to('assets/global/plugins/gmaps/gmaps.min.js') }}" type="text/javascript"></script>
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
                maxWidth: 600, minWidth:600,
                maxHeight: 500, minHeight:500,
                shadowStyle: 1, padding: 5, borderRadius: 4,
                arrowSize: 20, borderWidth: 2, borderColor: '#CCCCCC',
                disableAutoPan: true, hideCloseButton: false, arrowPosition: 50,arrowStyle: 0
            });
            //infowindow = new google.maps.InfoWindow({});


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
                   // markerclusterer.addMarker(marker);
                }
            });
            google.maps.event.addListener(myParser,'parsed', function() {
                /*var b = performance.now();
                document.getElementById('perf').innerHTML = 'load time ' + ((b - a)/1000).toFixed(2) + ' seconds';*/
                hideLoad();
            });

            myParser.parse(['{{ route('sistema.mapasKmlIndustria') }}?rif={!! $request->rif !!}', '{{ URL::to('/kml/ambitos.kml') }}']);


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