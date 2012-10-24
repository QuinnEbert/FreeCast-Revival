<?php
function check($username,$sha1) {
$sql = "SELECT pass FROM `user` WHERE 1 AND `nick` = '".stripslashes($username)."' LIMIT 0 , 30";
require'./includes/db.php';
$result = @mysql_query($sql);
if(@mysql_result($result,0) == $sha1) {
	return TRUE;
}
else {
	return FALSE;
}
}

function cookie($username,$sha1) {

	setcookie("MindSlap_Radio_u", $username, time()+99999999, "/", ".freecast.co.uk", 0);
	setcookie("MindSlap_Radio_s", $sha1, time()+99999999, "/", ".freecast.co.uk", 0);
	
}

function cookiechk() {
	
	if((!$_COOKIE['MindSlap_Radio_u']) || (!$_COOKIE['MindSlap_Radio_s'])) { return FALSE; }
else {	
if(check($_COOKIE['MindSlap_Radio_u'],$_COOKIE['MindSlap_Radio_s'])) { DEFINE("LOGGEDIN","YES"); return TRUE; }
}
	}

	function logout() {
	setcookie("MindSlap_Radio_u", $username, time()-99999999, "/", ".freecast.co.uk", 0);
	setcookie("MindSlap_Radio_s", $sha1, time()-99999999, "/", ".freecast.co.uk", 0);
}
	?>