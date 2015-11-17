#!/usr/bin/env python

import RPi.GPIO as GPIO
import time


GPIO.setmode(GPIO.BCM)
GPIO.setup(7, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)
GPIO.setup(8, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)

loopcontrol = 1

while loopcontrol == 1:
    try:
        print "GPIO 7 " + str(GPIO.input(7))
        print "GPIO 8 " + str(GPIO.input(8))
        time.sleep(.25)

    except KeyboardInterrupt:
        GPIO.cleanup()
