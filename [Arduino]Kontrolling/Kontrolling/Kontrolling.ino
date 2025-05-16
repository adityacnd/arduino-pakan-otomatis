#include <WiFi.h>
#include <HTTPClient.h>
#include <ESP32Servo.h>


Servo myservo;  // create servo object to control a servo

int StatusPakan;

// Network SSID
const char* ssid = "pandagenk";   //sesuaikan punya anda
const char* password = "66666666";   //sesuaikan punya anda

const char* host = "192.168.225.25";  //IP Komputer / server / sesuaikan punya anda

void setup() {
  Serial.begin(115200);
  myservo.attach(25);  // attaches the servo on GIO2 to the servo object

  WiFi.hostname("NodeMCU");
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
void feed() {
  for (int posisi = 0; posisi <= 180; posisi++) {
    myservo.write(posisi); // Buka servo
    delay(10);
  }
  for (int posisi = 180; posisi >= 0; posisi--) {
    myservo.write(posisi); // Tutup servo
    delay(10);
  }
}
void loop() {
  WiFiClient client;
  const int httpPort = 80;
  if (!client.connect(host, httpPort)) {
    Serial.println("connection failed");
    return;
  }
  //Serial.println("connected");

  String LinkServo;
  HTTPClient httpservo;


  LinkServo = "http://" + String(host) + "/kontrolling/bacaservo.php";
  httpservo.begin(LinkServo);     
  httpservo.GET();
  String statusservo = httpservo.getString(); 
  statusservo.trim();
      if (statusservo == "ON") {
        StatusPakan = 1;
      } else if (statusservo == "OFF") {
        StatusPakan = 0;
      } 
  Serial.println(statusservo);
  httpservo.end();

  //set posisi servo
  Serial.println("Status Pakan : " + String(StatusPakan));
  if (StatusPakan == 1) {
    feed();// Mengirim status ke server PHP
  }

  delay(2000);
}