<?php
require'./includes/db.php';
$result_of_dupe_ip = mysql_query("SELECT lastip,COUNT(*) FROM user GROUP BY lastip HAVING COUNT(*) > 1;");
for($i = 0; $i < mysql_num_rows($result_of_dupe_ip); $i++) {
echo "$i : ";
print_r(mysql_result($result_of_dupe_ip,$i));
echo "<br>";	

$result = mysql_query("SELECT id,user,ip FROM `user`  WHERE 1 AND `lastip` = '".mysql_result($result_of_dupe_ip,$i)."'");
if(mysql_num_rows($result) > 1) {
//delete those fuqn nubs//
for($j = 0; $j < mysql_num_rows($result_of_dupe_ip); $j++) {
if($j >= 1) {
echo mysql_result($result,$j,1);
echo "<br>";
//$sql =  "DELETE FROM `user` WHERE `id` = '".mysql_result($result,$j)."'  LIMIT 1";
//mysql_query($sql);
	}
	}
	}

}

?>