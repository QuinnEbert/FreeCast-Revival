<?php

	function mysql_get_user_slots($n) {
		  $result = mysql_query('SELECT `slots` FROM `user` WHERE `nick`=\''.$n.'\'');
		  $theRow = mysql_fetch_row($result);
		  $thePts = explode('/',$theRow[0]);
		  return intval($thePts[0]);
	}
	function mysql_get_user_quota($n) {
		  $result = mysql_query('SELECT `slots` FROM `user` WHERE `nick`=\''.$n.'\'');
		  $theRow = mysql_fetch_row($result);
		  $thePts = explode('/',$theRow[0]);
		  return intval($thePts[1]);
	}
	function mysql_set_user_slots($n,$s) {
		  $result = mysql_query('UPDATE `user` SET `slots`=\''.$s.'/'.strval(mysql_get_user_quota($n)).'\' WHERE `nick`=\''.$n.'\'');
	}

//messages//
$error = "Generic Error Message";
$taken = "Sorry, that time slot is already taken";
$b_past  = "That time slot is in the past and can not be booked";
$u_past  = "That time slot is in the past and can not be unbooked";
$u_present  = "That time slot is in the present and can not be unbooked";
$u_success = "Your booking has been removed!";
$noslots = "You have already used your maximum number of slots!";
$booked = "That slot has been booked under your account!<br>";
$urpass = "Your password (for this timeslot) is: <b>";
$urpass2 = "</b><br>Don't forget it!";
$taken = "This show slot is already taken";
$byu = "by you!";
//
if(!isset($_COOKIE['MindSlap_Radio_u'])) { echo "You don't appear to be logged in"; }
else {
	require'./date.php';
    require'./includes/db.php';

	//get and calculate slots/slots remaining from database//
	$result = mysql_query("SELECT `email`,`slots` FROM `user` WHERE `nick` = '".$_COOKIE['MindSlap_Radio_u']."';");
	$email = mysql_result($result,0,0);
	$slots = mysql_result($result,0,1);
	$p = strpos($slots,"/");
	$used = substr($slots,0,$p);
	$max = substr($slots,$p + 1);
	$left = $max-$used;
	$slotz = $used."/".$max;
	
	//get day and password from database//
	$day = unserialize(mysql_result(mysql_query("SELECT `values` FROM  `book_2` WHERE `name` = 'day'"),0));
	$pass = unserialize(mysql_result(mysql_query("SELECT `values` FROM  `book_2` WHERE `name` = 'pass'"),0));
	
	if($_GET['unbook']) {
		
		if(strlen($_GET['unbook']) != 10) { $msg .= $error; }
		else {
		$usr_h = substr($_GET['unbook'],0,2);
		$usr_d = substr($_GET['unbook'],2,2);
		$usr_m = substr($_GET['unbook'],4,2);
		$usr_y = substr($_GET['unbook'],6,4);

			if($day[$usr_h][$usr_d][$usr_m][$usr_y] == $_COOKIE['MindSlap_Radio_u']) {

		if($usr_d == date('d')) {
			
			if($usr_h > date('H')) {
			$_unbook = TRUE;
			
			}
		}
		
		elseif($usr_d > date('d')) {
			$_unbook = TRUE;
		}
		elseif($usr_m > date('m')) {
			$_unbook = TRUE;
		}
		elseif($usr_y > date('Y')) {
			$_unbook = TRUE;
		}
		
		if($_unbook) {
		
						unset($day[$usr_h][$usr_d][$usr_m][$usr_y]);

						$used--;
						$left++;
						$slotz = $used."/".$max;
						$msg .= $u_success;
					}
		
			}
		}
	}

	elseif(isset($_GET['q'])) {

		$usr_h = substr($_GET['q'],0,2);
		$usr_d = substr($_GET['q'],2,2);
		$usr_m = substr($_GET['q'],4,2);
		$usr_y = substr($_GET['q'],6,4);

		if(!isset($day[$usr_h][$usr_d][$usr_m][$usr_y])) { //if it's not taken, take it!
			if(0 >= $left) { $msg .= $noslots; }	
			else {
			
			$used++;
			$left--;
			$slotz = $used."/".$max;
			$msg .= $booked;
			$l = rand(10,20);
			while ($I < $l) {
				if(rand(1,5) != 1) {
					$I++;
					$r = rand(97,122);
					$genpass .= chr($r);
				}
				else { $genpass .= "_"; }
			}
			$msg .= $urpass;
			$msg .= '<input type="text" size="40" style="text-align:center " value="';
			$msg .= $genpass;
			$msg .= '"></input>';
			$msg .= $urpass2;
				$msg .= '<br><a href=?unbook='.$usr_h.$usr_d.$usr_m.$usr_y.'>Cancel Booking?</a>';
			$pass[$usr_h][$usr_d][$usr_m][$usr_y] = $genpass;
			$day[$usr_h][$usr_d][$usr_m][$usr_y] = $_COOKIE['MindSlap_Radio_u'];
	}	
		}

	
	elseif(isset($day[$usr_h][$usr_d][$usr_m][$usr_y])) { 
		$result = mysql_query("SELECT `show`,`showdesc` FROM `user` WHERE `nick` = '".$day[$usr_h][$usr_d][$usr_m][$usr_y]."';");
		$msg .= $taken;
		if($day[$usr_h][$usr_d][$usr_m][$usr_y] == $_COOKIE['MindSlap_Radio_u']) { 
			$msg .= " ".$byu;
			$msg .= '<br>'.$urpass.'<input type="text" size="40" style="text-align:center " value="'.$pass[$usr_h][$usr_d][$usr_m][$usr_y].'"></input>'.$urpass2;
		$msg .= '<br><a href=?unbook='.$usr_h.$usr_d.$usr_m.$usr_y.'>Cancel Booking?</a>';
		
			 }
			 else {
		$x_sn = stripslashes(strip_tags(@mysql_result($result,0,0)));
		$x_sd = stripslashes(strip_tags(@mysql_result($result,0,1)));
		$msg .= '<br>Username: <b>';
		$msg .= '<a href="?dj=';
		$msg .= $day[$usr_h][$usr_d][$usr_m][$usr_y];
		$msg .= '">';
		$msg .= $day[$usr_h][$usr_d][$usr_m][$usr_y];
		$msg .= '</a>';
		$msg .='</b>';
		$msg .= '<br>Show name: <b>"'.$x_sn.'"</b><br>';
		$msg .= 'Description: <b>"'.$x_sd.'"</b>';
}
	
	}
	elseif(0 >= $left) { $msg .= $noslots; }	

}	
	
	if((isset($_GET['q'])) || (isset($_GET['unbook']))) {
		mysql_query("UPDATE `user` SET `slots` = '".$slotz."' WHERE `nick` = '".$_COOKIE['MindSlap_Radio_u']."';");
		mysql_query("UPDATE `book_2` SET `values` = '".serialize($day)."' WHERE `name` = 'day';");
		mysql_query("UPDATE `book_2` SET `values` = '".serialize($pass)."' WHERE `name` = 'pass';");
		
	}
	echo"<br>";
	echo"<table align=\"center\" width=\"100%\" cellpadding=\"1\" bgcolor=\"#19785A\" cellspacing=\"0\"><tr><td><table width=\"100%\" bgcolor=\"#E1EBEC\"><tr><td align=\"center\"><div id=\"size13\">";
	
	$left = strval(mysql_get_user_quota($_COOKIE['MindSlap_Radio_u'])-mysql_get_user_slots($_COOKIE['MindSlap_Radio_u']));
	$max = mysql_get_user_quota($_COOKIE['MindSlap_Radio_u']);
	
	echo "You have $left slot(s) left now!<br>";
	if(!isset($msg)) {
		$msg = "You are allowed a maximum of $max slots each week now.";
	}
	echo"</div></td></tr></table></td></tr></table><br>";	
	echo"<table align=\"center\" width=\"100%\" cellpadding=\"1\" bgcolor=\"#19785A\" cellspacing=\"0\"><tr><td><table width=\"100%\" bgcolor=\"#E1EBEC\"><tr><td align=\"center\"><div id=\"size13\">";
	include('calendar.php');
	/*echo $msg;*/
	echo"</div></td></tr></table></td></tr></table>";	
	

if($_COOKIE['MindSlap_Radio_u']) { require 'table.php'; }
}
?>