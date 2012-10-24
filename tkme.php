<br><table align="center" width="500" cellpadding="1" bgcolor="#19785A" cellspacing="0"><tr><td><table width="100%" bgcolor="#E1EBEC"><tr><td><div id="size13">
<font size=2>
<p align=center>
<?php if(!isset($_GET['yes'])) { ?>
Are you sure you want to take this slot?<br>
This will cost you <b>0</b> slots.<br><br>

<a href=?tk_me&yes>Yes</a>

<?php } else { 
mysql_connect('localhost', 'mindweb_r4d10', 'dsfj2_124c');
mysql_select_db('mindweb_radio');
$usr_y = date('Y'); // 2004,2005,2006..
$usr_m = date('m'); // 01,02,03..
$usr_d = date('d'); // 01,02,03..
$usr_h = date('H'); // 00,01,02..
$date = $usr_y."-".$usr_m."-".$usr_d."-".$usr_h;
$sql_se = @mysql_query("SELECT * FROM `time` WHERE `date` = '".$date."' ");
	if(@mysql_num_rows($sql_se) >= 1) { 
$times = mysql_result($sql_se,0,2);
		if($times >= 10) {
$pass = unserialize(mysql_result(mysql_query("SELECT `values` FROM  `book_2` WHERE `name` = 'pass'"),0));

$day = unserialize(mysql_result(mysql_query("SELECT `values` FROM  `book_2` WHERE `name` = 'day'"),0));
$day[$usr_h][$usr_d][$usr_m][$usr_y] = $_COOKIE['MindSlap_Radio_u'];

mysql_query("UPDATE `book_2` SET `values` = '".serialize($day)."' WHERE `name` = 'day';");
echo "Your password is: <b>";
echo '<input type="text" size="40" style="text-align:center " value="';
echo $pass[$usr_h][$usr_d][$usr_m][$usr_y];
echo '"></input></b><br><b>REMEMBER</b> this, you will NOT be able to retreive it.<br>
<b>Please Note</b>: This Script is currently very buggy, if you have a problem please report it in the forums (accessable through \'Contact\' link at the top.<br>
Also, temporarily, if you see an empty box / no password then use the password \'0\', this will be fixed in the near future.';			
mysql_query("UPDATE `time` SET `times` = '0' WHERE `date` = '".$date."' ");		
		 }
	 }
	
	
	 } ?>
</div></td></tr></table></td></tr></table>