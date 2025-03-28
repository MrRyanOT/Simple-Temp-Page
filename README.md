
This project utilizes a Raspberry Pi Pico, an external LED, and a temperature sensor to measure and log the internal temperature of the device at regular intervals. The Raspberry Pi Pico connects to a Wi-Fi network and uploads the temperature data to a server. An LED indicator blinks while connected to Wi-Fi and turns off when disconnected.

## Project Components
- **Raspberry Pi Pico**
- **External LED** (connected to GPIO pin 2)
- **Internal Temperature Sensor** (on GPIO 4)
- **Wi-Fi Network** (for internet connection)
- **PHP server endpoint** (to receive temperature data)

## Features
- Measures the internal temperature of the Raspberry Pi Pico using the onboard temperature sensor.
- Uploads the temperature data to a server every 5 minutes.
- Blinks the external LED while connected to Wi-Fi.
- Stops blinking when the Wi-Fi connection is lost.

## Requirements
- Raspberry Pi Pico
- External LED connected to GPIO pin 2
- Temperature sensor connected to GPIO pin 4
- Wi-Fi network credentials
- PHP server endpoint to receive data

## Installation
1. Connect the Raspberry Pi Pico to your computer.
2. Open Thonny or any other suitable Python IDE.
3. Upload the code to your Raspberry Pi Pico.
4. Modify the `SSID` and `PASSWORD` variables in the code to match your Wi-Fi credentials.
5. Set the correct server endpoint URL in the `API_URL` variable.
6. Run the code on the Raspberry Pi Pico.

## Image

![TempPage](https://github.com/user-attachments/assets/37a666c8-780c-4988-9490-afa5c0d5be0a)


### Wi-Fi Connection
The Raspberry Pi Pico connects to the Wi-Fi network using the credentials provided in the code. The onboard LED blinks while connecting, and remains on when connected successfully.

### Temperature Measurement
The internal temperature of the Raspberry Pi Pico is measured using the built-in temperature sensor. The temperature is read and uploaded to the server every 5 minutes.

### LED Blinking
An external LED is connected to GPIO pin 2. The LED blinks every 0.5 seconds while the Raspberry Pi Pico is connected to the Wi-Fi network. If the device loses its Wi-Fi connection, the LED turns off.

### Uploading Data
The temperature data is uploaded to a server via a POST request. The data is sent as JSON to the specified API endpoint.

## Troubleshooting
- If the Raspberry Pi Pico cannot connect to Wi-Fi, check your network credentials.
- Ensure that the server endpoint URL is correct.
- If the LED does not blink, check the GPIO pin connection and ensure the LED is working.

## License
This project is open-source and available under the MIT License.

"""
