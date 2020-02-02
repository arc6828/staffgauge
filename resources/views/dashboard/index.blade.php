<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Dashboard</title>
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
          jQuery.getJSON('https://www.smartstaffgauge.com/api/map/staffgauges', function(data) {
            //console.log(data);
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
                label: icon.label,
                data : data
              });
              marker.addListener('click', function() {
                console.log('click marker : ',marker);
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
                //CALL TO DRAW LINE CHARGE HERE
                if(chart){
                  //GET JSON ....
                  jQuery.getJSON('https://www.smartstaffgauge.com/api/map/ocrs', function (ocrid) {
                    console.log('ocrid',ocrid.id)
                  });
                  let newArray = [
                    [new Date(2019,12,01), 100],
                    [new Date(2020,12,01), 200],
                    [new Date(2021,12,01), 300]
                  ];
                  /*
                  Array.prototype.forEach.call(ocr, function(ocr) {
                    var responseDate = moment(ocr.created_at).format("YYYY/MM/DD HH:mm");
                    var numbers = parseFloat(ocr.title);
                    newArray.push([new Date(responseDate), numbers]);
                  });
                  */
                  let data = new google.visualization.DataTable();
                  data.addColumn('datetime', 'Date');
                  data.addColumn('number', 'Level');
                  data.addRows(newArray);

                  let logOptions = {
                    title: 'Staffgauge',
                    legend: 'none',
                    hAxis: {
                      title: 'Date',
                      format: 'YYYY/MM/dd'
                    },
                    vAxis: {
                      title: 'Level'
                    }
                  };

                  chart = new google.visualization.LineChart(document.getElementById('log_div'));
                  chart.draw(data, logOptions);
                }
                
              });
            });
          });
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
      var chart;
      function drawChart() {
        jQuery.getJSON('https://www.smartstaffgauge.com/api/map/ocrs', function (ocr) {
          console.log('ocr : ', ocr);

          var newArray = [];
          Array.prototype.forEach.call(ocr, function(ocr) {
            var responseDate = moment(ocr.created_at).format("YYYY/MM/DD HH:mm");
            var numbers = parseFloat(ocr.title);
            // var datetimes = new google.visualization.DateFormat({pattern: 'dd/MM/yyyy HH:mm'});
            // datetimes.format(ocr.updated_at, 0);
            /*
            console.log('upd_at : ', ocr.updated_at);
            console.log('title : ', ocr.title);
            console.log('responseDate : ', responseDate);
            console.log('numbers : ', numbers);
            */
            // console.log('datetimes : ', datetimes);
            newArray.push([new Date(responseDate), numbers]);
          });
          var data = new google.visualization.DataTable();
          data.addColumn('datetime', 'Date');
          data.addColumn('number', 'Level');
          data.addRows(newArray);

          var logOptions = {
            title: 'Staffgauge',
            legend: 'none',
            hAxis: {
              title: 'Date',
              format: 'YYYY/MM/dd'
            },
            vAxis: {
              title: 'Level'
            }
          };

          chart = new google.visualization.LineChart(document.getElementById('log_div'));
          chart.draw(data, logOptions);
        });
      }
    </script>
  </head>
  <body>
    <div id="log_div" style="width: 100%; height: 500px;"></div>
  </body>
  </body>
</html>