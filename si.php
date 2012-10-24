 <form method="post" action="">
  <table width="100%" border="0">
      <tr>
        <td valign="top"><strong>Options</strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">Allow FreeCast users to contact me </td>
        <td><select name="allowemail" id="allowemail">
          <option value="1"<?php if($em == 1) { echo "selected"; } ?>>Yes</option>
          <option value="0"<?php if($em == 0) { echo "selected"; } ?>>No</option>
        </select></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td valign="top"><strong>About You </strong><font size=1><br>
        </font></td>
        <td><font size=1>(this will be displayed in your public profile)</font></td>
      </tr>
      <tr>
        <td valign="top">Name:</td>
        <td><input name="profilename" type="text" id="profilename" value="<?php echo stripslashes($yn); ?>"  size="30"></td>
      </tr>
      <tr>
        <td valign="top">Age:</td>
        <td><input name="age" type="text" id="age" value="<?php echo stripslashes($ya); ?>"  size="8"></td>
      </tr>
      <tr>
        <td valign="top">Location:</td>
        <td><input name="location" type="text" id="location" value="<?php echo stripslashes($yl); ?>"  size="25"></td>
      </tr>
      <tr>
        <td valign="top">Description:</td>
        <td><textarea name="description" cols="57" rows="5" id="description"><?php echo stripslashes($yd); ?></textarea></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
      <td valign="top"><strong>About your Show</strong></td>
      <td>&nbsp;</td>
    </tr>
      <tr>
        <td valign="top">Show name:</td>
        <td><input name="showname" type="text"  size="60" value="<?php echo stripslashes($sn); ?>"></td>
      </tr>
      <tr>
        <td valign="top">Music Genre: </td>
        <td><input name="musicgenre" type="text" id="musicgenre" value="<?php echo stripslashes($sm); ?>" size="60"></td>
      </tr>
    <tr>
      <td valign="top">Show description:<br>
        <font size=1>First 40 chars will be displayed on main page.</font></td>
      <td><textarea name="showdesc" cols="57" rows="8"><?php echo stripslashes($sd); ?></textarea></td>
    </tr>
    <tr>
	
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Update"></td>
    </tr>
  </table>
  <input type="hidden" name="showedit" value="true">
  <input type="hidden" name="id" value="<?php echo $id; ?>">
  </form>