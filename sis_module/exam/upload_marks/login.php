<?php
$user = $_POST['user'];
$password = $_POST['password'];
$logout = $_POST['logout'];

echo"
<style>
.login_form{
}
.login_input{
	font-size:9px;
	height:18px;
	width:70px;
}
.login_input_btn{
	width:50px;
}
</style>
";
function before_login() {
	return "<FORM name=login method=post action='marks.php' class=form_ul>
	<ul class=form_ul>
	<li><label for=user>Username:</label><INPUT id=user type=text name=user ></li>
	<li><label for=password>Password:</label><INPUT type=password id=password name=password ></li>
	<li><INPUT type=submit value=Login name=loginBtn ></li>
	</ul>
	</FORM>";
}

function after_login() {
	return "<ul class=form_ul><FORM name=logout method=post action='marks.php'  class=form_ul>
	<li><INPUT type=submit value=logout name=logout ></li>
	<li><span>Welcome ".$_SESSION['full_name']." (".$_SESSION['permission'].")</span></li>";
}

if (isset($_SESSION['username'])) {
	if ($logout == "logout") {
		$_SESSION['username'] = null;
		$_SESSION['password'] = null;
		$_SESSION['permission'] = null;
		session_destroy();
	}
} else {
	if($user=='nayanajith' && $password =='123'){
		$_SESSION['username'] = $user;
		$_SESSION['password'] = md5($password);
		$_SESSION['permission'] = "examiner";
		$_SESSION['full_name'] = "Mr GKA Dias";
	}
	/*
	open_DB();
	$SQL = "SELECT * FROM users WHERE user_name LIKE '$user' AND passwd LIKE md5('$password')";
	$RESULT = mysql_query($SQL, $CONNECTION);
	$ROW = mysql_fetch_array($RESULT);
	if ($ROW) {
		session_start();
		$_SESSION['username'] = $ROW['user_name'];
		$_SESSION['permission'] = $ROW['permission'];
		$_SESSION['full_name'] = $ROW['full_name'];
	}
	close_DB();
	*/
}
?>
