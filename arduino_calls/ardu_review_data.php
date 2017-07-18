<?php 
    // Start MySQL Connection
    include('../connector.php'); 
?>

<html>
<head>
    <title>Arduino Data Log</title>
    <style type="text/css">
        .table_titles, .table_cells_odd, .table_cells_even {
                padding-right: 20px;
                padding-left: 20px;
                color: #000;
        }
        .table_titles {
            color: #FFF;
            background-color: #666;
        }
        .table_cells_odd {
            background-color: #CCC;
        }
        .table_cells_even {
            background-color: #FAFAFA;
        }
        table {
            border: 2px solid #333;
        }
        body { font-family: "Trebuchet MS", Arial; }
    </style>
</head>

    <body>
        <h1>Arduino Status Table</h1>
    <table border="0" cellspacing="0" cellpadding="4">
    <tr>
	    <td class="table_titles">Date and Time</td>
		<td class="table_titles">MC Mem Usage</td>
		<td class="table_titles">MC State</td>
    </tr>

<?php
    // Retrieve all records and display them
    $result = $mysqli->query("SELECT * FROM ardu_sys_stat ORDER BY Timestamp ASC limit 10");
	
	if(!$result){
		die('Could not retrieve data: ' . mysql_error());
	}
    // Used for row color toggle
    $oddrow = true;

    // process every record
    while( $row = mysqli_fetch_array($result) )
    {
        if ($oddrow) 
        { 
            $css_class=' class="table_cells_odd"'; 
        }
        else
        { 
            $css_class=' class="table_cells_even"'; 
        }

        $oddrow = !$oddrow;

        echo '<tr>';
        echo '   <td'.$css_class.'>'.$row["Timestamp"].'</td>';
        echo '   <td'.$css_class.'>'.$row["MC_Mem"].'</td>';
		echo '	 <td'.$css_class.'>'.$row["MC_State"].'</td>';
        echo '</tr>';
    }
?>
    </table>
	
			<h1>Arduino Schedule Table</h1>
    <table border="0" cellspacing="0" cellpadding="4">
    <tr>
		<td class="table_titles">Altered Timestamp</td>
		<td class="table_titles">Sch. ID</td>
	    <td class="table_titles">Zone</td>
		<td class="table_titles">Date & Time</td>
		<td class="table_titles">Status</td>
		<td class="table_titles">Duration</td>
		<td class="table_titles">Delay Minutes</td>
		<td class="table_titles">Cancel Request</td>
		<td class="table_titles">Cancel Confirm</td>
    </tr>
	
<?php
    // Retrieve all records and display them
    $result = $mysqli->query("SELECT * FROM schedule ORDER BY Sch_ID ASC limit 10");
	
	if(!$result){
		die('Could not retrieve data: ' . mysql_error());
	}
    // Used for row color toggle
    $oddrow = true;

    // process every record
    while( $row = mysqli_fetch_array($result) )
    {
        if ($oddrow) 
        { 
            $css_class=' class="table_cells_odd"'; 
        }
        else
        { 
            $css_class=' class="table_cells_even"'; 
        }

        $oddrow = !$oddrow;

        echo '<tr>';
		echo '   <td'.$css_class.'>'.$row["Timestamp"].'</td>';
		echo '	 <td'.$css_class.'>'.$row["Sch_ID"].'</td>';
        echo '   <td'.$css_class.'>'.$row["Zone_Num"].'</td>';
        echo '   <td'.$css_class.'>'.$row["DOW_Plus_UTC"].'</td>';
        echo '   <td'.$css_class.'>'.$row["State"].'</td>';
        echo '   <td'.$css_class.'>'.$row["Duration"].'</td>';
		echo '	 <td'.$css_class.'>'.$row["Delay_Minutes"].'</td>';
		echo '	 <td'.$css_class.'>'.$row["Cancel_Req"].'</td>';
		echo '	 <td'.$css_class.'>'.$row["Cancel_Confirm"].'</td>';
        echo '</tr>';
    }
?>
	</table>
	
				<h1>Arduino Analytics Table</h1>
    <table border="0" cellspacing="0" cellpadding="4">
    <tr>
	    <td class="table_titles">Zone</td>
		<td class="table_titles">Timestamp</td>
		<td class="table_titles">Status</td>
		<td class="table_titles">Relay</td>
		<td class="table_titles">Error Code</td>
		<td class="table_titles">Daily Total</td>
		<td class="table_titles">Weekly Total</td>
		<td class="table_titles">Monthly Total</td>
    </tr>
	
<?php
    // Retrieve all records and display them
    $result = $mysqli->query("SELECT * FROM zones ORDER BY Zone_Num ASC limit 10");
	
	if(!$result){
		die('Could not retrieve data: ' . mysql_error());
	}
    // Used for row color toggle
    $oddrow = true;

    // process every record
    while( $row = mysqli_fetch_array($result) )
    {
        if ($oddrow) 
        { 
            $css_class=' class="table_cells_odd"'; 
        }
        else
        { 
            $css_class=' class="table_cells_even"'; 
        }

        $oddrow = !$oddrow;

        echo '<tr>';
        echo '   <td'.$css_class.'>'.$row["Zone_Num"].'</td>';
        echo '   <td'.$css_class.'>'.$row["Recorded_Time"].'</td>';
        echo '   <td'.$css_class.'>'.$row["State"].'</td>';
        echo '   <td'.$css_class.'>'.$row["Relay_Num"].'</td>';
		echo '   <td'.$css_class.'>'.$row["Error_Code"].'</td>';
		echo '	 <td'.$css_class.'>'.$row["Daily_Total"].'</td>';
		echo '	 <td'.$css_class.'>'.$row["Weekly_Total"].'</td>';
		echo '	 <td'.$css_class.'>'.$row["Monthly_Total"].'</td>';
        echo '</tr>';
    }
?>
	</table>
    </body>
</html>