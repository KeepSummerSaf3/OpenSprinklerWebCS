<?php
    // Connect to MySQL
    include("../connector.php");

    // Prepare the SQL statement
    $SQL = "UPDATE droplet.schedule SET State = '".$_GET["sch_status"]."' WHERE Sch_ID = '".$_GET["sch_ID"]."'";     
	
	//echo "Sch ID: ".$sch_ID.'<br>';
	//echo "Status: ".$sch_status.'<br>';
	
    // Execute SQL statement
    $result = $mysqli->query($SQL);
	
	if(!$result){
		die('Could not transmit data: ' . mysql_error());	
	}

    // Go to the review_data.php (optional)
    header("Location: ardu_review_data.php");
?>