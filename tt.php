<?php
$days_to_show = "6";
while($i < $days_to_show) {
$future = ($i*86400);

echo " &nbsp;&nbsp;".date('l',date('U') + $future)." ".date('d',date('U') + $future)."/".date('m',date('U') + $future)."/".date('Y',date('U') + $future);

echo '<table width="100%"  border="0"><tr>';

$i++;
$diff_in_sec = 3600 * (date('H') - 01); //find the difference between the current hour and 01 ( in seconds )

while($j < 24) {
$time_to_echo = date('H',date('U') - $diff_in_sec + ($hour_add * 3600));//taken it down to 1 then add ..
$a = date('H', date('U') + $future - $diff_in_sec + ($hour_add * 3600)); 
$b = date('d', date('U') + $future - $diff_in_sec + ($hour_add * 3600)); 
$c = date('m', date('U') + $future - $diff_in_sec + ($hour_add * 3600));
$d = date('Y', date('U') + $future - $diff_in_sec + ($hour_add * 3600));
$hour_add++;
		echo '<tr><td>';
		echo $time_to_echo;
		echo ':00';
		echo '</td><td>';
		echo 'ARITST';
		echo '</td><td>';
		echo 'LBHERHHG';
$j++;
			}
			echo '</td></tr></table><br>';
			unset($j);
	
}
?>