#!/bin/bash
send_url="http://192.168.111.111/mail_sms/sms.php.SINOIOV"
receiver="xuyingwei@sinoiov.com"
#receiver="wuxianglun@sinoiov.com"
message_title="The notify title of test"
message_body="The notify body of test"
#username="nagios"
#password="nagios"
username="ops_zabbix"
password="opszabbix234#"

curl -d "notify_receiver=$receiver&notify_title=$message_title&notify_body=Infor: $message_title<\br>url:$download_page<\br>date: $datetime<\br>&user_name=${username}&user_passwd=${password}"  $send_url
