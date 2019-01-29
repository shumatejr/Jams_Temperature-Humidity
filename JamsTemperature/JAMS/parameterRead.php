<?
	//***Update this with your own appropriate information***
	mysql_connect("SERVER","USERNAME","PASSWORD");
	//*******************************************************
	
	$deviceID = $_GET['deviceID'];
	$timeDelay = -1;
	
	// Grab the device parameter
	$query = "SELECT * FROM deviceparameters WHERE deviceID = '$deviceID'"; 
	
	//***Update this with your own appropriate information***
	$result = mysql_db_query("DATABASE NAME", $query);
	//*******************************************************
	
	if($result){ 
		while ($row = mysql_fetch_array($result)) {
			$timeDelay= $row["pollingRate"];
		}
	}
	echo $timeDelay + '\r';

	mysql_close();
?>