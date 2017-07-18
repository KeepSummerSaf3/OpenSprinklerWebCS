<?php
    // Connect to MySQL
    include("../connector.php");

    // Prepare the SQL statement
    $SQL = "INSERT INTO droplet.system_status (MC_Mem, MC_Load) VALUES ('".$_GET["mem_pct"]."', '".$_GET["proc_pct"]."')";     

    // Execute SQL statement
    $result = $mysqli->query($SQL);
	
	if(!$result){
		die('Could not transmit data: ' . mysql_error());
	}

    // Go to the review_data.php (optional)
    header("Location: ardu_review_data.php");
?>