
<?
//mysql_query("UPDATE users SET mail = '0' WHERE username = '$_COOKIE[username]'");

$sql = mysql_query("SELECT * FROM im WHERE sentto = '$_COOKIE[MindSlap_Radio_u]' ORDER BY status") or die("error");

print("<meta http-equiv='refresh' content='300; url=msg.php' />
<table width='100%'>
<tr><td id=size13 colspan=3>From</td><td id=size13 colspan=3>Subject</td><td id=size13 colspan=3>Status</td><td id=size13 colspan=3>Delete&nbsp;<small><a href=\"javascript:checkAll()\" title=\"Mark all messages for deletion\">ALL</a></small></td></tr>
<form action=msg.php?page=delete method=post>
");
$num = mysql_num_rows($sql);
if($num==0)
{
print("<tr><td id=size13 colspan=20 align=center><font color=red>Your inbox is empty.</font></td></tr>");
}
else
{
print("<ol type=i>");
while($row = mysql_fetch_array($sql))
{
include("smilies.php");
print("<tr>
<td id=size13 colspan=3><li></li> $row[sender]</td>\n
<td id=size13 colspan=3><a href=msg.php?page=view&id=$row[id] title=\"View message '$row[subject]'\">$row[subject]</a></td>\n
<td id=size13 colspan=3>$row[status]</td>\n
<td id=size13 colspan=3><input type=checkbox name=check[] value=$row[id]></td>\n
</tr>\n\n
");
}
print("</ol>\n");
}
print("<tr><td id=size13 colspan=15 align=center><input type=submit value='Delete Marked'></td></tr>\n</form>\n</table>\n");




?>