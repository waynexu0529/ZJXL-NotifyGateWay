<?php
function SEND_API($post_field){
	$ch = curl_init();
	$url = "http://114.242.194.229/sendsms_api.php";
	curl_setopt($ch, CURLOPT_URL, $url);
	//curl_setopt($ch, CURLOPT_USERPWD,"$user:$pass");
	curl_setopt($ch, CURLOPT_POSTFIELDS,"$post_field");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$rsp = curl_exec($ch);
	curl_close($ch);
	$datetime = date('Y-m-d H:i:s');
	$rsp = trim($rsp);
	if( $rsp == "ok" ){
		//file_put_contents("log/ops_system.log",$datetime." ".$user." login success.\n",FILE_APPEND);
		return ("true");
	}else{
		//file_put_contents("log/ops_system.log",$datetime." ".$user." login failed.\n",FILE_APPEND);
		return("false");
}
//return ( $rsp == "OK" )

}

//curl data from DB  to sms_api;

require_once('./mail_db_conn.php');
$conn = db_connect();

$SELECT_SQL = " SELECT sms_queue.id,sms_queue.content,receiver_info.phone_number
		FROM  sms_queue,receiver_info 
		WHERE sms_queue.contact = receiver_info.user_name
		AND sms_queue.send_result = 'pending'; ";

while ( "ok" ){

$SELECT_RESULT = mysql_query($SELECT_SQL,$conn);

if ( $SELECT_RESULT )
{
	while ( $SELECT_ARRAY = mysql_fetch_array($SELECT_RESULT) )
	{
		//print $SELECT_ARRAY['id']."\n";
		//print $SELECT_ARRAY['content']."\n";
		//print $SELECT_ARRAY['phone_number']."\n";
		//var_dump($SELECT_ARRAY);
		$RESPONDS = SEND_API("post_phone=".$SELECT_ARRAY['phone_number']."&post_content=".$SELECT_ARRAY['content']);
		//print $RESPONDS."\n";

		if ( $RESPONDS == "true" )
		{
			$UPDATE_SQL = "UPDATE sms_queue SET send_result = 'success' WHERE id='".$SELECT_ARRAY['id']."';";
		}else{
			$UPDATE_SQL = "UPDATE sms_queue SET send_result = 'fail' WHERE id='".$SELECT_ARRAY['id']."';";
		}

		mysql_query($UPDATE_SQL,$conn);

	}

}

#$UPDATE_SQL_S = "update sms_queue set send_result = 'skip' where send_result = 'pending';";
#mysql_query($UPDATE_SQL_S,$conn);

sleep(1);

}
?>
