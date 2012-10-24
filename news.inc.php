<?php
$result = mysql_query("SELECT * FROM `news` WHERE `status` =1 ORDER BY id DESC LIMIT 5");
for($i = 0; $i < mysql_num_rows($result); $i++) {
$id = mysql_result($result,$i,0);	
$date = mysql_result($result,$i,1);
$author = mysql_result($result,$i,2);
$title = mysql_result($result,$i,3);
$news = mysql_result($result,$i,4);
if($date != "") {
echo"<br><table align=\"center\" width=\"500\" cellpadding=\"1\" bgcolor=\"#19785A\" cellspacing=\"0\"><tr><td><table width=\"100%\" bgcolor=\"#E1EBEC\"><tr><td><font class=title1>";
echo $title; 
echo '</font><br><i><font class=sub>';
echo $date;
echo " by ";
echo $author;
echo '</font></td></tr><tr><td><div id=size13>';
echo $news;
echo"</div></td></tr></table></td></tr></table>";

}
}
echo"<br>";
?>