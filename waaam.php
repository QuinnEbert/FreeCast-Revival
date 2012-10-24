<?php
require'./includes/db.php';
	$pass = unserialize(mysql_result(mysql_query("SELECT `values` FROM  `book_2` WHERE `name` = 'pass'"),0));
	echo '<pre>';
	print_r( $pass );
?>