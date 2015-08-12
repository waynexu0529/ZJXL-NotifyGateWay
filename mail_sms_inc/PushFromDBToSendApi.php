<?php
//curl data from DB  to sms_api;

require_once('./mail_db_conn.php');
$conn = db_connect();

$SELECT_SQL = " SELECT sms_queue.id,sms_queue.content,receiver_info.phone_number
		FROM  sms_queue,receiver_info 
		WHERE sms_queue.contact = receiver_info.user_name
		AND sms_queue.send_result = 'pending'; ";

include("./SendSMS.php");

while ( "ok" ){

$SELECT_RESULT = mysql_query($SELECT_SQL,$conn);

if ( $SELECT_RESULT )
{

	while ( $SELECT_ARRAY = mysql_fetch_array($SELECT_RESULT) )
	{

		$datetime = date('Y-m-d H:i:s');
		file_put_contents("log/ops_system.log",$datetime."Select_result: ".$SELECT_ARRAY['phone_number']." - ".$SELECT_ARRAY['content'].".\n",FILE_APPEND);

		$RESPONDS = SEND_SMS($SELECT_ARRAY['phone_number'],$SELECT_ARRAY['content']);
	
		if ( $RESPONDS == "true" )
		{
			$UPDATE_SQL = "UPDATE sms_queue SET send_result = 'success' WHERE id='".$SELECT_ARRAY['id']."';";
		}else{

			$RESPONDS = SEND_SMS($SELECT_ARRAY['phone_number'],$SELECT_ARRAY['content']);
			if ( $RESPONDS == "true" )
			{
				$UPDATE_SQL = "UPDATE sms_queue SET send_result = 'success' WHERE id='".$SELECT_ARRAY['id']."';";
			}else{
				$UPDATE_SQL = "UPDATE sms_queue SET send_result = 'fail' WHERE id='".$SELECT_ARRAY['id']."';";
			}
		}

		mysql_query($UPDATE_SQL,$conn);
		file_put_contents("log/ops_system.log",$datetime." Finished - Update: ".$UPDATE_SQL.".\n",FILE_APPEND);

	}

}

#$UPDATE_SQL_S = "update sms_queue set send_result = 'skip' where send_result = 'pending';";
#mysql_query($UPDATE_SQL_S,$conn);

sleep(1);

}
?>
