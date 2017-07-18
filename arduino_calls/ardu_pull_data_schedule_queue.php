<?php
    // Connect to MySQL
    include("../connector.php");
	
    // Prepare the SQL statement - Select first row for reading
	$SQL = "SELECT * FROM droplet.schedule WHERE Timestamp ORDER BY Sch_ID ASC limit 1";    

    // Execute SQL statement
    $result = $mysqli->query($SQL);
	
	while( $row = mysqli_fetch_array($result) )
    {
		echo "I:".$row["Sch_ID"].'<br>';
		echo "Z:".$row["Zone_Num"].'<br>';
        	echo "T:".$row["DOW_Plus_UTC"].'<br>';
		echo "L:".$row["Duration"].'<br>';
		echo "D:".$row["Delay_Minutes"].'<br>';
		echo "C:".$row["Cancel_Req"].'<br>';
    }	
	
	if(!$result){
		die('Could not transmit data: ' . mysql_error());
	}

?>
