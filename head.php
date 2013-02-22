	<br><div align="center">
<img src="logo.gif" alt="bobbyautodj.tbrnhost.com" align="middle">
</div><table bgcolor="#143B69" cellpadding="0" cellspacing="1" align="center" width="752">
			<tr><td>
		<table bgcolor="#19785A" cellpadding="0" cellspacing="0" align="center">
			<tr><td>
				<div id="nav">

	
<?php

echo "<div align=center><a href=\"http://bobbyautodj.tbrnhost.com:8000/listen.pls\"><b>Listen Now</b></a>";
echo "<div align=center><a href=?>Home</a>&nbsp;";
echo "<a href=?guide>Guide</a>&nbsp;";
echo "<a href=?contact>Contact</a>&nbsp;";
echo "<a href=?abo>About</a>&nbsp;";

if(cookiechk()) { //they are logged in!
//update ip address//
require'./includes/db.php';
$ip = $_SERVER['REMOTE_ADDR'];
$sql_query = "UPDATE `user` SET `lastip` = '".$ip."' WHERE `nick` = '".$_COOKIE['MindSlap_Radio_u']."' LIMIT 1 ;";
mysql_query($sql_query);
echo "<a href=?logout><b>Logout</b></a>";
}
else {
echo "<a href=?login><b>Login</b></a>&nbsp;<a href=?register><b>Register</b></a>";
}



?>
			</td>	
			<td>
	<?php
	
	// New C0de by ReDuX...

//Browser Detection Function...
function detect_browser () { 

if(eregi("(msie) ([0-9]{1,2}.[0-9]{1,3})", $_SERVER['HTTP_USER_AGENT'])) 
{  
  //If any IE return IE 
  $shit = "ie"; 

  if (eregi("(msie) ([5].[0-9]{1,3})", $_SERVER['HTTP_USER_AGENT'])) { 
  $shit = "ie5";  //ie5 detected
  } elseif (eregi("(msie) ([6].[0-9]{1,3})", $_SERVER['HTTP_USER_AGENT'])) { 
  $shit = "ie6";  //ie6 detected
}
/*   } elseif (eregi("(msie) ([4].[0-9]{1,3})", $_SERVER['HTTP_USER_AGENT'])) { 
  $shit = "ie4";  //ie4 detected
  } else { 
  $shit = "ie";  //duh...
  } 
  } elseif (eregi("(google)", $_SERVER['HTTP_USER_AGENT'])) { 
  $shit = "gb";  // google...
  } elseif (eregi("(MSProxy)", $_SERVER['HTTP_USER_AGENT'])) { 
  $shit = "msp"; // microsoft proxy...
  } elseif (eregi("(gecko)", $_SERVER['HTTP_USER_AGENT'])) { 
  $shit = "mz";  // Gecko/mozilla/netscape 7 etc...
  } else { 
  //Else = Netscape, Mozilla, Opera etc...
  $shit = "nn"; 

  (a-arse) removed unneccesary eregis, minimal effect on cpu but still, it's being used on every sinhle page
  
  */ 
  } 

      return $shit;
  //The end. Variable shit is the browser type.
} 
//End Browser Detection Function
/* The next bit is layed out in a really... REALLY obvious way.
   Pay attantion boys and girls, this is where we throw shit about... */
$wussat_then = detect_browser();
if($wussat_then == "ie5") { echo "<font color=white><a class=clock href=\"javascript:scalewindow('counter.php','Counter','width=190,height=50,scrollbars=0,resizable=0,')\" title=\"Click to open Show Countdown Timer...\">"; }
elseif($wussat_then == "ie6") { echo "<font color=white><a class=clock href=\"javascript:scalewindow('counter.php','Counter','width=190,height=50,scrollbars=0,resizable=0,')\" title=\"Click to open Show Countdown Timer...\">"; }
else { echo "<font color=white>"; }
// Should work for IE 5 and 6. The others will just get the time. can add Elseif's later for different browsers/works etc..
// End ReduX c0de
echo	date('H');
echo	':';
echo	date('i A');
echo	"&nbsp;".date('T');	
echo	"</font>";
	?></a>
	</td></tr>
		</table>
			<?php
			if(cookiechk()) { //they are logged in!
			echo '<table bgcolor="#143B69" width="750" cellpadding="0" cellspacing="0"><tr><td><div id="navr">';
			echo '<div align=center><a href=?ss>Edit Info</a>';
			echo '<a href=?pw>Edit Password</a>';
			echo '<a href=?taf>Refer-A-Friend</a>';
			echo '<a href=?bo><b>Book a Slot</b></a>';
			echo '<a href=?ca><b>Credits Admin</b></a>';


			echo '</div></td></tr></table>';
			}
			?>
	</td>

	</tr>
	<tr><td bgcolor="#ffffff">
	<table width="750"><tr><td valign="top" width="100%">
<?php

if($msg == "")  {
	
}
elseif(!isset($_POST['taf']))
{
echo"<br><table align=\"center\" width=\"500\" cellpadding=\"1\" bgcolor=\"#19785A\" cellspacing=\"0\"><tr><td><table width=\"100%\" bgcolor=\"#E1EBEC\"><tr><td align=\"center\"><div id=\"size13\">";
echo $msg;
echo"</div></td></tr></table></td></tr></table><br>";
}

if(isset($_GET['login']))  {
if(!$_POST) { 

echo"<br><table align=\"center\" width=\"500\" cellpadding=\"1\" bgcolor=\"#19785A\" cellspacing=\"0\"><tr><td><table width=\"100%\" bgcolor=\"#E1EBEC\"><tr><td align=\"center\"><div id=\"size13\">";
echo"Please login below:<br><a href=?rst>Cant remember your password?</a><br><a href=?register>Not registered yet?</a>";
echo"</div></td></tr></table></td></tr></table><br>";
echo"<table align=\"center\" width=\"500\" cellpadding=\"0\" cellspacing=\"0\"><tr><td align=\"center\"><div id=\"size13\">";
require "l.htm"; }
echo"</td></tr></table></div>";
}

?>
