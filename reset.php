<?php
@mysql_connect('localhost', 'mindweb_r4d10', 'dsfj2_124c');
@mysql_select_db('mindweb_radio');

if(($_POST) AND (!$_POST['h'])) {	
if($_POST['user']) {
$sql = "SELECT `id`,`email` FROM `user` WHERE `nick` = '".stripslashes($_POST['user'])."';";
if($result = @mysql_query($sql))
{
	if(!@mysql_result($result,0,1)) { die('Invalid username or email address.'); }
	$email = @mysql_result($result,0,1);
	$id = @mysql_result($result,0);
	$hash = @sha1(rand(0,65535));
	$sql = "UPDATE `user` SET `hash` = '".$hash."' WHERE `id` = '".$id."'";

	}
	}

elseif($_POST['email']) {
$sql = "SELECT `id` FROM `user` WHERE `email` = '".stripslashes($_POST['email'])."' LIMIT 0 , 30";	
if($result = @mysql_query($sql))
{
	$email = $_POST['email'];
	$id = mysql_result($result,0);
	$hash = sha1(rand(0,9999));
	$sql = "UPDATE `user` SET `hash` = '".$hash."' WHERE `id` = '".$id."'";
}
}
echo 'An email with details on how to reset your password has been sent to the email provided';	
mysql_query($sql);
$msg	 = "<pre><b>Password Reset</b>\r\n";
$msg	 .= "You or Someone Else has requested that the password for your account be reset\r\n";
$msg	 .= "To complete the reset process click this link:";
$msg	 .= ' <a href="http://freecast.co.uk/reset.php?h='.$hash.'" target="_new">Reset My Password</a></pre>';
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From:MindSlap Radio <reset@mindslap.co.uk>";
mail($email, "Password Reset!", $msg, $headers);
}

elseif($_POST['h']) {

	$sql = "SELECT `id` FROM `user` WHERE `hash` = '".stripslashes($_POST['h'])."';";
	$result = mysql_query($sql);
	if($id = mysql_result($result,0)) {
	$sql = "UPDATE `user` SET `pass` = '".sha1($_POST['pass'])."' WHERE `id` = '".$id."' LIMIT 1 ;";
	if(@mysql_query($sql)) { echo 'Your password has been changed!'; }
	else { echo 'there was an error, please report this to the sysadmin'; }
	}
}

elseif($_GET['h']) {

	$sql = "SELECT `id` FROM `user` WHERE `hash` = '".stripslashes($_GET['h'])."';";
	$result = @mysql_query($sql);
	if(@mysql_result($result,0)) {
	echo 'Please choose a new password<form method="post" action="">';
echo '<input type="text" name="pass">';
echo '<input type="hidden" name="h" value="'.$_GET['h'].'">';
echo '<input type="submit" name="Submit" value="Submit">';
echo '</form>';
	}
}


else { include("rst.htm"); }