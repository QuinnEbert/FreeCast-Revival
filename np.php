<?php
require'./includes/db.php';
$day = unserialize(mysql_result(mysql_query("SELECT `values` FROM  `book_2` WHERE `name` = 'day'"),0));

$usr_y = date('Y'); // 2004,2005,2006..
$usr_m = date('m'); // 01,02,03..
$usr_d = date('d'); // 01,02,03..
$usr_h = date('H'); // 00,01,02..
$date = $usr_y."-".$usr_m."-".$usr_d."-".$usr_h;


//NOW
$sql = "SELECT `show`,`showdesc` FROM `user` WHERE `nick` = '".$day[$usr_h][$usr_d][$usr_m][$usr_y]."' LIMIT 1";
$result = @mysql_query($sql);
$sn = stripslashes(strip_tags(@mysql_result($result,0,0)));
$sd = stripslashes(strip_tags(@mysql_result($result,0,1)));


//NEXT
$NXTsql = "SELECT `show`,`showdesc` FROM `user` WHERE `nick` = '".$day[$usr_h+1][$usr_d][$usr_m][$usr_y]."' LIMIT 1";
$NXTresult = @mysql_query($NXTsql);
$NXTsn = stripslashes(strip_tags(@mysql_result($NXTresult,0,0)));
$NXTsd = stripslashes(strip_tags(@mysql_result($NXTresult,0,1)));

//IF NOT NOW AND NOT NEXT
if($sn == "") { $sn = 'No show currently playing.'; }
else { $sn = "$sn"; }

if($NXTsn == "") { $NXTsn = 'No show is booked for this slot, sign up now and book it yourself!'; }
else { $NXTsn = "$NXTsn"; }

//BLEE BLAA BLOO BLAAA
$sql_se = @mysql_query("SELECT * FROM `time` WHERE `date` = '".$date."' ");
	if(@mysql_num_rows($sql_se) >= 1) { 
$times = mysql_result($sql_se,0,2);
		if($times >= 10) {
unset($day[$usr_h][$usr_d][$usr_m][$usr_y]);
unset($sd);
			$sn = "This slot has been unused for 10 or more minutes.<br>";
			if(cookiechk()) { $sn .= "</u><a href=?tk_me>Take this Slot!</a>"; }
			else { $sn .="</u><a href=?register>Register</a> or <a href=?login>Login</a> and take this slot now!</a>"; }
		
		 }
	 }


?>
<br>
<table align="center" cellpadding="3" cellspacing="0" width="506">
<tr><td valign="top" width="50%">
<table align="center" height="100%" width="100%" cellpadding="1" bgcolor="#19785A" cellspacing="0"><tr><td><table width="100%" bgcolor="#E1EBEC"><tr><td align="left"><div id="size13">

<table height="100" border="0">
<tr>
<td valign="top"><font class=title1><b>On air: <?php  
echo '<a href="?dj=';
echo $day[$usr_h][$usr_d][$usr_m][$usr_y];
echo '">';
echo $day[$usr_h][$usr_d][$usr_m][$usr_y];
echo '</a>';
 ?></b></font></td>
</tr>
<tr>
    <td valign="top"><font class=title1><u><?php echo stripslashes($sn); ?></u></font></td>
  </tr>
  <tr>
    <td valign="top"><div id="size13"><?php echo stripslashes($sd); ?></div></td>
  </tr>
</table>
</div></td></tr></table></td></tr></table>
</td><td valign="top" width="50%">
<table align="center" height="100%" width="100%" cellpadding="1" bgcolor="#19785A" cellspacing="0"><tr><td><table width="100%" bgcolor="#E1EBEC"><tr><td align="left"><div id="size13">

<table height="100" border="0">
<tr>
<td valign="top"><font class=title1>Next up: <b><?php  
echo '<a href="?dj=';
echo $day[$usr_h+1][$usr_d][$usr_m][$usr_y];
echo '">';
echo $day[$usr_h+1][$usr_d][$usr_m][$usr_y];
echo '</a>';
 ?></b></font></td>
</tr>
  <tr>
    <td height="25" valign="top"><font class=title1><u><?php echo stripslashes($NXTsn); ?></u></font></td>
  </tr>
  <tr>
    <td valign="top"><div id="size13"><?php echo stripslashes($NXTsd); ?></div></td>
  </tr>
</table>
</div></td></tr></table></td></tr></table>
</td></tr>
</table>