import network
import urequests
import utime
import machine

# Wi-Fi credentials
SSID = "((( Saturday )))"
PASSWORD = "0004edb6700b6"

# Database API endpoint (PHP or Node.js server)
API_URL = "/raspberry.php"

# Internal Temperature Sensor
sensor_temp = machine.ADC(4)
conversion_factor = 3.3 / 65535

led = machine.Pin(25, machine.Pin.OUT)

def get_temperature():
    reading = sensor_temp.read_u16() * conversion_factor
    temperature_celsius = 27 - (reading - 0.706) / 0.001721
    return round(temperature_celsius, 2)

# Connect to Wi-Fi
def connect_wifi():
    wlan = network.WLAN(network.STA_IF)
    wlan.active(True)
    wlan.connect(SSID, PASSWORD)

    timeout = 10  # Timeout in seconds
    while not wlan.isconnected() and timeout > 0:
        print(f"Connecting... ({10-timeout}/10)")
        led.value(1)  # Blink LED while connecting
        utime.sleep(0.5)
        led.value(0)
        utime.sleep(0.5)
        timeout -= 1

    if wlan.isconnected():
        print("Connected to Wi-Fi! IP:", wlan.ifconfig()[0])
        led.value(1)  # LED ON when connected
    else:
        print("Wi-Fi Connection Failed")
        led.value(0)  # LED OFF if failed

# Upload Data to Server
def upload_temperature():
    temp = get_temperature()
    print(f"Uploading Temperature: {temp}°C")

    try:
        data = {"temperature": temp}
        response = urequests.post(API_URL, json=data)
        print("Server Response:", response.text)
        response.close()
        # LED Blink Twice if Data Uploaded
        for _ in range(2):
            led.value(0)
            utime.sleep(0.3)
            led.value(1)
            utime.sleep(0.3)
    except Exception as e:
        print("Error uploading data:", e)
        led.value(0)  # LED OFF on failure

# Main Loop
connect_wifi()
while True:
    upload_temperature()
    utime.sleep(5)  # Wait for 5 minutes
