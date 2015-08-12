<?php
	define('DB_SERVER', "localhost");
	define('DB_USER', "wayne");
	define('DB_PASS', "operation-password");
	define('DB_NAME', "mail_sms");
	
    function db_connect()
    {
    	$conn = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
		if(!$conn)
		{
			die("Cannot connect to the database:".mysql_error());
		}
		mysql_select_db(DB_NAME, $conn);
		mysql_query("set names 'utf8'");
		return $conn;
    }
   
    function db_disconnect($connection)
    {
		if(isset($connection))
		{
			mysql_close($connection);
		}	
    }

?>
