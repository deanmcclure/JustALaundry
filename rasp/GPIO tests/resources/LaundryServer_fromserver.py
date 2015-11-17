#!/usr/bin/env python

import RPi.GPIO as GPIO
import time
from twitter import *
import MySQLdb
import json
import datetime
import os,time
import threading

#set local time (using time to make distinct tweets
os.environ['TZ'] = 'Australia/Brisbane'
time.tzset()


#LaundryAlert Twitter Application
#https://dev.twitter.com/apps/4988061/show
#Application Keys
CONSUMER_KEY = "bBDSN6BprAUvFfcYjXRMhQ"
CONSUMER_SECRET = "BW4KpeZAqzsaHAIthy0a8XaIfpvWeGBFII3JZ0C4"
#@JustALaundry Token for Application
OAUTH_TOKEN = "1698407184-KSnxD2BkKRtnrMhq5VgUKGcqheSbnITYYsob2Q9"
OAUTH_SECRET = "jjCswflF1Et88xbMBz0H3CxbXSFVOAlpEUcXSzft0"

twit = Twitter(
            auth=OAuth(OAUTH_TOKEN, OAUTH_SECRET,
                       CONSUMER_KEY, CONSUMER_SECRET)
           )

#Local MYSQL Database
MYSQLUser = "laundry"
MYSQLPass = "happy"

#Configure GPIO
GPIO.setmode(GPIO.BCM)

#Connect to DB
db = MySQLdb.connect(host="localhost",
                     user=MYSQLUser,
                      passwd=MYSQLPass,
                      db="laundry")
                      

######################################
#Go through GPIO and configure all as Inputs with Pull Downs (all will be active highs)
try:
    cur = db.cursor() 
    cur.execute("SELECT GPIO FROM GPIO")
    for gpioPin in cur.fetchall():
        GPIO.setup(gpioPin[0], GPIO.IN, pull_up_down=GPIO.PUD_DOWN)
    cur.close()
except MySQLdb.Error, e:
   print "Database update failed"

######################################
    #Go through and map all GPIO states into GPIO table 
def GPIOtoDB(filterScans):
    global GPIOScan 
    global filter 
    cur = db.cursor() 
    curwrite = db.cursor() 
    cur.execute("SELECT GPIO FROM GPIO") 
    i = 0
    GPIOScan += 1
    try:
        for gpioPin in cur.fetchall():
            i+= 1
            if GPIO.input(gpioPin[0]): filter[i] += 1
            if not (GPIO.input(gpioPin[0])): filter[i] -= 1
            if  GPIOScan == filterScans:
                print "updating IO"
                print gpioPin[0]
                print filter[i]
                if filter[i] > (filterScans/2):
                    curwrite.execute ("UPDATE GPIO SET STATE=1 WHERE GPIO='%s' " % (str(gpioPin[0])))
                elif filter[i] < (-filterScans/2):
                    curwrite.execute ("UPDATE GPIO SET STATE=0 WHERE GPIO='%s' " % (str(gpioPin[0])))
                filter[i] = 0
    except:
        print "some IO error, keep on trucking, probably fucking around in SQL"
    if  GPIOScan == filterScans:
        GPIOScan = 0
    db.commit()
    cur.close()
    curwrite.close()
    


filter = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
GPIOScan = 0


loopcontrol = 1
while loopcontrol == 1:
    try:
        GPIOtoDB(5)
        ############## maps all gpio states out of SQL for use
        try:
            gpiostate = {}
            cur = db.cursor() 
            cur.execute("SELECT * FROM GPIO")
            gpiotable = cur.fetchall()
            for gpiorows in gpiotable:
                gpiostate.update({gpiorows[0]: gpiorows[2]})
            cur.close()
        except MySQLdb.Error, e:
            print "Database DIP Message Read failed"
        
        
        ######################################
        #Go through all WEB messages and check, tweet and remove any relevant messages
        try:
            cur = db.cursor() 
            curwrite = db.cursor() 
            cur.execute("SELECT * FROM WebMessages")
            rows = cur.fetchall()
            for WEBMSG in rows:
                machinePin = WEBMSG[1]
                msgstate = WEBMSG[2]
                active = WEBMSG[4]
                MachineState = gpiostate[machinePin]
                #if the required bit is in the required state
                if MachineState == msgstate:
                #and it is already active and the condition is good send a tweet
                    if active:
                        try:
                            print "sending tweet"
                            tweet = WEBMSG[3] + " " + str(time.strftime('%X'))
                            print tweet
                            twit.statuses.update(status=tweet)
                        except MySQLdb.Error:
                            print "twitter error"
                        #Delete message after sent
                        curwrite.execute ("DELETE FROM WebMessages WHERE ID='%s' " % (WEBMSG[0]))
                #if it isn't in the required state then make it active
                else:
                    curwrite.execute ("UPDATE WebMessages SET ACTIVE='1' WHERE ID='%s' " % (WEBMSG[0]))
            cur.close()
            curwrite.close()
        except MySQLdb.Error, e:
           print "Database WEB Message Read failed"
        #######################################

        ######################################
        #Go through all DIP messages and check 
        try:
            cur = db.cursor() 
            curwrite = db.cursor() 
            cur.execute("SELECT * FROM DIPMessages")
            rows = cur.fetchall()
            for DIPMSG in rows:
                dipPin = DIPMSG[0]
                machinePin = DIPMSG[1]
                msgstate = DIPMSG[2]
                active = DIPMSG[4]
                #DipGPIO = DIPSwitch[DIPMSG[0]]
                DIPState = gpiostate[dipPin]
                #Is the DIP Switch ON?
                if DIPState:
                    #if the required bit is in the required state
                    if gpiostate[machinePin] == msgstate:
                    #and it is already active and the condition is good send a tweet
                        if active:
                            try:
                                print "sending tweet"
                                tweet = DIPMSG[3] + " " + str(time.strftime('%X'))
                                print tweet
                                twit.statuses.update(status=tweet)
                            except MySQLdb.Error:
                                print "twitter error"
                            curwrite.execute ("UPDATE DIPMessages SET ACTIVE='0' WHERE DIPPin='%s' " % (DIPMSG[0]))
                    #if it isn't in the required state then make it active
                    else:
                        curwrite.execute ("UPDATE DIPMessages SET ACTIVE='1' WHERE DIPPin='%s' " % (DIPMSG[0]))
                #If the DIP Switch is off make the DIP Message inactive
                else:
                    curwrite.execute ("UPDATE DIPMessages SET ACTIVE='0' WHERE DIPPin='%s' " % (DIPMSG[0]))
            cur.close()
            curwrite.close()
        except MySQLdb.Error, e:
            print "Database DIP Message Read failed"

  

    except KeyboardInterrupt:
        GPIO.cleanup()
        raise
        
        
   