<?php
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
  for ($x = 0 ; $x < count($theDays) ; $x++) {
	echo("<tr>");
    for ($y = 0 ; $y < count($theDays[$x]) ; $y++) {
      if ($theDays[$x][$y]!=0) { echo("<td style=\"min-height: 96px;\" width=\"128\" valign=\"top\" align=\"left\">"); } else { echo("<td width=\"100\" height=\"75\" valign=\"top\" align=\"left\" bgcolor=\"#DDDDDD\">"); }
      if ($theDays[$x][$y]!=0) { echo(strval($theDays[$x][$y]).'<br /><p align="center">No Slots Booked</p><p align="center"><input type="button" name="Book a Slot..." value="Book a Slot..." /></p>'); } else { echo('&nbsp;'); }
      echo("</td>");
    }
	echo("</tr>");
  }
  echo("</table>");
  //die(print_r($theDays,true)."\n");
?>