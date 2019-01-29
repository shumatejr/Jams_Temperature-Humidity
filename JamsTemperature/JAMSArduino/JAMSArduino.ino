/***************************************************************************
  This is a library for the BME280 humidity, temperature & pressure sensor

  Designed specifically to work with the Adafruit BME280 Breakout
  ----> http://www.adafruit.com/products/2650

  These sensors use I2C or SPI to communicate, 2 or 4 pins are required
  to interface. The device's I2C address is either 0x76 or 0x77.

  Adafruit invests time and resources providing this open source code,
  please support Adafruit andopen-source hardware by purchasing products
  from Adafruit!

  Written by Limor Fried & Kevin Townsend for Adafruit Industries.
  BSD license, all text above must be included in any redistribution
 ***************************************************************************/

#include <Wire.h>
#include <SPI.h>
#include <Adafruit_Sensor.h>
#include <Adafruit_BME280.h>
#include <ESP8266WiFi.h>

//Pins used to connect BME sensor to Arduino
#define BME_SCK 12
#define BME_MISO 14
#define BME_MOSI 13
#define BME_CS 15

#define SEALEVELPRESSURE_HPA (1013.25)

//Adafruit_BME280 bme; // I2C
//Adafruit_BME280 bme(BME_CS); // hardware SPI
Adafruit_BME280 bme(BME_CS, BME_MOSI, BME_MISO, BME_SCK); // software SPI

//Time between measurements taken
unsigned long delayTime;

//Network information and password
const char* ssid     = "YOUR_SSID";
const char* password = "YOUR_PASSWORD";
IPAddress server(1,1,1,1);  // IP FOR YOUR SERVER

//If using multiple probes, change this value to a different number to differentiate probes
int deviceID = 1;

// Parameter for adjusting temperature if temperature is consistently off by a certain amount
double temperatureCalibration = -1.00;

//Start sampling and connect to wifi
void setup() {
    Serial.begin(115200);
    Serial.println(F("BME280 test"));

    bme.setSampling(Adafruit_BME280::MODE_FORCED, 
                    Adafruit_BME280::SAMPLING_X1, // temperature 
                    Adafruit_BME280::SAMPLING_X1, // pressure 
                    Adafruit_BME280::SAMPLING_X1, // humidity 
                    Adafruit_BME280::FILTER_OFF   ); 

    bool status;
    delay(5000);
    
    // default settings
    // (you can also pass in a Wire library object like &Wire2)
    status = bme.begin();  
    if (!status) {
        Serial.println("Could not find a valid BME280 sensor, check wiring!");
    }
    
    Serial.println("-- Default Test --");
    delayTime = 1000;

    Serial.println();
    Serial.print("Connecting to ");
    Serial.println(ssid);
      
    WiFi.begin(ssid, password);
      
    while (WiFi.status() != WL_CONNECTED) {
      delay(500);
      Serial.print(".");
    }
     
    Serial.println("");
    Serial.println("WiFi connected");  
    Serial.println("IP address: ");
    Serial.println(WiFi.localIP());
}


void loop() { 

    //Default delay parameter on startup
    WiFiClient client;
    String submitQuery;
    long delayParameter = 2000;
    
    //Read the delay parameter from the database
    if (client.connect(server, 80)) {

        //Update with your own appropriate device folder
        submitQuery = "GET /JAMS/parameterRead.php?deviceID=" + String(deviceID);
        //Serial.println(submitQuery);
        client.println(submitQuery);
        delay(10);

        //Update the delay parameter if a valid value is taken from the database. The parameterRead.php script returns -1 if the query fails
        long tempDelay = client.readStringUntil('\r').toInt();
        if(tempDelay > 0){
          delayParameter = tempDelay;
        }
        //Serial.println(delayParameter);
    }
     else{
      Serial.println("connection failed");
      return;
    }
    client.stop();

    //Insert data into the database
    if (client.connect(server, 80)) {
        //Temperature readings typically high on this particular sensor, adjust depending on a reference temperature
        double temperatureValue = bme.readTemperature() + temperatureCalibration;
        double humidityValue = bme.readHumidity();

         //Update with your own appropriate device folder
        submitQuery = "GET /JAMS/tempSensor.php?temperature=" + String(temperatureValue) + "&humidity=" + String(humidityValue) + "&deviceID=" + String(deviceID);
        client.println(submitQuery);
        //Serial.println(submitQuery);

    }
     else{
      Serial.println("connection failed");
      return;
    }
    printValues();
    client.stop();

    //Retrieving and updating database takes around 5 seconds, so subtract 5000 ms from the input desired delay parameter. If delay parameter is shorter than 5000ms, then use no delay
    delayTime = max(delayParameter - 5000, 0L);
    Serial.println(delayTime);
    delay(delayTime);
}


void printValues() {
    Serial.print("Temperature = ");
    Serial.print(bme.readTemperature());
    Serial.println(" *C");

    Serial.print("Pressure = ");

    Serial.print(bme.readPressure() / 100.0F);
    Serial.println(" hPa");

    Serial.print("Approx. Altitude = ");
    Serial.print(bme.readAltitude(SEALEVELPRESSURE_HPA));
    Serial.println(" m");

    Serial.print("Humidity = ");
    Serial.print(bme.readHumidity());
    Serial.println(" %");

    Serial.println();
}
