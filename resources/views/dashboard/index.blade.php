<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Using MySQL and PHP with Google Maps</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 50%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>

<html>
  <body>
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <div id="map"></div>

    <script>
      var customLabel = {
        คลองหนึ่ง: {
          label: 'A'
        },
        ประชาธิปัตย์: {
          label: 'B'
        }
      };

        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(14.133982043026919, 100.61786002773624),
          zoom: 12
        });
        var infoWindow = new google.maps.InfoWindow;

        /*
        let fetchapi = fetch('https://smartstaffgauge.com/api/map/staffgauges')
        .then((response) => response.json())
        .then((responseJSON)=> {
          console.log(responseJSON);
        });
        */

          // Change this depending on the name of your PHP or XML file
          jQuery.getJSON('https://smartstaffgauge.com/api/map/staffgauges', function(data) {
            console.log(data);
            // var xml = data.responseXML;
            // var markers = data.getElementsByTagName('marker');
            Array.prototype.forEach.call(data, function(data) {
              var id = data.id;
              var name = data.province;
              var address = data.addressgauge;
              var type = data.district;
              var point = new google.maps.LatLng(
                  parseFloat(data.latitudegauge),
                  parseFloat(data.longitudegauge));

              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('ab'));

              var text = document.createElement('text');
              text.textContent = address
              infowincontent.appendChild(text);
              var icon = customLabel[type] || {};
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                label: icon.label
              });
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            });
          });
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAG1_Wtq39qpBpTSaSne1jNv4GtMqIB920&callback=initMap">
    </script>

    <!--------------------google chart-------------------->
    <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
  google.charts.load('current', {'packages':['scatter']});
  google.charts.setOnLoadCallback(drawChart);
  var contador = 0;
  function fill(chart,options){
        var json_prepared = new Array();        
      jQuery.getJSON({
        url: 'https://smartstaffgauge.com/api/map/staffgauges',
        type: 'GET',
        async: false,
        dataType: 'json'
    })
    .done(function(res) {
        // console.log(res);
        console.log("success1");
        for (var i = res.length - 1; i >= 0; i--) {
            var ano = res[i][0];
            var mes = res[i][1];
            var dia = res[i][2];
            var hora = res[i][3];
            var fecha = new Date(ano,mes,dia);
            var elemento  = new Array(fecha,hora);
            json_prepared.push(elemento);
        }
    })
     .fail(function() {
        console.log("error1");
    })
    .always(function() {
        console.log("complete1");
    });
    var data = new google.visualization.DataTable();
    data.addColumn('date', 'Alertas');
    data.addColumn('number', 'Alertas');
    console.log(json_prepared);
         data.addRows(json_prepared);
        chart.draw(data, google.charts.Scatter.convertOptions(options));
        console.log('actualizado');
  }
  function drawChart () {
    contador++;
    jQuery.getJSON({
        url: 'https://smartstaffgauge.com/api/map/staffgauges',
        type: 'GET',
        dataType: 'json',
    })
    .done(function(res) {
        var json_prepared = new Array();        
        console.log("success2");
        for (var i = res.length - 1; i >= 0; i--) {
            var ano = res[i][0];
            var mes = res[i][1];
            var dia = res[i][2];
            var hora = res[i][3];
            var fecha = new Date(ano,mes,dia);
            var elemento  = new Array(fecha,hora);
            json_prepared.push(elemento);
        }
    var data = new google.visualization.DataTable();
    data.addColumn('date', 'Date');
    data.addColumn('number', 'Datas');
        console.log(json_prepared);
         data.addRows(json_prepared);
    var options = {
      width: 800,
      height: 650,
      chart: {
        title: 'Students\' Final Grades',
        subtitle: 'based on hours studied'
      },    
      hAxis: {
             title: "Date",
      },
      vAxis: {
        title: "Houar"         
      }
    };
    var chart = new google.charts.Scatter(document.getElementById('scatterchart_material'));
    google.visualization.events.addListener(chart, 'error', function (googleError) {
        console.log(googleError);
  google.visualization.errors.removeError(googleError.id);
  document.getElementById("error_msg").innerHTML = "Message removed = '" + googleError.message + "'";}); chart.draw(data, google.charts.Scatter.convertOptions(options));setInterval(function(){
        console.log(chart);
        fill(chart,options);
    },3000); })
    .fail(function() {
        console.log("error2");
    })
    .always(function() {
        console.log("complete2");
    });
  }
</script>
  </head>
  <body>
    <div id="chart_div" style="width: 100%; height: 500px;"></div>
  </body>
  </body>
</html>