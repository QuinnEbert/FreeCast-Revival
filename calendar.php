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

  echo("<br /><br /><table align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"8\">");
  echo("<tr><td colspan=\"7\" valign=\"top\" align=\"center\">".date('F, Y',time())."</td></tr>");
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
      if ($theDays[$x][$y]!=0) { echo(strval($theDays[$x][$y]).'<br />'./*'<p align="center">'.date('Y-m-').strval(str_pad($onDayNr,2,'0',STR_PAD_LEFT)).'</p>'.*/'<p align="center">'.get_num_day_slots(date('Y'),date('m'),$onDayNr).' Slots Booked</p><p align="center"><form method="POST" action="?bo2"><input type="hidden" name="sel_date" value="'.date('Y-m-').strval(str_pad($onDayNr,2,'0',STR_PAD_LEFT)).'" /><input type="submit" name="Book a Slot..." value="Book a Slot..." /></form></p>'); } else { echo('&nbsp;'); $fakeOut++; }
	  //if ($theDays[$x][$y]!=0 && $theDays[$x][$y]==15) { echo(strval($theDays[$x][$y]).'<br />'./*'<p align="center">'.date('Y-m-').strval(str_pad($onDayNr,2,'0',STR_PAD_LEFT)).'</p>'.*/'<p align="center">2 Slots Booked</p><p align="center"><form method="POST" action="?bo2"><input type="hidden" name="sel_date" value="'.date('Y-m-').strval(str_pad($onDayNr,2,'0',STR_PAD_LEFT)).'" /><input type="submit" name="Book a Slot..." value="Book a Slot..." /></form></p>'); } else { echo('&nbsp;'); $fakeOut++; }
	  if ($theDays[$x][$y]!=0) $onDayNr++;
      echo("</td>");
    }
	echo("</tr>");
  }
  echo("</table>");
  //die(print_r($theDays,true)."\n");
?>