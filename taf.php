<?php
require'./includes/db.php';
if(($_POST['taf']) AND ($_POST['email']))

{
	$_POST['email'] = str_replace(" ","",$_POST['email']);
	$i = 0;
	if(strstr($_POST['email'],',')) {
		$emails = explode(',',$_POST['email']); 
		foreach($emails as $email) {
		if (ereg("[A-Za-z0-9_-]+([\.]{1}[A-Za-z0-9_-]+)*@[A-Za-z0-9-]+([\.]{1}[A-Za-z0-9-]+)+", $email)) { 
			//if it's valid
		$valid[$i] = $email;
		$i++;
			}
			}
		
}
elseif (ereg("[A-Za-z0-9_-]+([\.]{1}[A-Za-z0-9_-]+)*@[A-Za-z0-9-]+([\.]{1}[A-Za-z0-9-]+)+", $_POST['email'])) {
$valid[$i] = $email;
	} 
if(isset($valid)) {

unset($msg);
$msg .= "<pre>";
$msg .= $_POST['msg'];
$msg .= "\n";
$msg .= "============================================================\n";
$msg .= "\n";
$msg .= "A FreeCast member thought you would like to know about our service!\n";
$msg .= "\n";
$msg .= "Hi! Someone using FreeCast thinks that you too might be interested in our service.\n";
$msg .= "They have used our Refer-A-Friend system to tell you about FreeCast.";
$msg .= "FreeCast is a <b>Free</b> (as in without charge) \nservice which allows everyone and anyone to \nbroadcast their music or talk live, to the internet!\n";
$msg .= "We allow new user sign ups 2 hours of FreeCasting per week.";
$msg .= "It's all explain at our website\n If you think you might be interested, visit us at: ";
$msg .= "<a href=\"http://freecast.co.uk\" target=\"_new\">http://www.FreeCast.co.uk</a>\n";
$msg .= "Thanks Alot,\n";
$msg .= "The FreeCast Team.\n";
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From:FreeCast Radio <Administrator@freecast.co.uk>";
$title = "A FreeCast member thought you would like to know about our service!";

foreach($valid as $sendto) {
if(!@mysql_result(@mysql_query("SELECT * FROM `taf` WHERE `email` = '".$sendto."'"),0)) {
$sql = "INSERT INTO `taf` ( `email` , `friend` ) VALUES ( '".$sendto."', '".$_COOKIE['MindSlap_Radio_u']."');";
@mysql_query($sql);
mail($sendto, $title, $msg, $headers);
	}
}
echo 'Thankyou! Emails have been sent!<br>As a reward, you will receive an extra slot for each signup from the emails you submitted';
}
}
else { require 'taf.htm'; }
?>
