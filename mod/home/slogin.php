<?php
if (isset($_SESSION['username'])){
   //after_login();
   //echo "Welcome ".$_SESSION['fullname'];
}else{
   echo "
<h3 >Please Login</h3>
<br>
<br>
<center>";
echo before_login();
/*
echo "<br>";
echo "I forgot my <a href=\"javascript:open_page('system','reset_password')\">password</a><br>";
 */
echo "</center>";
}
?>
