#!/usr/bin/env python

import RPi.GPIO as GPIO
import time
from twitter import *

t = Twitter(
            auth=OAuth("19962944-ISRCCMIMk7nzHpggCQEvb5pzvmNq4KDr2J06Gu78U", "gqWz4HtKiqgT03i5G24zohcfUN1ZcB5Vp8CtGcQ", "icv8gCcS8Sgfkxjgk90vQ", "v04R8LjNieSODfre5xdwNzWKOo8kxktDzDKyN7fnGaQ")
           )

LED_PIN = 17
INPUT_PIN = 18
first = 0

GPIO.setmode(GPIO.BCM)
GPIO.setup(LED_PIN, GPIO.OUT)
GPIO.setup(INPUT_PIN, GPIO.IN)

loopcontrol = 1

while loopcontrol == 1:
    try:
        GPIO.output (LED_PIN, GPIO.input(INPUT_PIN))
        #time.sleep(2)
        #GPIO.output (LED_PIN, False)
        #time.sleep(.1)
        if (GPIO.input(INPUT_PIN) and first==0):
            t.statuses.update(status="TESTING FOR @DeanMcClure Excellent")
            first = 1

    except KeyboardInterrupt:
        GPIO.cleanup()
