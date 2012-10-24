<?php

function download($url) {
$parsed = parse_url($url);

	$host = $parsed[host];
	$path = $parsed[path];
	$port = $parsed[port];
	
	$fp = fsockopen ($host, $port);
	
	fputs($fp, "GET /index.html HTTP/1.1\r\n");
	fputs($fp, "User-Agent: nouse.php (Mozilla Compatible)\r\n\r\n");


			while( !feof($fp) )
		{

		$file_data .= fread($fp, 1024);
		}
		fclose($fp);
		
	return $file_data;
	}
	
/*function strip_response_header($source) {
	
    $headerend = strpos($source,"\r\n\r\n");
    if (is_bool($headerend)) {
    $result = $source;
    }
    else {
        $result = substr($source,$headerend+7,strlen($source) - ($headerend+4));
    }
    return $result;
} 
*/	
///////////////

require'./includes/db.php';

$status = download("http://freecast.co.uk:8000/index.htm");
if(strpos($status,"Server is currently down.") !== FALSE) {

	
	$usr_y = date('Y'); // 2004,2005,2006..
	$usr_m = date('m'); // 01,02,03..
	$usr_d = date('d'); // 01,02,03..
	$usr_h = date('H'); // 00,01,02..
	
	$date = $usr_y."-".$usr_m."-".$usr_d."-".$usr_h;
//	$day = unserialize(mysql_result(mysql_query("SELECT `values` FROM  `book_2` WHERE `name` = 'day'"),0));
//	$pass = unserialize(mysql_result(mysql_query("SELECT `values` FROM  `book_2` WHERE `name` = 'pass'"),0));

	$sql_se = mysql_query("SELECT * FROM `time` WHERE `date` = '".$date."' ");
	
	
	if(mysql_num_rows($sql_se) >= 1) { 
		/*update*/
		$id = mysql_result($sql_se,0);
		$times = mysql_result($sql_se,0,2);
		if($times < 10) {
		$times++;
		
		mysql_query("UPDATE `time` SET `times` = '".$times."' WHERE `id` = '".$id."' LIMIT 1 ;");
		
		 } 
	 }
	else {  //create
		mysql_query("INSERT INTO `time` (`date` , `times` ) VALUES ('".$date."', '1');");
}

} else { mysql_query("UPDATE `time` SET `times` = '0' `date` = '".$date."' "); }