<?php
require'./config.php';
require'./includes/db.php';
//this will be run as a cron!//
//needs to be in the same dir as shoutcast//
//the PASSWORD line MUST be changed to be on line 1

//chpassfunction opens config, puts it into an array, changes password, writes array to file//
function chpass($newpass) {
$oldconf = file("sc_serv.conf");
$oldconf[0] = 'Password='.$newpass."\n";
$handle = fopen("sc_serv.conf","w");
foreach($oldconf as $new) {
fwrite($handle, $new);
}
fclose($handle);
}
//
$usr_y = date('Y'); // 2004,2005,2006..
$usr_m = date('m'); // 01,02,03..
$usr_d = date('d'); // 01,02,03..
$usr_h = date('H'); // 00,01,02..

$day = unserialize(mysql_result(mysql_query("SELECT `values` FROM  `book_2` WHERE `name` = 'day'"),0));
$pass = unserialize(mysql_result(mysql_query("SELECT `values` FROM  `book_2` WHERE `name` = 'pass'"),0));
$email = mysql_result(mysql_query("SELECT `email` FROM `user` WHERE `nick` = '".$day[$usr_h][$usr_d][$usr_m][$usr_y]."'"),0);
if(!$pass[$usr_h][$usr_d][$usr_m][$usr_y]) { 
	

			$l = rand(10,20);
			while ($I < $l) {
				if(rand(1,5) != 1) {
					$I++;
					$r = rand(97,122);
					$genpass .= chr($r);
				}
				else { $genpass .= "_"; }
			}
			
	
	$pass[$usr_h][$usr_d][$usr_m][$usr_y] = $genpass;
	
	mysql_query("UPDATE `book_2` SET `values` = '".serialize($pass)."' WHERE `name` = 'pass';");
}
//kill shoutcast
//change the password//
chpass($pass[$usr_h][$usr_d][$usr_m][$usr_y]);
//run shoutcast
system('./a.sh');

//write and send them an email//
$msg = 	"<pre><b>You should be broadcasting!</b>\n\n";
$msg .= "Your time slot just became avaliable which (hopefully) means you should be broadcasting right now\n";
$msg .= "If not, please do so!\n";
$msg .= "The server address is: {$webHost}\n";
$msg .= "The server port is: 8000\n";
$msg .= "Your password is: ".$pass[$usr_h][$usr_d][$usr_m][$usr_y]."\n";
$msg .= "The URL of your broadcast will be: http://{$webHost}:8000/listen.pls\n";
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
//FIXME: should really let the whole address be settable!
$headers .= "From:reminder@{$msgHost}";
mail($email, "Broadcast Reminder!", $msg, $headers);

?>

