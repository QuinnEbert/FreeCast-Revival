<?php
/* makepass.php
   Quinn "Zed" Ebert
   24 October 2012
   
   Used to generate an 18-character random password consisting of characters
   within the ASCII printable characters range. 
   
   This computer program code is provided to you under the agreement that you will not misrepresent the original author of this code, that you will not
   profit from the use of this code, and that you will not perform any illegal acts through the use of this code.  The original author, however, does
   reserve right to (legally) profit from this code and represent it in any manner he so choses. */ 
for ( $i = 1 ; $i <= 18 ; $i++ ) {
	echo(chr(rand(32,126)));
}
echo("\n");
