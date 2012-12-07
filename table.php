<?php

//config//
if( (!$_GET['show_days_in_future']) || ($_GET['show_days_in_future'] > 30)){
$days_to_show = "6"; //how many days to display//
//
}
else { $days_to_show = $_GET['show_days_in_future']; }
while($i < $days_to_show) {
$future = ($i*86400);
echo '<br><div id="size12"><table bgcolor="#143B69" cellpadding="1" cellspacing="0" border="0" align="center"><tr><td>';
echo " &nbsp;&nbsp;".date('l',date('U') + $future)." ".date('d',date('U') + $future)."/".date('m',date('U') + $future)."/".date('Y',date('U') + $future);
echo '</td></tr><tr><td>';//a
echo '<table width="500" border="0" align="center" cellpadding="3" cellspacing="1">';
$i++;

$diff_in_sec = 3600 * (date('H') - 01); //find the difference between the current hour and 01 ( in seconds )

	while($j < 24) {
$time_to_echo = date('H',date('U') - $diff_in_sec + ($hour_add * 3600));//taken it down to 1 then add ..
$a = date('H', date('U') + $future - $diff_in_sec + ($hour_add * 3600)); 
$b = date('d', date('U') + $future - $diff_in_sec + ($hour_add * 3600)); 
$c = date('m', date('U') + $future - $diff_in_sec + ($hour_add * 3600));
$d = date('Y', date('U') + $future - $diff_in_sec + ($hour_add * 3600));
$hour_add++;
if(((($future > 0) || ($time_to_echo > date('H'))) || ($time_to_echo == 00))) { $link = TRUE;  } //if it isn't today, or time is greater than current time, or time is 00
if($link != TRUE) { $colour = "#969696"; }
elseif(isset($day[$a][$b][$c][$d])) {
	if($_COOKIE['MindSlap_Radio_u'] == $day[$a][$b][$c][$d]) { $colour = "yellow"; }
	else { $colour = "red"; }
	}
else { $colour = "green"; }
$l = $a.$b.$c.$d;
//echo $day[$a][$b][$c][$d];

		echo '<td ';
		if($link) { echo 'onmouseover="this.style.cursor=\'hand\';" onclick="location.href=\'?q='.$l.'\';" '; }
		echo 'width="32" align="center" bgcolor="'.$colour.'">';
		if($link) { echo '<a href="?q='.$l.'">'; }
		echo $time_to_echo.'</a></td>';
		if($j == 11) { echo '<tr>'; }

$j++;	
unset($colour);
unset($link);
}
echo "</td>\n";
echo "</table>";
echo '</td></tr></table></div>';
unset($j);
unset($hour_add);
}	

if (1==2) {
?>
<br><form name="future" method="get" action="">
<br><table align="center" width="500" cellpadding="1" bgcolor="#19785A" cellspacing="0"><tr><td><table width="100%" bgcolor="#E1EBEC"><tr><td align="center"><div id="size13">

  Number of days to display:
  	<input type="hidden" name="bo">
    <input name="show_days_in_future" type="text" size="2" value="<?php echo $days_to_show; ?>">
    <input type="submit" name="Submit" value="Go">

</div></td></tr></table></td></tr></table><br> </form><?php } ?>