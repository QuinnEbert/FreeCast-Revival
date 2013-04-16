<?php
  
  function get_num_day_slots($Y,$m,$d)
  {
	  $results = mysql_query('SELECT * FROM `slot` WHERE `year`='.strval(intval($Y)).' AND `month`='.strval(intval($m)).' and `day`='.strval(intval($d)));
	  if ($results === false) return 'E';
	  return strval(mysql_num_rows($results));
  }
  
  $numDays = intval(date('t',time()));
  $weekNum = 0;
  for ($i = 1 ; $i <= $numDays ; $i++) {
    $thisDay = intval(date('w',mktime(0,0,0,intval(date('n',time())),$i,intval(date('Y',time())))));
	if ($i > 1 && $thisDay == 0) $weekNum++;
	$theDays[$weekNum][$thisDay] = $i;
	if ($i == 1) {
		for ($n = ($thisDay - 1) ; $n >= 0 ; $n--) {
			$theDays[$weekNum][$n] = 0;
		}
	} elseif ($i == $numDays) {
		for ($n = ($thisDay + 1) ; $n <= 6 ; $n++) {
			$theDays[$weekNum][$n] = 0;
		}
	}
  }
  
  function get_month_by_num($monthNum) {
	  $names = array(
	  	'unused',
		'January',
		'February',
		'March',
		'April',
		'May',
		'June',
		'July',
		'August',
		'September',
		'October',
		'November',
		'December'
	  );
	  $n = intval($monthNum);
	  return $names[$n];
  }
  
  $n = date('n',time());
  $Y = date('Y',time());
  if (isset($_GET['nnMnth']))
    $n = $_GET['nnMnth'];
  if (isset($_GET['nnYear']))
    $Y = $_GET['nnYear'];
  $F = get_month_by_num($n);
  
  $nxtYear = intval($Y);
  $nxtMnth = (intval($n)+1);
  if ($nxtMnth > 12) {
	  $nxtMnth  = 1;
	  $nxtYear += 1;
  }
  $prvYear = intval($Y);
  $prvMnth = (intval($n)-1);
  if ($prvMnth < 1) {
	  $prvMnth  = 12;
	  $prvYear -= 1;
  }
  $nxtMnth = strval($nxtMnth);
  $nxtYear = strval($nxtYear);
  $prvMnth = strval($prvMnth);
  $prvYear = strval($prvYear);
  
  $nxtLink = "?bo&nnMnth={$nxtMnth}&nnYear={$nxtYear}";
  $prvLink = "?bo&nnMnth={$prvMnth}&nnYear={$prvYear}";
  
  echo("<br /><br /><table align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"8\">");
  echo("<tr><td colspan=\"7\" valign=\"top\" align=\"center\">{$F}, {$Y}</td></tr>");
  
  echo('<tr>');
  echo('<td colspan="1" valign="middle" align="center">');
  if (date('F, Y',time())!="{$F}, {$Y}") {
	  echo('<a href="'.$prvLink.'">&lt;&lt;</a>');
  } else {
	  echo('&nbsp;&nbsp;');
  }
  echo('</td>');
  echo('<td colspan="5" valign="middle" align="center">&nbsp;&nbsp;</td>');
  echo('<td colspan="1" valign="middle" align="center"><a href="'.$nxtLink.'">&gt;&gt;</a></td>');
  echo('</tr>');
  
  echo("<tr><td width=\"100\" valign=\"top\" align=\"center\">Sunday</td>");
  echo("<td width=\"100\" valign=\"top\" align=\"center\">Monday</td>");
  echo("<td width=\"100\" valign=\"top\" align=\"center\">Tuesday</td>");
  echo("<td width=\"100\" valign=\"top\" align=\"center\">Wednesday</td>");
  echo("<td width=\"100\" valign=\"top\" align=\"center\">Thursday</td>");
  echo("<td width=\"100\" valign=\"top\" align=\"center\">Friday</td>");
  echo("<td width=\"100\" valign=\"top\" align=\"center\">Saturday</td></tr>");
  $fakeOut = 1;
  $onDayNr = 1;
  for ($x = 0 ; $x < count($theDays) ; $x++) {
	echo("<tr>");
    for ($y = 0 ; $y < count($theDays[$x]) ; $y++) {
      if ($theDays[$x][$y]!=0) { echo("<td style=\"min-height: 96px;\" width=\"128\" valign=\"top\" align=\"left\">"); } else { echo("<td width=\"100\" height=\"75\" valign=\"top\" align=\"left\" bgcolor=\"#DDDDDD\">"); }
      //if ($theDays[$x][$y]!=0 && $theDays[$x][$y]!=15) { echo(strval($theDays[$x][$y]).'<br />'./*'<p align="center">'.date('Y-m-').strval(str_pad($onDayNr,2,'0',STR_PAD_LEFT)).'</p>'.*/'<p align="center">No Slots Booked</p><p align="center"><form method="POST" action="?bo2"><input type="hidden" name="sel_date" value="'.date('Y-m-').strval(str_pad($onDayNr,2,'0',STR_PAD_LEFT)).'" /><input type="submit" name="Book a Slot..." value="Book a Slot..." /></form></p>'); } else { echo('&nbsp;'); $fakeOut++; }
      if ($theDays[$x][$y]!=0) {
          echo(strval($theDays[$x][$y]));
		  if ((date('F, Y',time())!="{$F}, {$Y}")||intval(strval($theDays[$x][$y]))>=intval(date('j'))) {
              echo('<br />'.'<p align="center">'.get_num_day_slots(date('Y'),date('m'),$onDayNr).' Slots Booked</p><p align="center"><form method="POST" action="?bo2"><input type="hidden" name="sel_date" value="'.date('Y-m-').strval(str_pad($onDayNr,2,'0',STR_PAD_LEFT)).'" /><input type="submit" name="Book a Slot..." value="Book a Slot..." /></form></p>');
		  } else {
			  echo('<p style="color: #F00; font-style: italic; text-align: center;">this<br />day&nbsp;has<br />already&nbsp;passed</p>');
		  }
      } else {
          echo('&nbsp;');
          $fakeOut++;
      }
	  //if ($theDays[$x][$y]!=0 && $theDays[$x][$y]==15) { echo(strval($theDays[$x][$y]).'<br />'./*'<p align="center">'.date('Y-m-').strval(str_pad($onDayNr,2,'0',STR_PAD_LEFT)).'</p>'.*/'<p align="center">2 Slots Booked</p><p align="center"><form method="POST" action="?bo2"><input type="hidden" name="sel_date" value="'.date('Y-m-').strval(str_pad($onDayNr,2,'0',STR_PAD_LEFT)).'" /><input type="submit" name="Book a Slot..." value="Book a Slot..." /></form></p>'); } else { echo('&nbsp;'); $fakeOut++; }
	  if ($theDays[$x][$y]!=0) $onDayNr++;
      echo("</td>");
    }
	echo("</tr>");
  }
  echo("</table>");
  //die(print_r($theDays,true)."\n");
?>