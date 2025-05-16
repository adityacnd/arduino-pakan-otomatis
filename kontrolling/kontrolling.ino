#include <WiFi.h>
#include <HTTPClient.h>
#include <ESP32Servo.h>
#define BUZZER_PIN  14

Servo myservo;  // create servo object to control a servo

// Network SSID
const char* ssid = "Wifierror";   // sesuaikan dengan SSID jaringan Anda
const char* password = "adityacnd";   // sesuaikan dengan kata sandi jaringan Anda

const char* host = "172.20.10.4";  // IP Komputer / server Anda, sesuaikan dengan alamat IP Anda

void setup() {
  Serial.begin(115200);
  pinMode(BUZZER_PIN, OUTPUT);
  myservo.attach(25);

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

void playTone(byte pin, unsigned int frequency, unsigned long duration) {
  tone(pin, frequency, duration);
}

void loop() {
  HTTPClient http;
  const int httpPort = 80;

  if (!http.begin(host, httpPort, "/uaspirdas/bacaservo.php")) {
    Serial.println("connection failed");
    return;
  }

  int httpResponseCode = http.GET();
  if (httpResponseCode == HTTP_CODE_OK) {
    String statusservo = http.getString();
    Serial.println(statusservo);

    Serial.println("Status Pakan : " + statusservo);
    if (statusservo.equals("ON")) { // Perubahan di sini, menggunakan equals()
      feed(); // Menggerakkan servo
      playTone(BUZZER_PIN, 1976, 500);
      playTone(BUZZER_PIN, 1721, 500);
    }
  } else {
    Serial.print("Error code: ");
    Serial.println(httpResponseCode);
  }

  http.end();

  delay(2000);
}