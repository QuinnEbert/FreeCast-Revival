<p />
<table align="center" width="85%" border="1" cellspacing="1" cellpadding="4">
<tr>
<td valign="middle" align="center" bgcolor="#E1EBEC"><strong>Credits Administration</strong></td>
</tr>
<tr>
<td style="padding-top: 60px; padding-bottom: 60px;" valign="middle" align="center" bgcolor="#E1EBEC">
<?php
	if (isset($_GET['give_one'])) {
		$slotRes = mysql_query('SELECT `slots` FROM `user` WHERE `id`='.$_GET['id']);
		$slotRow = mysql_fetch_row($slotRes);
		$slotBit = explode('/',$slotRow[0],2);
		$newSlot = strval(intval($slotBit[0])).'/'.strval((intval($slotBit[1])+1));
		mysql_query('UPDATE `user` SET `slots`=\''.mysql_real_escape_string($newSlot).'\' WHERE `id`='.$_GET['id']);
	}
	if (isset($_GET['take_one'])) {
		$slotRes = mysql_query('SELECT `slots` FROM `user` WHERE `id`='.$_GET['id']);
		$slotRow = mysql_fetch_row($slotRes);
		$slotBit = explode('/',$slotRow[0],2);
		$newSlot = strval(intval($slotBit[0])).'/'.strval((intval($slotBit[1])-1));
		mysql_query('UPDATE `user` SET `slots`=\''.mysql_real_escape_string($newSlot).'\' WHERE `id`='.$_GET['id']);
	}
$results = mysql_query('SELECT `id`,`name`,`nick`,`email`,`slots` FROM `user`');
if ($results === false) {
	?>
    <p><strong>MySQL had some trouble:</strong><br /><br /><?php echo(mysql_error()); ?></p>
    <?php
}
?>
<p><em>Users &amp; their Credits:</em></p>

<table width="85%" align="center" border="1" cellspacing="1" cellpadding="4">
<tr>
<td align="center" valign="middle" width="15%" bgcolor="#19785A"><strong>Nickname</strong></td>
<td align="center" valign="middle" width="15%" bgcolor="#19785A"><strong>Real&nbsp;Name</strong></td>
<td align="center" valign="middle" bgcolor="#19785A"><strong>E-mail</strong></td>
<td align="center" valign="middle" width="8%" bgcolor="#19785A"><strong>Slots</strong></td>
<td align="left" valign="middle" width="15%" bgcolor="#19785A"><strong>Action</strong></td>
</tr>
<?php while ($currRow = mysql_fetch_assoc($results)) { ?>
<tr>
<td align="left" valign="middle" bgcolor="#E1EBEC"><?php echo($currRow['nick']); ?></td>
<td align="left" valign="middle" bgcolor="#E1EBEC"><?php echo($currRow['name']); ?></td>
<td align="left" valign="middle" bgcolor="#E1EBEC"><?php echo($currRow['email']); ?></td>
<td align="left" valign="middle" bgcolor="#E1EBEC"><?php echo($currRow['slots']); ?></td>
<td align="left" valign="middle" bgcolor="#E1EBEC">
  [<a href="?ca=action&give_one=yeah&id=<?php echo($currRow['id']); ?>" style="color: #00F;">Give&nbsp;Slot</a>] 
  [<a href="?ca=action&take_one=yeah&id=<?php echo($currRow['id']); ?>" style="color: #00F;">Take&nbsp;Slot</a>]
</td>
</tr>
<?php } ?>
</table>

<p><em>Credits Automatic Reset Options:</em></p>
<p style="color: #F00;"><em>Sorry, due to a bug, these options won't work until about February 28 2013.  I'm really sorry for the trouble.</em></p>

<table width="85%" align="center" border="1" cellspacing="1" cellpadding="4">
<tr>
<td align="center" valign="middle" width="15%" bgcolor="#19785A">
Reset every <input type="text" name="reset_every_many_days" value="30" />days.<br />
Give <input type="text" name="give_every_many_days" value="2" /> slots every time we reset.
</td>
</tr>
</table>

</td>
</tr>
</table>
