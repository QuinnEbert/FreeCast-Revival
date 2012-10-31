<?php
require('funk.php');
if(isset($_GET['logout'])) {
	logout();
	header("Location: index.php");
}	

if(($_REQUEST['u']) AND ($_REQUEST['p'])) {
	trigger_error("Unhashed pass was: ".$_REQUEST['p']);
	if(check($_REQUEST['u'],sha1($_REQUEST['p']))) {
		cookie($_REQUEST['u'],sha1($_REQUEST['p']));
		header("Location: index.php");
	} else {
		$msg = 'Username or Password Incorrect.';
	}
} elseif (($_POST['u']) || ($_POST['p'])) {
	$msg = 'Please fill in both the boxes.';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Freecast Radio - Public ShoutCast Server</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="style.css" />
	<meta content="Freecast is a free public access shoutcast server for anybody to use for free" name="description">
	<meta content="Freecast, Shoutcast, Public, Access, DJ, stream, live, action, free, gratis, server" name="keywords">
<!--	<script type="text/javascript">
	function scalewindow(wurl,wname,wsettings) {
   	 nwin=window.open(wurl,wname,wsettings);
   	}
  	 function AddText(strText){
    	document.getElementById("txtText").value += strText;
  	 }
	</script> -->
</head>
	<body>
<?php
require "head.php";
include("cont.php");
?>
		</td><td width="200" valign="middle" align="center">
		<a href="http://bobbyautodj.tbrnhost.com">Our Service</a>
		</td></tr><tr><td colspan="2" align="center" valign="middle"><br><br><br><a href="http://bobbyautodj.tbrnhost.com"><img src="ad.gif" alt="Mindslap Services" border="0" width="200"></a><br><br></tr></table>
			</td></tr>
		</table>
			</td></tr>
		</table>	
		<br><br>
	</body>
</html>