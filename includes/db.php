<?php
require'../config.php';
$sql = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname);
?>