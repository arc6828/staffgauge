@extends('layout.main')

@section('content')
    <script src="http://maps.google.com/maps/api/js?sensor=false"
            type="text/javascript"></script>
    <script type="text/javascript">
        //<![CDATA[

          var map;
    var markers = {!! json_encode($markers) !!}; //this should dump a javascript array object which does not need any extra interperting.
    var marks = []; //just incase you want to be able to manipulate this later

    function load() {

        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 14.133982043026919, lng: 100.61786002773624},
            zoom: 13
        });           

        for(var i = 0; i < markers.length; i++){
            marks[i] = addMarker(markers[i]);
        }
    }

    function addMarker(marker){
        var sadrzaj = marker.anazivMarker};
        var adresa = marker.adresa;
        var grad = marker.nazivGrada;
        var postanskibroj = marker.postanski_broj;
        var zupanija = marker.nazivZupanije;

        var html = "<b>" + sadrzaj + "</b> <br/>" + adresa +",<br/>"+postanskibroj+" "+grad+",<br/>"+zupanija;


        var markerLatlng = new google.maps.LatLng(parseFloat(marker.lat),parseFloat(marker.lng));


        var mark = new google.maps.Marker({
            map: map,
            position: markerLatlng,
            icon: marker.slika
        });

        var infoWindow = new google.maps.InfoWindow;
        google.maps.event.addListener(mark, 'click', function(){
            infoWindow.setContent(html);
            infoWindow.open(map, mark);
        });

        return mark;
    }

    function doNothing(){} //very appropriately named function. whats it for?

        //]]>
    </script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dobro došli!</div>

                <div class="panel-body">

                    <!-- Moj kod  -->

                    <div id="map"></div>




                    <!-- DO TU -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection