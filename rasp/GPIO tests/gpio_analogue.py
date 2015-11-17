#!/usr/bin/env python

import RPi.GPIO as GPIO
import time

# Tell the GPIO library to use
# Broadcom GPIO references
GPIO.setmode(GPIO.BCM)

LED_PIN = 17
ANALOG_PIN = 18
first = 0

GPIO.setmode(GPIO.BCM)
GPIO.setup(LED_PIN, GPIO.OUT)

# Define function to measure charge time
def RCtime (PiPin):
  measurement = 0.0
  # Discharge capacitor
  GPIO.setup(PiPin, GPIO.OUT)
  GPIO.output(PiPin, GPIO.LOW)
  time.sleep(0.25)

  GPIO.setup(PiPin, GPIO.IN)
  # Count loops until voltage across
  # capacitor reads high on GPIO
  while (GPIO.input(PiPin) == GPIO.LOW):
    measurement += .001
    time.sleep(0.001)

  return (measurement)

# Main program loop
while True:
  print str(RCtime(ANALOG_PIN)) + " seconds" # Measure timing using ANALOG_PIN