<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

/*
Script  : PHP-JSON-MySQLi-GoogleChart
Author  : Enam Hossain
version : 1.0

*/

/*
--------------------------------------------------------------------
Usage:
--------------------------------------------------------------------

Requirements: PHP, Apache and MySQL

*/

  include("../connector.php");

  if ($mysqli->connect_error) {
    die("Connection to database failed: " . $mysqli->connect_error);
  }
  else
  {
    //echo ("Connection Successfull");
  }

  $data[] = array('date_time','zone1','zone2','zone3','zone4','zone5','zone6','zone7','zone8');
  $query = 'SELECT * FROM zones_daily_stats';
  $result = $mysqli->query($query);
  
  while($row = mysqli_fetch_assoc($result)){
	$dow = date('D', strtotime($row['time']));
	$day = date('d', strtotime($row['time']));
	$mon = date('m', strtotime($row['time']));
	$date_ = $dow . ' ' . strval($mon) . '/' . strval($day);
	$data[] = array($date_,(int)$row['zone1'],(int)$row['zone2'],(int)$row['zone3'],(int)$row['zone4'],(int)$row['zone5'],(int)$row['zone6'],(int)$row['zone7'],(int)$row['zone8']);
  }
  //echo json_encode($data);
  $json_data = json_encode($data);

?>

<html>
  <head>
    <!--Load the Ajax API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    function drawChart() {

      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable();
      var data = google.visualization.arrayToDataTable(<?=$json_data?>);
      var options = {
          title: 'Irrigation Weekly Water Consumption',
	  bar: {groupWidth: "95%"},
	  legend: {position: "top", maxLines: 2},
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }

    </script>
    <style>
	#chart_div {
    		width: 100%;
    		height: 100%;
	}	
    </style>
  </head>

  <body>
       	<div id="chart_div"></div>
  </body>
</html>