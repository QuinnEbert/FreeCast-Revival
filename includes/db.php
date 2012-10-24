<?php
$dbhost = 'Database server address';
$dbuser = 'Database user name';
$dbpass = 'Database password';
$dbname = 'Database name';

$sql = mysql_connect('$dbhost', '$dbuser', '$dbpass');
mysql_select_db('$dbname');
?>