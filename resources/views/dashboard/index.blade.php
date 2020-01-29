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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        jQuery.getJSON('https://smartstaffgauge.com/api/map/ocrs', function (ocr) {
          console.log('ocr : ', ocr);

      Array.prototype.forEach.call(ocr, function(ocr) {
        var responseDate = moment(ocr.updated_at).format("YYYY, MM, DD");
        console.log('upd_at : ', ocr.updated_at);
        console.log('title : ', ocr.title);
        console.log('responseDate : ', responseDate);

        var data = new google.visualization.DataTable();
          data.addColumn('date', 'Date');
          data.addColumn('string', 'Level');
          data.addRows([
            [responseDate, ocr.title],
          ]);

        var options = {
          title: 'All Data',
          hAxis: {title: 'Date', format: 'M/d/yy'},
          vAxis: {title: 'Level'}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        });
      });
    }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 100%; height: 500px;"></div>
  </body>
  </body>
</html>