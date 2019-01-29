
<!DOCTYPE HTML>
<?
	// Default measurementDate to today's date to make page load quickly on the first load
	if (is_null ($measurementDate)){
		$measurementDate = date('Y-m-d');
	}
	
	//***Update this with your own appropriate information***
	mysql_connect("SERVER","USERNAME","PASSWORD");
	//*******************************************************
	
	//Query can be adjusted to take MAX or average along a series of dates
	$query = "SELECT logTime, logDate, temperature, humidity FROM templog WHERE logDate >= '$measurementDate';";
	//$query = "SELECT logDate, MAX(temperature) AS temperature, MAX(humidity) AS humidity FROM templog WHERE logDate >= '$measurementDate'AND logDate < '2019-01-22' GROUP BY logDate";

	//***Update this with your own appropriate information***
	$result = mysql_db_query("DATABASE NAME", $query);
	//*******************************************************
	$dataPointsTemperature = array();
	$dataPointsHumidity = array();

	if($result){ 
		while ($row = mysql_fetch_array($result)) {
			$temperature=floatval($row["temperature"]);
			$humidity=floatval($row["humidity"]);
			$logTime = $row["logTime"];
			$logDate = $row["logDate"];
			
			$chartLabel = $logTime;
			//$chartLabel = $logDate;
			
			$dataPointTemperature = array("label" => $chartLabel, "y" => $temperature);
			$dataPointHumidity = array("label" => $chartLabel, "y" => $humidity);
			array_push($dataPointsTemperature, $dataPointTemperature);
			array_push($dataPointsHumidity, $dataPointHumidity);
		}
	}
?>


	<title>JAMS :: Just Another Monitoring System :: Temperature</title>
<script src="CanvasJS/canvasjs.min.js"></script>
<script type="text/javascript">

window.onload = function(){
	var chart = new CanvasJS.Chart("chartContainer",{
		zoomEnabled:true,
		title:{
			text: "JAMS :: Temperature/Humidity Sensor 1 :: <?echo $measurementDate?>" 
			//text: "JAMS :: Dispenser 1"
		},
		axisY:{
			includeZero: false,
			title: "Temperature \u00B0 C"
		},
//		axisX:{
//			title: "Time",
//			stripLines: [{
//				value: "07:50:00",
//				label: "Incubator Opened",
//				labelFontColor: "#808080",
//				labelAlign: "near"
//			}]
//		},
		axisX:{
			title: "Date",
		},
		axisY2:{
			includeZero: false,
			labelFontColor: "#C24642",
			lineColor: "#C24642",
			title: "% Humidity"
		},	toolTip: {
		shared: true
	},
		data:[{
			// Change type to "doughnut", "line", "splineArea", etc.
			type: "line",
			name: "Temperature (C)",
			showInLegend: true,
			dataPoints:  <?php echo json_encode($dataPointsTemperature); ?>
		},
		{
			type: "line",
			axisYType: "secondary",
			name: "Relative Humidity (%)",
			showInLegend: true,
			lineThickness: 2,
			dataPoints:  <?php echo json_encode($dataPointsHumidity); ?>
		}]
	});
	chart.render();
}
</script>

<div id="chartContainer" style="height: 400px; width: 70%;"></div>

<form action="tempDisplay.php">
	Date:
	<input type="date" name="measurementDate">
	<input type="submit">
</form>

</BODY>
</HTML>
