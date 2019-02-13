# Jams_Temperature-Humidity

This project was developed to run on a computer running an Apache HTTP server with PHP and a MySQL server.  This code has been tested using Apache server version 2.2.15 with PHP version 5.2.13 and MySQL server 5.7.10.

Resources for Huzzah Arduino and the BME280 sensor
https://learn.adafruit.com/adafruit-feather-huzzah-esp8266/using-arduino-ide
https://learn.adafruit.com/adafruit-bme280-humidity-barometric-pressure-temperature-sensor-breakout/arduino-test

Visualization uses CanvasJS which can be utilized non-commercially for free
https://canvasjs.com/. Once downloaded, the CanvasJS files should be stored in a subfolder of the project called 'CanvasJS'.

File Overview and Purpose

tempSensor.php: Handles retrieving sensor data from the Arduino and uploading it to the templog table to be stored.

parameterRead.php: Grabs the polling rate from the deviceparameters table and sends it to the Arduino.

tempDisplay.php: Queries the database and uses CanvasJS to display the data graphically for a particular input date.

Additional information regarding project implementation and use can be seen by clicking on the poster from the SLAS 2019 conference below.

<A href="https://github.com/pierrebaillargeon/Jams_Temperature-Humidity/blob/master/JamsTemperature/Documentation/Shumate-SLAS_2019_poster.png"><img src="https://github.com/pierrebaillargeon/Jams_Temperature-Humidity/blob/master/JamsTemperature/Documentation/Shumate-SLAS_2019_poster.png?raw=true" width="500"></A>
