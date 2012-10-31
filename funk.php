<?php

function check($username,$sha1) {
	require'./includes/db.php';
	$sql = "SELECT pass FROM `user` WHERE `nick` = '".stripslashes($username)."' LIMIT 0 , 30";
	$result = mysql_query($sql);
	$pashed = mysql_result($result,0);
	trigger_error("Hashed pass seen: ".$sha1." v. ".$pashed);
	if($pashed == $sha1) {
		trigger_error("Pass==OK");
		return TRUE;
	} else {
		trigger_error("Pass==NO");
		return FALSE;
	}
}

function cookie($username,$sha1) {
	require'./config.php';
	setcookie("MindSlap_Radio_u", $username, time()+99999999, "/", $webHost, 0);
	setcookie("MindSlap_Radio_s", $sha1, time()+99999999, "/", $webHost, 0);
	
}

function cookiechk() {
	
	if((!$_COOKIE['MindSlap_Radio_u']) || (!$_COOKIE['MindSlap_Radio_s'])) { return FALSE; }
else {	
if(check($_COOKIE['MindSlap_Radio_u'],$_COOKIE['MindSlap_Radio_s'])) { DEFINE("LOGGEDIN","YES"); return TRUE; }
}
	}
	require'./config.php';
	function logout() {
	setcookie("MindSlap_Radio_u", $username, time()-99999999, "/", $webHost, 0);
	setcookie("MindSlap_Radio_s", $sha1, time()-99999999, "/", $webHost, 0);
}
	?>