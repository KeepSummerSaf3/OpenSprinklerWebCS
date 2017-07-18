<html>
<head>
<title> PHP Test Script </title>
</head>
<body>

<?php 
							  include 'connector.php';
								$result = $mysqli->query('SELECT Daily_total FROM zones WHERE Zone_num = 1');
								if(!$result){
									die('Could not retrieve data: ' . mysql_error());
								}	
								else{
									$row = mysqli_fetch_array($result);
									$data = new stdClass();
									$data->value = $row['Daily_total'];
									$data->color = "#68dff0";
									$json_data = json_encode($data);
									echo $json_data;
								}
								$mysqli->close();
							  ?>
							  <br>
							  <?php 
							  include 'connector.php';
								$result = $mysqli->query('SELECT Daily_total FROM zones WHERE zone_num = 1');
								if(!$result){
									die('Could not retrieve data: ' . mysql_error());
								}	
								else{
									$row = mysqli_fetch_array($result);
									echo $row['Daily_total'];
								}
								$mysqli->close();
							  ?>

</body>
</html>