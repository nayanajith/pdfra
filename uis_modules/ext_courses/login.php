<?php 
   if (isset($_SESSION['username'])){
   	//after_login();
		//echo "Welcome ".$_SESSION['fullname'];
		if($_REQUEST['page']=='postgraduate_apl' && $_REQUEST['module']=='registration'){
		}else{
			//header('Location: ?module=registration&page=postgraduate_apl');
			//include("payment.php");
			include("admission.php");
		}
				  
	}else{
		echo "
		<h3>Login</h3>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<center>
		<h4>If you are not applied yet please <a href='javascript:open_page(\"ext_courses\",\"registration\")'>apply</a> for the postgradate degree program</h4>
		<h4>Please enter your email as username and NIC number as the password to log in to the system if you are already applied</h4>";
		echo before_login();
		echo "<br/>";
		echo "</center>";
	}
?>
