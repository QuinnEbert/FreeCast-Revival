<?php
$dbhost = 'localhost';
$dbuser = 'username';
$dbpass = 'password';
$dbname = 'freecast';

$sql = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname);
?>
