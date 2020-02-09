@extends('layout.main')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                    <html>
  <body>
  <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 50px;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 50px;
        margin: 0;
        padding: 0;
      }
    </style>
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <div id="map"></div>

    <script>
      var customLabel = {
        1: {
          label: '1'
        },
        2: {
          label: '2'
        },
        3: {
          label: '3'
        }
      };

      var labels = '1234567890';
      var labelIndex = 0;

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
              var type = data.id;
              var point = new google.maps.LatLng(
                  parseFloat(data.latitudegauge),
                  parseFloat(data.longitudegauge));

              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent = address
              infowincontent.appendChild(text);
              var icon = customLabel[type] || {};
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                label: labels[labelIndex++ % labels.length],
                data : data
              });
              marker.addListener('click', function() {
                console.log('click marker : ',marker);
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
                //CALL TO DRAW LINE CHARGE HERE
                if(chart){
                  //GET JSON ....
                  var newArray1 = [];
                  jQuery.getJSON('https://www.smartstaffgauge.com/api/map/ocrs', function (ocrid) {
                    let result = ocrid.filter(item => item.staffgaugeid == marker.data.id);
                    console.log('result',result);
                    Array.prototype.forEach.call(result, function(result) {
                      var responseDate = moment(result.created_at).format("YYYY/MM/DD HH:mm");
                      var numbers = parseFloat(result.title);
                      newArray1.push([new Date(responseDate), numbers]);
                    });
                  
                  let data = new google.visualization.DataTable();
                  data.addColumn('datetime', 'Date');
                  data.addColumn('number', 'Level');
                  data.addRows(newArray1);
                  console.log('newArray1',newArray1);

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
                  });
                }

                if(table){
                  //GET JSON ....
                  jQuery.getJSON('https://www.smartstaffgauge.com/api/map/ocrs', function (ocr) {
                    console.log('ocr : ', ocr);
                    let datatable = ocr.filter(item => item.staffgaugeid == marker.data.id);
                    console.log('datatable',datatable);
                    var tableArray = [];
                    Array.prototype.forEach.call(datatable, function(datatable) {
                      var responseDate = moment(datatable.created_at).format("YYYY/MM/DD HH:mm");
                      var numbers = parseFloat(datatable.title);
                      var stgid = parseFloat(datatable.id);
                      tableArray.push([stgid, numbers, new Date(responseDate)]);
                    });
                      let data = new google.visualization.DataTable();
                      data.addColumn('number', 'OCR Id');
                      data.addColumn('number', 'Level');
                      data.addColumn('datetime', 'Date - Time');
                      data.addRows(tableArray);

                      table = new google.visualization.Table(document.getElementById('table_div'));

                      table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
                  });
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
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart','table']});
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawTable);
      
      var chart;
      var table;
      function drawChart() {
        jQuery.getJSON('https://www.smartstaffgauge.com/api/map/ocrs', function (ocr) {
          console.log('ocr : ', ocr);
          let default1 = ocr.filter(item => item.staffgaugeid === "1");
          console.log('default1',default1);
          var newArray = [];
          Array.prototype.forEach.call(default1, function(default1) {
            var responseDate = moment(default1.created_at).format("YYYY/MM/DD HH:mm");
            var numbers = parseFloat(default1.title);
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

      function drawTable() {
        jQuery.getJSON('https://www.smartstaffgauge.com/api/map/ocrs', function (ocr) {
          console.log('ocr : ', ocr);
          let datatable = ocr.filter(item => item.staffgaugeid === "1");
          console.log('datatable',datatable);
          var tableArray = [];
          Array.prototype.forEach.call(datatable, function(datatable) {
            var responseDate = moment(datatable.created_at).format("YYYY/MM/DD HH:mm");
            var numbers = parseFloat(datatable.title);
            var stgid = parseFloat(datatable.id);
            // var datetimes = new google.visualization.DateFormat({pattern: 'dd/MM/yyyy HH:mm'});
            // datetimes.format(ocr.updated_at, 0);
            /*
            console.log('upd_at : ', ocr.updated_at);
            console.log('title : ', ocr.title);
            console.log('responseDate : ', responseDate);
            console.log('numbers : ', numbers);
            */
            // console.log('datetimes : ', datetimes);
            tableArray.push([stgid, numbers, new Date(responseDate)]);
          });
            var data = new google.visualization.DataTable();
            data.addColumn('number', 'OCR Id');
            data.addColumn('number', 'Level');
            data.addColumn('datetime', 'Date - Time');
            data.addRows(tableArray);

            table = new google.visualization.Table(document.getElementById('table_div'));

            table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
        });
      }
    </script>
  </head>
  <body>
    <div id="log_div" style="width: 100%; height: 500px;"></div>
    <div id="table_div"></div>
  </body>
  </body>
  </html>
  </div>

</div>
</div>



</div>
</div>
</div>
@endsection