#!/bin/bash
PID=`ps aux | grep "PushFromDBToSendApi.php" | grep -v grep | awk '{print $2}'`

if [ -z "$PID" ]
then
	cd /opt/ops_web_dir/mail_sms_inc && php PushFromDBToSendApi.php >/dev/null 2>&1 &	
fi

exit 0
