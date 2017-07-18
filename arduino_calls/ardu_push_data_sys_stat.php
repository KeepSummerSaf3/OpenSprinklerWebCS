<?php
    // Connect to MySQL
    include("../connector.php");

    // Prepare the SQL statement
    $SQL = "INSERT INTO droplet.ardu_sys_stat (MC_Mem, MC_State, Error) VALUE ('".$_GET["mem_pct"]."', '".$_GET["mc_state"]."', '".$_GET["error_msg"]."')";     

    // Execute SQL statement
    $result = $mysqli->query($SQL);

	// Pop off the first row
	$SQL = "DELETE FROM droplet.ardu_sys_stat ORDER BY Timestamp ASC limit 1";
	
	$result = $mysqli->query($SQL);
	
	if(!$result){
		die('Could not transmit data: ' . mysql_error());	
	}

    // Go to the review_data.php (optional)
    header("Location: ardu_review_data.php");
?>