<?php
require'./includes/db.php';
	$re = mysql_query("SELECT `nick` FROM `user`");
	for($i = 0; $i < mysql_num_rows($re); $i++) {
	$user = mysql_result($re,$i,0);
	$result = mysql_query("SELECT `slots` FROM `user` WHERE `nick` = '".$user."';");
	$slots = mysql_result($result,0);
	$p = strpos($slots,"/");
	$used = substr($slots,0,$p);
	$max = substr($slots,$p + 1);
	$left = $max-$used;
if($used <= $max) {	$slotz = "0/".$max; }
		mysql_query("UPDATE `user` SET `slots` = '".$slotz."' WHERE `nick` = '".$user."';");
}
	
?>