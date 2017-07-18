<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbuserpass = 'am2814698350';
$database = 'droplet';

$mysqli = new mysqli($dbhost, $dbuser, $dbuserpass, $database);
	
if($mysqli->connect_errno){
		die('Could not connect to mysql: '. $mysqli->connect_error);
}

?>