#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <Wire.h>   // for i2c devices
#include <LiquidCrystal_I2C.h> // for lcd display
#include "DHT.h"
LiquidCrystal_I2C lcd(0x27,20,4); 

const char *ssid = "wifi_name";  //ENTER YOUR WIFI ssid
const char *password = "1245678";  //ENTER YOUR WIFI password
const char* serverName = "http://192.168.0.37/aquarium/data.php"; //server address

// Set web server port number to 80
WiFiServer server(80);
bool debug= true;
 

// Variable to store the HTTP request
String header;

// These variables store pump_stat
bool manual_control=false;

// Current time
unsigned long currentTime = millis();
// Previous time
unsigned long previousTime = 0; 
// Define timeout time in milliseconds (example: 2000ms = 2s)
const long timeoutTime = 2000;

int period = 4000;
unsigned long time_now = 0;


#define moist_sen_pin A0
#define DHTPIN D3 
#define pump_pin D4 
#define DHTTYPE DHT22  
DHT dht(DHTPIN, DHTTYPE);
float moisture_limit=10;
String motor_stat="OFF";
int temp_up_limit=30;
int temp_low_limit=10;
int hum_up_limit=90;
int hum_low_limit=50;
int moisture_up_limit=60;
int moisture_low_limit=30;

float tempC,tempF,humi,moist;

void setup() {
  Serial.begin(9600);// baud rate or bit rate
  Serial.println(F("Smart Irrigation System"));
  pinMode(moist_sen_pin,INPUT);
  pinMode(pump_pin, OUTPUT);
  digitalWrite(pump_pin, HIGH); // turn off pump initially
  lcd.begin();                  // initialize the lcd 
  lcd.backlight();
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("SYSTEM ");
  lcd.setCursor(0,1);
  lcd.print("INITIALIZING...");
  delay(2000);
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Connecting to");
  lcd.setCursor(0,1);
  lcd.print("WIFI Network..");
  delay(1000);
  connectWifi();
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Connected to");
  lcd.setCursor(0,1);
  lcd.print(ssid);
  delay(1000);
  dht.begin();
  server.begin();
}

void loop() {
  read_dht();
  moist=read_soil_moisture();
  print_data();
  display_info(tempC,humi, read_soil_moisture(), motor_stat);
  read_input();

if (manual_control==false)
{
  
  if((tempC<temp_up_limit && tempC>temp_low_limit)&& (humi<hum_up_limit && humi>hum_low_limit))
  {
    if(moist<moisture_low_limit)
    {
      digitalWrite(pump_pin, LOW);
      motor_stat="ON";
      delay(100);
    }
       else if (moist>moisture_up_limit)
    {
      digitalWrite(pump_pin, HIGH);
      motor_stat="OFF";
      delay(100);
    }
  }
  else
  {
      digitalWrite(pump_pin, HIGH);
      delay(100);
  }
}
    if(millis() >= time_now + period){
        time_now += period;
        send_data();
    }
}

void print_data()
{
  Serial.print(F("Humidity: "));
  Serial.print(humi);
  Serial.print(F("%  Temperature: "));
  Serial.print(tempC);
  Serial.print(F("°C "));
  Serial.print(F("Moisture Level:"));
  Serial.print(moist);
  Serial.print(F("%  "));
  Serial.print("Motor Status: ");
  Serial.println(motor_stat);
}

void display_info(float t1,float h1, float moi, String ms)
{
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Temperature:");
  lcd.print(t1);
  lcd.print((char)223);
  lcd.print("C");
  lcd.setCursor(0,1);
  lcd.print("Humidity:");
  lcd.print(h1);
  lcd.print("%");
  lcd.setCursor(0,2);
  lcd.print("Moister Level:");
  lcd.print(moi);
  lcd.print("%");
  lcd.setCursor(0,3);
  lcd.print("Motor Status:");
  lcd.print(ms);
  delay(1000);
}

void read_dht()
{
  humi = dht.readHumidity();
  // Read temperature as Celsius (the default)
  tempC = dht.readTemperature();
  tempF =dht.readTemperature(true);
  if (isnan(humi) || isnan(tempC)|| isnan(tempF)) {
    Serial.println(F("Failed to read from DHT sensor!"));
    humi=0;
    tempC=0;
    return;
  }
  
}

int read_soil_moisture()
{
  int soil_moisture_raw = analogRead(moist_sen_pin);
  int soil_moist_percentage = map(soil_moisture_raw, 1023, 0, 0, 100);
  return soil_moist_percentage; 
}


//function to connect to wifi
void connectWifi(){
  delay(1000);
  WiFi.mode(WIFI_OFF);        //Prevents reconnection issue (taking too long to connect)
  delay(1000);
  WiFi.mode(WIFI_STA);        //This line hides the viewing of ESP as wifi hotspot
  WiFi.begin(ssid, password);     //Connect to your WiFi router
  Serial.println("");
  Serial.print("Connecting");
  // Wait for connection
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  //If connection successful show IP address in serial monitor 
  Serial.print("Connected to ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());  //IP address assigned to your ESP
}

void send_data()
{
String manual="OFF";
 if (manual_control==false)
 {
  manual="OFF";
 }
 else
 {
  manual="ON";
 }
    if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client1;
    HTTPClient http;
    http.begin(client1,serverName);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    // Prepare your HTTP POST request data
    String httpRequestData;
    httpRequestData +="&temp=";
    httpRequestData += String(tempC);
    httpRequestData +="&humid=";
    httpRequestData += String(humi);
    httpRequestData +="&moist=";
    httpRequestData += String(moist);
    httpRequestData +="&manual=";
    httpRequestData +=manual;
    httpRequestData +="&pump_stat=";
    httpRequestData += motor_stat;
    if(debug) Serial.print("httpRequestData: ");
    if(debug) Serial.println(httpRequestData);
    // Send HTTP POST request
    int httpResponseCode = http.POST(httpRequestData);

    if (httpResponseCode > 0) {
      if(debug) Serial.print("HTTP Response code: ");
      if(debug) Serial.println(httpResponseCode);
    }
    else {
      if(debug) Serial.print("Error code: ");
      if(debug) Serial.println(httpResponseCode);
    }
    // Free resources
    http.end();
  }
}


void read_input()
{
  WiFiClient client = server.available();
if (client) {
  // Wait until the client sends some data
  Serial.println("new client");
  while (!client.available()) {
    delay(1);
  }

  // Read the first line of the request
  String req = client.readStringUntil('\r');
   Serial.println(req);
  String command1 = req.substring(10,12);
  Serial.println(command1);
  client.flush();
  if (command1=="CM")
  {
    manual_control=false;
  }
  else if (command1=="OM")
  {
    manual_control=true;
  }
    else if (command1=="CP")
  {
    motor_stat = "OFF";
    digitalWrite(pump_pin, HIGH);
    delay(10);
  }
      else if (command1=="OP")
  {
    motor_stat = "ON";
    digitalWrite(pump_pin, LOW);
    delay(10);
  }
}
}
