<?
	//***Update this with your own appropriate information***
	mysql_connect("SERVER","USERNAME","PASSWORD");
	//*******************************************************
	
	//Control whether the alarm will send email alerts or not
	$alarmActive = false;
	
	$tempAlarmLowerThreshold;
	$tempAlarmUpperThreshold;
	$humidityAlarmLowerThreshold;
	$humidityAlarmUpperThreshold;
	
	//Pull values from the Arduino
	$temperature = $_GET['temperature'];
	$humidity = $_GET['humidity'];
	$deviceID = $_GET['deviceID'];
	
	//  data into the templog table
	$query = "insert into templog (`temperature`,`humidity`,`logDate`,`logTime`) values ('$temperature','$humidity',DATE(NOW()), TIME(NOW()));"; 
	
	//***Update this with your own appropriate information***
	$result = mysql_db_query("DATABASE NAME", $query);
	//*******************************************************
	
	//Get the lower/upper bounds of the temperature/humidity measurement that will lead to an alarm trigger
	$query = "select * from deviceparameters WHERE deviceID = '$deviceID'";
	
	//***Update this with your own appropriate information***
	$result = mysql_db_query("DATABASE NAME", $query);
	//*******************************************************
	
	if($result){
		$tempAlarmLowerThreshold = $row["tempAlarmLowerThreshold"];
		$tempAlarmUpperThreshold = $row["tempAlarmUpperThreshold"];
		$humidityAlarmLowerThreshold = $row["humidityAlarmLowerThreshold"];
		$humidityAlarmUpperThreshold = $row["humidityAlarmUpperThreshold"];
	}
	
	//If the alarm is active, and the parameters are out of the expected values, send an alert
	//This will send an alarm every time a measurement is taken, so if the polling rate is low (for example, 5 seconds) and one of the measurements is outside the parameter, you will get an email every 5 seconds
	//**Update this to include a minimum time interval between alarm triggers**
	if($alarmActive){
		if(($temperature < $tempAlarmLowerThreshold) || ($temperature  > $tempAlarmUpperThreshold) || ($humidity < $humidityAlarmLowerThreshold) || ($humidity > $humidityAlarmUpperThreshold)){
			sendAlert($tempAlarmLowerThreshold, $tempAlarmUpperThreshold, $humidityAlarmLowerThreshold, $humidityAlarmUpperThreshold, $temperature, $humidity);
		}
	}
	
	mysql_close();
	
	function sendAlert($tempAlarmLowerThreshold, $tempAlarmUpperThreshold, $humidityAlarmLowerThreshold, $humidityAlarmUpperThreshold, $temperature, $humidity){

		//***Update this with your own appropriate information***
		$to .= 'email@address, email@address';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'To: ';
		$headers .= $to;
		$headers .= "\r\n";
		$headers .= 'From: email@address' . "\r\n";	
		$message = 'Plate dispense outside of expected range.' . "\r\n";
		$message .= "Temperature:$messageWeight Temperature Lower Bound:$tempAlarmLowerThreshold Temperature Upper Bound: $tempAlarmUpperThreshold 
		Humidity:$humidity Humidity Lower Bound: $humidityAlarmLowerThreshold Humidity Upper Bound: $humidityAlarmUpperThreshold ";
		$subject = 'JAMS TEMPERATURE/HUMIDITY ALERT';
		//*******************************************************
		$sendMailResult = mail($to, $subject, $message, $headers);	
	
	}
?>
