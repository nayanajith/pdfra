<?php
session_start();

include 'config.php';
include 'login.php';

if(isset($_SESSION['views']))
$_SESSION['views'] = $_SESSION['views']+ 1;
else
$_SESSION['views'] = 1;

$_SESSION['host']=$_SERVER['REMOTE_ADDR'];

if (!isset($_SESSION['username'])){
   
}
?>
<!DOCTYPE center PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<head>
<title>Marks Uploading System</title>
<script type="text/javascript" src="spreadsheet.js"></script>
<link rel="stylesheet" href="spreadsheet.css" type="text/css"
   media=screen>

</head>
<body>

<fieldset style="width:300px;margin-left:auto;margin-right:auto;"><legend>LOGIN</legend>
<ul class=form_ul >

<?php
$login_array=array(
   "username"   => "Username",
   "password"   => "Password"
);

foreach ($login_array as $id => $label) {
   echo "<li>
   <label for=$id accesskey=". $id.substr(0,1) .">
   $label
   </label>
   <input type=text size=5 id=$id name=$id value='".(empty($_GET[$id]) ? "" : $_GET[$id])."'>
   </li>";
}
 
if (isset($_SESSION['username']))
    echo after_login();
else
    echo before_login();
?>
</ul>
</fieldset>

</body>
</html>
