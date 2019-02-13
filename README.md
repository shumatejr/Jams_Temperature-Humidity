# Jams_Temperature-Humidity

Resources for Huzzah Arduino and the BME280 sensor
https://learn.adafruit.com/adafruit-feather-huzzah-esp8266/using-arduino-ide
https://learn.adafruit.com/adafruit-bme280-humidity-barometric-pressure-temperature-sensor-breakout/arduino-test

Visualization uses CanvasJS which can be utilized non-commercially for free
https://canvasjs.com/. Once downloaded, the CanvasJS files should be stored in a subfolder of the project called 'CanvasJS'.

Database Table Information:

Table Name: templog
Fields: logID (primary key), deviceID, temperature, humidity, logDate, logTime
Function: Stores the device read from the BME280 sensor with the deviceID, date, and time

Table Name: deviceparameters
Fields: deviceID (primary key), pollingRate, tempAlarmLowerThreshold, tempAlarmUpperThreshold, humidityAlarmLowerThreshold, humidityAlarmUpperThreshold
Function: Stores the parameters for the alarm state and polling rate of whatever sensor is being used

File Overview and Purpose

tempSensor.php: Handles retrieving sensor data from the Arduino and uploading it to the templog table to be stored.

parameterRead.php: Grabs the polling rate from the deviceparameters table and sends it to the Arduino.

tempDisplay.php: Queries the database and uses CanvasJS to display the data graphically for a particular input date.
