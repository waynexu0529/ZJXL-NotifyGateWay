<?php

# define vari
$COUNT_FILE="./.ops_sms_tmp";
$OP_COUNT_PER_MINUTE="60";

# define function
function F_Log($log_content){
    $logfile = "./logs/count.log";
    $Flog = fopen($logfile,"a+");
    $datetime = date('Y-m-d H:i:s',time());
    fwrite($Flog,$datetime." ".$log_content."\n");
    fclose($Flog);
}

function F_InitCountFile(){
    global $COUNT_FILE;

    $FD = fopen($COUNT_FILE,'w+');
    $datetime = date('H:i',time());
    $count_number = "1";
    fwrite($FD,$datetime."-".$count_number);
    fclose($FD);
}

function F_ReplaceCountFile($datetime,$number){
    global $COUNT_FILE;

    $FD = fopen($COUNT_FILE,'w+');
    fwrite($FD,$datetime."-".$number);
    fclose($FD);
}

function F_CountAdd(){
    global $COUNT_FILE;
    global $OP_COUNT_PER_MINUTE;

    if(!file_exists($COUNT_FILE)){
      F_InitCountFile();
    }

    $FD = fopen($COUNT_FILE,'r');
    if(!$FD){
        F_Log("Error: Temp file is not exist!");
        die("Error: Temp file is not exist!");
    }

    $content = fgets($FD);
    $content_list = split("-",$content);
    $content_date = $content_list[0];
    $content_count = $content_list[1];

    $datetime_now = date('H:i',time());

    if ( $content_date != $datetime_now ){
        F_InitCountFile();
        F_log("ok:1\n");
        return "ok:1\n";
    }

    if ( $content_count < $OP_COUNT_PER_MINUTE ){
        F_ReplaceCountFile($content_date,$content_count+1);
        F_log("ok:".$content_count."\n");        
        return "ok:".$content_count."\n";
    }else{
        F_ReplaceCountFile($content_date,$content_count+1);
        F_log("Error:".$content_count."\n");
        return "Error:".$content_count."\n";
    }

}

//F_CountAdd();

?>
