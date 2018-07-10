#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <OneWire.h>
#include <DallasTemperature.h>

// --- Mapeamento de Hardware ---
#define    ONE_WIRE_BUS 12         //sinal do sensor DS18B20

// --- Declaração de Objetos ---
OneWire oneWire(ONE_WIRE_BUS);        //objeto one_wire
DallasTemperature sensors(&oneWire);
DeviceAddress sensor1;

const char* ssid     = "Kamuy";
const char* password = "cgla48123456789";
const char* host = "automapteste.000webhostapp.com";


void setup() {
  Serial.begin(115200);
  delay(100);
  sensors.begin();
  // Localiza e mostra enderecos dos sensores
  Serial.println("Localizando sensores DS18B20...");
  Serial.print("Foram encontrados ");
  Serial.print(sensors.getDeviceCount(), DEC);
  Serial.println(" sensores.");

  if (!sensors.getAddress(sensor1, 0))
     Serial.println("Sensores nao encontrados !");

  Serial.println();
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
  Serial.print("Netmask: ");
  Serial.println(WiFi.subnetMask());
  Serial.print("Gateway: ");
  Serial.println(WiFi.gatewayIP());
}

void loop() {


  // Le a informacao do sensor
  sensors.requestTemperatures();

  float t = sensors.getTempC(sensor1);
  float h = sensors.getTempC(sensor1);

  Serial.print("connecting to ");
  Serial.println(host);

  WiFiClient client;
  const int httpPort = 80;
  if (!client.connect(host, httpPort)) {
    Serial.println("connection failed");
    return;
  }

  String url = "/api/weather/insert.php?temp=" + String(t) + "&hum="+ String(h);
  Serial.print("Requesting URL: ");
  Serial.println(url);

  client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" +
               "Connection: close\r\n\r\n");
  delay(500);

  while(client.available()){
    String line = client.readStringUntil('\r');
    Serial.print(line);
  }

  Serial.println();
  Serial.println("closing connection");
  delay(3000);
}
