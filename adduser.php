<?php
require "config.php";
if(!$_POST) { require "au.htm"; }
elseif($_POST) {
if(!$_POST['checkbox']) { die('You must agree with the <a href="?tos">Terms of Service</a> before registration can continue'); }
	if((!$_POST['name']) OR (!$_POST['nick']) OR (!$_POST['email']) OR (!$_POST['showname']) OR (!$_POST['showdesc'])) { die('Please fill in <b>all</b> the fields.');  }
	else {
	
			if (!ereg("[A-Za-z0-9_-]+([\.]{1}[A-Za-z0-9_-]+)*@[A-Za-z0-9-]+([\.]{1}[A-Za-z0-9-]+)+", $_POST['email'])) { die( 'Your email address is invalid. Please enter a valid email address' ); }
	//make password

require './includes/db.php';

$sql = "SELECT * FROM `user` WHERE `nick` = '".addslashes($_POST['nick'])."'";
$result = @mysql_query($sql);
if(@mysql_result($result,0)) { die('username already taken'); }
$sql = "SELECT * FROM `user` WHERE `email` = '".addslashes($_POST['email'])."'";
$result = @mysql_query($sql);
if(@mysql_result($result,0)) { die('email already taken'); }
if($plus = @mysql_result(@mysql_query("SELECT `friend` FROM `taf` WHERE `email` = '".$_POST['email']."'"),0)) {
//yarrr ugly code ahead!//
	$result = mysql_query("SELECT `slots` FROM `user` WHERE `nick` = '".$plus."';");
	$slots = mysql_result($result,0);
	$p = strpos($slots,"/");
	$used = substr($slots,0,$p);
	$max = substr($slots,$p + 1);
	$slotz = $used."/".($max+1);
	mysql_query("UPDATE `user` SET `slots` = '".$slotz."' WHERE `nick` = '".$plus."';");
///
	}
	$l = rand(10,20);
	while ($i < $l) {

if(rand(1,5) != 1) {
			$i++;
		$r = rand(97,122);
		$pass .= chr($r);
	}
	else { $pass .= "_"; }
	}
$sql = "INSERT INTO `user` ( `name` , `nick` , `pass` , `email` , `show` , `showdesc`, `slots` ) VALUES ('".addslashes($_POST['name'])."', '".addslashes($_POST['nick'])."', '".sha1($pass)."', '".addslashes($_POST['email'])."', '".strip_tags(addslashes($_POST['showname']))."', '".strip_tags(addslashes($_POST['showdesc']))."', '0/2');";
if(mysql_query($sql)) { 
echo "Your account has been added, an email has been sent to ".$_POST['email']." containing your login information."; 
$msg = 	"<pre>Congratulations! An account has just been created for you at FreeCast Radio!\n\n";
$msg .= "You can login here: <a href=\"http://{$webHost}/index.php?login\" target=\"_new\">http://{$webHost}/index.php?login</a>\n\n";
$msg .= "Your username is: ".$_POST['nick']."\n";
$msg .= "And your password: $pass\n";
$msg .= "<b>Please remember your password</b>\n\n";
$msg .= "As a new user you are allowed a maximum of two slots per week\n";
$msg .= "This means that you can broadcast for a total of two hours per week\n";
$msg .= "For information on how to broadcast please visit the guide on our website.\n\n";
$msg .= "Thanks,\n";
$msg .= "The FreeCast Team.";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From:FreeCast Radio <Administrator@{$msgHost}>";
mail($_POST['email'], "Your user account!", $msg, $headers);

	}
}	
}
?>
