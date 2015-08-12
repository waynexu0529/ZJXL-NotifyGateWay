#!/bin/bash
SPATH=`cd $(dirname $0);pwd`

N_STATUS_FILE="/usr/local/nagios/var/status.dat"
RESULT_FILE="${SPATH}/result.txt"
LOG_FILE="${SPATH}/log/$0.log"
DATE_TIME=`date +%Y-%m-%d" "%H:%M:%S`

ENABLE_SERVICE=`cat $N_STATUS_FILE | grep -w "notifications_enabled=1" | wc -l`
DISABLE_SERVICE=`cat $N_STATUS_FILE | grep -w "notifications_enabled=0" | wc -l`

echo "$DATE_TIME EnableServiceAndHost: $ENABLE_SERVICE" > $RESULT_FILE
echo "DisableServiceAndHost: $DISABLE_SERVICE" >> $RESULT_FILE

echo "$DATE_TIME EnableServiceAndHost: $ENABLE_SERVICE" >> $LOG_FILE
echo "$DATE_TIME DisableServiceAndHost: $DISABLE_SERVICE" >> $LOG_FILE

