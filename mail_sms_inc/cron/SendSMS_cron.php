<?php
include_once("../SendSMS.php");

$NotificationResult = file_get_contents("./result.txt");

//echo $NotificationResult;

SEND_SMS("13911484765,15810613566","[ZJXL_IT From tiger]\n$NotificationResult.");
//SEND_SMS("18610212142","【中交兴路监控平台】:短信通讯正常！你该下班了!]");
?>
