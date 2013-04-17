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

  if (isset($_GET['slotFor'])&&isset($_GET['un'])) {
	  $insBits = explode('-',$_GET['slotFor'],4);
	  $n = mysql_real_escape_string($_GET['un']);
	  $Y = $insBits[0];
	  $m = $insBits[1];
	  $d = $insBits[2];
	  $H = $insBits[3];
	  //FIXME: workaround stupid bug:
	  if (!isset($_GET['ztUnbook'])) {
		  if ($Y!='0'&&$m!='0'&&$d!='0') {
			  mysql_query('INSERT INTO `slot` VALUES (\''.$n.'\','.$Y.','.$m.','.$d.','.$H.')');
			  mysql_set_user_slots($n,mysql_get_user_slots($n)+1);
		  }
	  }
	  if (isset($_GET['ztUnbook'])) {
		  if ($Y!='0'&&$m!='0'&&$d!='0') {
			  mysql_query('DELETE FROM `slot` WHERE `year`='.$Y.' AND `month`='.$m.' AND `day`='.$d.' AND `hour`='.$H);
			  mysql_set_user_slots($n,mysql_get_user_slots($n)-1);
		  }
	  }
  }

  function get_gregorian_hour_name($H) {
	  $hourNum = intval(strval(intval($H)));
	  if ($hourNum===0)
	  	return '12 AM';
	  if ($hourNum===12)
	  	return '12 PM';
	  if ($hourNum<12)
	  	return strval($hourNum).' AM';
	  return strval((($hourNum)-12)).' PM';
  }
  function get_slot_for_hour($Y,$m,$d,$H)
  {
	  $results = mysql_query('SELECT * FROM `slot` a left join user b on a.nick=b.nick WHERE a.`year`='.strval(intval($Y)).' AND a.`month`='.strval(intval($m)).' and a.`day`='.strval(intval($d)).' and a.`hour`='.strval(intval($H)));
	  if ($results === false) return false;
	  if ( ! mysql_num_rows($results) ) return false;
	  return mysql_fetch_assoc($results);
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
	
	echo "Welcome &quot;".$_COOKIE['MindSlap_Radio_u']."&quot;!<br />You have $left slot(s) left!<br>";
	if(!isset($msg)) {
		$msg = "You are allowed a maximum of $max slots each week.";
	}
	echo"</div></td></tr></table></td></tr></table><br>";
	echo"<table align=\"center\" width=\"100%\" cellpadding=\"1\" bgcolor=\"#19785A\" cellspacing=\"0\"><tr><td><table width=\"100%\" bgcolor=\"#E1EBEC\"><tr><td align=\"center\"><div id=\"size13\">";
	
	echo $_REQUEST['sel_date']."<br>";
	if(!isset($msg)) {
		$msg = "You are allowed a maximum of $max slots each week.";
	}
	echo"</div></td></tr></table></td></tr></table><br>";
	echo"<table align=\"center\" width=\"100%\" cellpadding=\"1\" bgcolor=\"#19785A\" cellspacing=\"0\"><tr><td><table width=\"100%\" bgcolor=\"#E1EBEC\"><tr><td align=\"center\">";
	?><table align="center" style="color: #000;" bgcolor="#E1EBEC" width="600" border="3" cellspacing="1" cellpadding="0">
  <!-- <tr>
    <td style="color: #FFF;" colspan="2" bgcolor="#19785A" align="center">February 15, 2013</td>
  </tr>  -->
  <?php
    $datePcs = explode('-',$_REQUEST['sel_date'],3);
	$Y = $datePcs[0];
	$m = $datePcs[1];
	$d = $datePcs[2];
  ?>
  <?php for ($hourNum = 0; $hourNum < 24; $hourNum++) { ?>
  <tr>
    <td width="20%" align="right"><?php echo(get_gregorian_hour_name($hourNum)); ?></td>
    <?php
	$hourInf = get_slot_for_hour($Y,$m,$d,$hourNum);
	if ($hourInf===false) {
		if (mysql_get_user_quota($_COOKIE['MindSlap_Radio_u'])>mysql_get_user_slots($_COOKIE['MindSlap_Radio_u'])) {
			$hourInf = '- NO SHOW SCHEDULED YET -<br /><strong><a style="color: #00F;" href="?bo2=action&sel_date='.$_REQUEST['sel_date'].'&slotFor='. strval(intval($Y)).'-'.strval(intval($m)).'-'.strval(intval($d)).'-'.strval(intval($hourNum)) .'&un='.$_COOKIE['MindSlap_Radio_u'].'">Click or tap to book slot!</a></strong>';
		} else {
			$hourInf = $showInf.'<strong><em>You cannot book anymore slots!</em></strong>';
		}
	} else {
		$showInf = '&quot;'.$hourInf['show'].'&quot; with '.$hourInf['name'].'<br />';
		/*if ($hourInf['nick']==$_COOKIE['MindSlap_Radio_u'] && mysql_get_user_quota($_COOKIE['MindSlap_Radio_u'])!=mysql_get_user_slots($_COOKIE['MindSlap_Radio_u'])) {
			$hourInf = $showInf.'<strong><a style="color: #00F;" href="?bo2=action&sel_date='.$_REQUEST['sel_date'].'&ztUnbook=OK&slotFor='. strval(intval($Y)).'-'.strval(intval($m)).'-'.strval(intval($d)).'-'.strval(intval($hourNum)) .'&un='.$_COOKIE['MindSlap_Radio_u'].'">Click or tap to unbook slot!</a></strong>';
		} else {
			if (mysql_get_user_quota($_COOKIE['MindSlap_Radio_u'])!=mysql_get_user_slots($_COOKIE['MindSlap_Radio_u'])) {
				$hourInf = $showInf.'<strong><em>You cannot unbook somebody else\'s time slot!</em></strong>';
			} else {
				$hourInf = $showInf.'<strong><em>You cannot book anymore slots!</em></strong>';
			}
		}*/
		if ($hourInf['nick']==$_COOKIE['MindSlap_Radio_u']) {
			$hourInf = $showInf.'<strong><a style="color: #00F;" href="?bo2=action&sel_date='.$_REQUEST['sel_date'].'&ztUnbook=OK&slotFor='. strval(intval($Y)).'-'.strval(intval($m)).'-'.strval(intval($d)).'-'.strval(intval($hourNum)) .'&un='.$_COOKIE['MindSlap_Radio_u'].'">Click or tap to unbook slot!</a></strong>';
		} else {
			$hourInf = $showInf.'<strong><em>You cannot unbook somebody else\'s time slot!</em></strong>';
		}
	}
	?>
    <td width="80%" align="center"><?php echo($hourInf); ?></td>
  </tr>
  <?php } ?>
</table><?php
	/*echo $msg;*/
	echo"</td></tr></table></td></tr></table>";	
	

/*if($_COOKIE['MindSlap_Radio_u']) { require 'table.php'; }*/
}
?>