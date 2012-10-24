<?php
require'./includes/db.php';
if((!$_GET) && (!$_POST)) { 
include('np.php');
include('news.inc.php');
}
if(!defined('LOGGEDIN')) { echo ''; }
else {
	if($_POST['showedit']) {
	$sql = "UPDATE `user` SET 
	`show` = '".strip_tags(addslashes($_POST['showname']))."', 
	`allowemail` = '".strip_tags(addslashes($_POST['allowemail']))."', 
	`profilename` = '".strip_tags(addslashes($_POST['profilename']))."', 
	`age` = '".strip_tags(addslashes($_POST['age']))."', 
	`location` = '".strip_tags(addslashes($_POST['location']))."', 
	`description` = '".strip_tags(addslashes($_POST['description']))."', 
	`musicgenre` = '".strip_tags(addslashes($_POST['musicgenre']))."', 
	`profilename` = '".strip_tags(addslashes($_POST['profilename']))."', 
	`showdesc` = '".strip_tags(addslashes($_POST['showdesc']))."' 
	
	WHERE `id` = '".stripslashes($_POST['id'])."'  LIMIT 1 ;";

		@mysql_query($sql);
			}
	}
if(isset($_GET['ss'])) {

$sql = "SELECT `show`,`showdesc`,`id`,`allowemail`,`age`,`location`,`description`,`musicgenre`,`profilename` FROM `user` WHERE `nick` = '".$_COOKIE['MindSlap_Radio_u']."' LIMIT 1";
$result = @mysql_query($sql);
$sn = strip_tags(@mysql_result($result,0,0));
$sd = strip_tags(@mysql_result($result,0,1));
$em = strip_tags(@mysql_result($result,0,3));
$ya = strip_tags(@mysql_result($result,0,4));
$yl = strip_tags(@mysql_result($result,0,5));
$yd = strip_tags(@mysql_result($result,0,6));
$sm = strip_tags(@mysql_result($result,0,7));
$yn = strip_tags(@mysql_result($result,0,8));


$id = @mysql_result($result,0,2);
echo"<br><table align=\"center\" width=\"500\" cellpadding=\"1\" bgcolor=\"#19785A\" cellspacing=\"0\"><tr><td><table width=\"100%\" bgcolor=\"#E1EBEC\"><tr><td align=\"center\"><div id=\"size13\">";
echo"Amend your show information and your show name, these will be displayed<br> in public just before, and during your show.";
echo"</div></td></tr></table></td></tr></table><br>";
echo"<table align=\"center\" width=\"500\" cellpadding=\"0\" cellspacing=\"0\"><tr><td align=\"center\"><div id=\"size13\">";
include('si.php');
echo"</td></tr></table></div>";
}

elseif((isset($_GET['bo'])) || (isset($_GET['q'])) || (isset($_GET['unbook']))) {
include('booking.php');
}	
elseif(isset($_GET['guide'])) {
	include('gm.htm');
}
elseif(isset($_GET['how2'])) {
	include('g.htm');
}
elseif(isset($_GET['faq'])) {
	include('faq.htm');
}

elseif(isset($_GET['contact'])) {
	include('c.htm');
}

elseif((isset($_GET['register'])) || (isset($_POST['register']))) {
	include('adduser.php');
}

elseif((isset($_GET['taf'])) || (isset($_POST['taf']))) {
	include('taf.php');
}

elseif(isset($_GET['tos'])) {
	include('tos.htm');
}

elseif(isset($_GET['abo'])) {
	include('ab.htm');
}

elseif((isset($_GET['rst'])) || (isset($_POST['pwrst']))) {
	include('reset.php');
}

elseif((isset($_GET['pw'])) || (isset($_POST['pwrst2']))) {
	include('newpw.php');
}

elseif(isset($_GET['tk_me'])) {
	include('tkme.php');
}



elseif(isset($_GET['dj'])) {
$sql = "SELECT `show`,`showdesc`,`id`,`allowemail`,`age`,`location`,`description`,`musicgenre`,`profilename` FROM `user` WHERE `nick` = '".stripslashes($_GET['dj'])."' LIMIT 1";
$result = @mysql_query($sql);
if($sn = strip_tags(@mysql_result($result,0,0))) {
$sn = strip_tags(@mysql_result($result,0,0));
if($sn == "") { $sn = "?"; }
$sd = strip_tags(@mysql_result($result,0,1));
if($sd == "") { $sd = "?"; }
$em = strip_tags(@mysql_result($result,0,3));
if($em == "") { $em = "?"; }
$ya = strip_tags(@mysql_result($result,0,4));
if($ya == "") { $ya = "?"; }
$yl = strip_tags(@mysql_result($result,0,5));
if($yl == "") { $yl = "?"; }
$yd = strip_tags(@mysql_result($result,0,6));
if($yd == "") { $yd = "?"; }
$sm = strip_tags(@mysql_result($result,0,7));
if($sm == "") { $sm = "?"; }
$yn = strip_tags(@mysql_result($result,0,8));
if($yn == "") { $yn = "?"; }
include('prof.php');
	}
}

?>
	