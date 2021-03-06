<?php

/*
This will include in to $GLOBALS['PAGE_GEN']
*/
$user    =null;
$password=null;
$logout  =null;

if(isset($_REQUEST['user']) && isset($_REQUEST['password'])){
   $user       = $_REQUEST['user'];
   $password   = $_REQUEST['password'];
}

if(isset($_REQUEST['logout'])){
   $logout     = $_REQUEST['logout'];
}

/**
 * Switch the user
 */
if(isset($_REQUEST['form']) && $_REQUEST['form']=='system' && isset($_REQUEST['action']) && $_REQUEST['action']=='switch_user' && isset($_REQUEST['user_id'])){
   $user=$_REQUEST['user_id'];
   $arr = exec_query("SELECT * FROM ".$GLOBALS['TBL_LOGIN']['table']." WHERE user_id='$user'",Q_RET_ARRAY);
   $row=$arr[0];

   foreach($GLOBALS['TBL_LOGIN'] as $key => $value){
      if(isset($row[$value])){
         $_SESSION[$key]   = $row[$value];
      }
   }
   $_SESSION['loged_module']    = MODULE;

   //will override by user theme and layout
   $group_layout_theme=exec_query("SELECT layout,theme,file_prefix FROM ".s_t('role')." WHERE role_id='".$_SESSION['role_id']."'",Q_RET_ARRAY);

   if(!is_null($group_layout_theme[0]['theme']) && $group_layout_theme[0]['theme'] != "" && $group_layout_theme[0]['theme'] != "NULL"){
      $_SESSION['THEME']=$group_layout_theme[0]['theme'];
   }

   if(!is_null($group_layout_theme[0]['layout']) && $group_layout_theme[0]['layout'] != "" && $group_layout_theme[0]['layout'] != "NULL"){
      $_SESSION['LAYOUT']=$group_layout_theme[0]['layout'];
   }

   if(!is_null($group_layout_theme[0]['file_prefix']) && $group_layout_theme[0]['file_prefix'] != "" && $group_layout_theme[0]['file_prefix'] != "NULL"){
      $_SESSION['FILE_PREFIX']=$group_layout_theme[0]['file_prefix'];
   }


   //get and set users theme and layout
   $user_layout_theme=exec_query("SELECT layout,theme FROM ".s_t('users')." WHERE user_id='".$_SESSION['user_id']."'",Q_RET_ARRAY);

   if(!is_null($user_layout_theme[0]['theme']) && $user_layout_theme[0]['theme'] != "" && $user_layout_theme[0]['theme'] != "NULL"){
      $_SESSION['THEME']=$user_layout_theme[0]['theme'];
   }

   if(!is_null($user_layout_theme[0]['layout']) && $user_layout_theme[0]['layout'] != "" && $user_layout_theme[0]['layout'] != "NULL"){
      $_SESSION['LAYOUT']=$user_layout_theme[0]['layout'];
   }

}

/*
If the login was done by a module and if the user try to escape out from it end the session
if(isset($_SESSION['login_module']) && $_SESSION['login_module'] != MODULE)
{
   $_SESSION['username']    = null;
   $_SESSION['permission'] = null;
   $_SESSION['fullname']    = null;
   $_SESSION['user_id']    = null;
   $_SESSION['login_module']    = null;
   session_destroy();
}
*/

function before_login() {
   d_r("dijit.form.ValidationTextBox");
   d_r("dijit.form.Form");
   d_r("dijit.form.Button");
   $page=PAGE;
   if(isset($GLOBALS['MOD_TBL_LOGIN']['target'])){
      $page=$GLOBALS['MOD_TBL_LOGIN']['target'];
   }


   $server=$_SERVER['HTTP_HOST'];

   //If the system behind proxy bind proxy address for the login form
   if(isset($GLOBALS['PROXY_HOSTS']) && is_array($GLOBALS['PROXY_HOSTS'])){
      foreach($GLOBALS['PROXY_HOSTS'] as $ip => $hostname){
         if($_SERVER['REMOTE_ADDR'] == $ip){
            $server=$hostname;
         }
      }
   }

   return '
   <div dojoType="dijit.form.Form" id="loginForm" jsId="loginForm" encType="multipart/form-data"
      action="'.$GLOBALS['AUTH_PROTOCOLE'].'://'.$server.$_SERVER['SCRIPT_NAME'].'/'.MODULE.'/'.$page.'" method="POST"
      onSubmit="if(loginForm.validate()){return true;}else{return false}"
      class="round bgBottom shadow"
      style="width:340px;padding:5px;border:1px solid silver;padding-top:20px;padding-bottom:20px;"
   >
'.(isset($_REQUEST['user'])?'<div style="padding:5px;color:red;">Invallid login please try again...</div>':"").'
            <input type="hidden" name="module" value="'.MODULE.'" >
            <input type="hidden" name="page" value="'.$page.'" >
            <table cellpadding=5 cellspacing=0 >
                <tr>
                    <td>
                        <label for="user"  style="font-size:18px">
                            Username:
                        </label>
                    </td>
                    <td>
                        <input type="text" id="user" name="user" required="true" style="color:black;width:60px;width:200px;font-size:18px;" 
                        dojoType="dijit.form.ValidationTextBox"
                        value="'.(isset($_REQUEST['user'])?$_REQUEST['user']:"").'"
                        >
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="password"  style="font-size:18px">
                            Password:
                        </label>
                    </td>
                    <td>
                        <input type="password" id="password" name="password" required="true" style="color:black;width:60px;width:200px;font-size:18px" 
                        dojoType="dijit.form.ValidationTextBox"
                        value="'.(isset($_REQUEST['password'])?$_REQUEST['password']:"").'"
                        >
                    </td>
                </tr>
                <tr>
                   <td colspan="2" align="center">
                        <button dojoType="dijit.form.Button" type="submit" name="loginBtn" value="Submit" style="font-size:16px" >
                            Login
                        </button>
                    </td>
                </tr>
            </table>

        </div>';   

/*Set redirect url to redirect page to previouse location*/
$_SESSION['REDIRECT']=gen_url($_SESSION['PREV_MODULE'],$_SESSION['PREV_PAGE']);
/*Unset prev module and pages from session*/
unset($_SESSION['PREV_PAGE']);
unset($_SESSION['PREV_MODULE']);
}

function after_login() {
   global $prev_page;
   global $module;
   if (!$prev_page)
   $prev_page = 'home';

   d_r("dijit.form.ValidationTextBox");
   d_r("dijit.form.Form");
   d_r("dijit.form.Button");
   d_r("dijit.form.FilteringSelect");

   //Super users have privilege to change the users to check whtat the user can do so they have special varialble to notify the system 
   //that he is a super user
   if($_SESSION['role_id']=='SUPER'){
      $_SESSION['SUPER_USER']=true;
   }

   //Admin users have privilege to change the users to check whtat the user can do so they have special varialble to notify the system 
   //that he is a  user
   if($_SESSION['role_id']=='ADMIN'){
      $_SESSION['ADMIN_USER']=true;
   }

   //User changing select box
   $user_changer="";
   if(isset($_SESSION['SUPER_USER']) && $_SESSION['SUPER_USER']){
      $_SESSION['fullname']='a <span style="color:red">Super user</span>';
      log_off();
      $arr=exec_query('SELECT username,user_id,role_id FROM '.s_t('users'),Q_RET_ARRAY,null,'user_id');
      log_on();
      $inner="";
      foreach($arr as $user_id => $row){
         $inner.="<option value='$user_id'>".$row['username']." (".$row['role_id'].")</option>";
      }
      //$inner=gen_select_inner($arr,'username',true);
      $user_changer="Switch user to: <select dojoType='dijit.form.FilteringSelect' value='".$_SESSION['user_id']."' style='width:180px' id='switch_user' onMouseOver='halt_page_reloading=false' onChange='switch_user(this.value);reload_page()'>$inner</select>";
   }elseif(isset($_SESSION['ADMIN_USER']) && $_SESSION['ADMIN_USER']){
      $_SESSION['fullname']='an <span style="color:red">Admin user</span>';
      log_off();
      $arr=exec_query('SELECT username,user_id,role_id FROM '.s_t('users'),Q_RET_ARRAY,null,'user_id');
      log_on();
      $inner="";
      foreach($arr as $user_id => $row){
         if($row['role_id'] == 'SUPER')continue;
         $inner.="<option value='$user_id'>".$row['username']." (".$row['role_id'].")</option>";
      }
      //$inner=gen_select_inner($arr,'username',true);
      $user_changer="Switch user to: <select dojoType='dijit.form.FilteringSelect' value='".$_SESSION['user_id']."' style='width:180px' id='switch_user' onMouseOver='halt_page_reloading=false' onChange='switch_user(this.value);reload_page()'>$inner</select>";
   }

   return "
   <div dojoType='dijit.form.Form' id='loginForm' jsId='loginForm' encType='multipart/form-data' 
   action='".gen_url()."' method='REQUEST' >
   <span>Loged in as ".$_SESSION['fullname']."</span>
   <button dojoType='dijit.form.Button' style='color:black;' type=submit name=logout value=logout>Logout</button><br>
   $user_changer
   </div>";
}

/*--------------------------destroy the session if expired--------------------*/
/*
if(isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 10)){
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
*/

$RESULT     =null;
$RESULT_ARR =null;
$LOGIN      =false;

if (isset($_SESSION['username'])){
   if ($logout == "logout") {

      exec_query("UPDATE ".s_t('users')." SET last_logout=CURRENT_TIMESTAMP,session_id=NULL WHERE username='".$_SESSION['username']."'", Q_RET_NONE);
      unset($_SESSION['username']);
      unset($_SESSION['permission']);
      unset($_SESSION['group']);
      unset($_SESSION['fullname']);
      unset($_SESSION['user_id']);
      unset($_SESSION['login_module']);
      session_destroy();

      //After logout take the user to home
      header('Location: '.gen_url('true','home','news',null));
   }
}elseif(isset($_REQUEST['loginBtn'])){
	//Log users activity
	act_log(null,null);


	//login database and other information can be configured modulewise 
	if(isset($GLOBALS['MOD_TBL_LOGIN'])){
		$GLOBALS['TBL_LOGIN']=$GLOBALS['MOD_TBL_LOGIN'];
		$_SESSION['login_module']    = MODULE;
	}

	//do externel database based authentication using custom database connection if requested in the configuration
	if(isset($GLOBALS['TBL_LOGIN']['db_host'])){
		$GLOBALS['CONNECTION'] = mysql_connect($GLOBALS['TBL_LOGIN']['db_host'], $GLOBALS['TBL_LOGIN']['db_user'], $GLOBALS['TBL_LOGIN']['db_password']);
		if(!mysql_select_DB($GLOBALS['TBL_LOGIN']['db'], $GLOBALS['CONNECTION'])){
			$db_avail=false;
		}
	}

	//Select the authenticatio mode based on user configuration
	$AUTH_MOD=$GLOBALS['AUTH_MOD'];
	$CFG    = exec_query("SELECT * FROM ".$GLOBALS['TBL_LOGIN']['table']." WHERE username='$user'", Q_RET_ARRAY);
	if(isset($CFG[0]) && isset($CFG[0]['auth_mod']) && !is_null($CFG[0]['auth_mod']) && $CFG[0]['auth_mod']!='AUTO'){
		$AUTH_MOD=$CFG[0]['auth_mod'];
	}

	//Check where the authentication from externel server
	switch($AUTH_MOD){
	case 'LDAP':

		//Getting user information for the given ldap user from the given login table
		$SQL = "SELECT * FROM ".$GLOBALS['TBL_LOGIN']['table']." WHERE ldap_user_id='$user' AND status != 'DISABLED'";
		$RESULT_ARR    = exec_query($SQL, Q_RET_ARRAY);

		//Connect to the ldap server and authenticate the user
		$ldap    =    ldap_connect($GLOBALS['LDAP']['SERVER'],$GLOBALS['LDAP']['PORT']);
		ldap_set_option($ldap,LDAP_OPT_PROTOCOL_VERSION,3);
		ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

		//If there is a user for the given ldap user id check the password from the ldap server
		if (isset($RESULT_ARR[0])) {
			//If bind successful that means authenticated
			if(!ldap_bind($ldap,"CN=$user,".$GLOBALS['LDAP']['USER_RDN'], $password)){
				//If the ldap authentication faild make the RESULT=false so it will considered as un authorized
				$RESULT_ARR=null;
				$LOGIN=false;
			}else{
				$LOGIN=true;
				ldap_unbind($ldap);
			}
		}else{
			//If bind successful that means authenticated
			if(ldap_bind($ldap,"CN=$user,".$GLOBALS['LDAP']['USER_RDN'], $password)){
				//Insert user since the user does not exists
				ldap_bind($ldap, "CN=".$GLOBALS['LDAP']['USER'].",".$GLOBALS['LDAP']['ADMIN_RDN'], $GLOBALS['LDAP']['PASS']);
				$attr = array('mail','displayName');
				$result=ldap_search($ldap,$GLOBALS['LDAP']['USER_RDN'] , "(&(objectClass=person)(cn=$user))",$attr);
				if(!is_null($result)){
					$entries = ldap_get_entries($ldap, $result);
					if($entries['count'] > 0){
						exec_query("INSERT INTO ".$GLOBALS['TBL_LOGIN']['table']."(`username`,`first_name`,`ldap_user_id`,`role_id`,`email`,`status`,`note`)values('$user','".$entries[0]['displayname'][0]."','$user','USER','".$entries[0]['mail'][0]."','ENABLED','Auto registered')",Q_RET_NONE);
					}
				}

				//After adding the ldap user  go through the authentication process
				$RESULT_ARR    = exec_query($SQL, Q_RET_ARRAY);
				$LOGIN=true;
				ldap_unbind($ldap);
			}

			//Unbind the ldap conneciton
			ldap_unbind($ldap);
		}
		break;
	case 'PASSWD':
		//TODO:authenticate using system password file
		break;
	case 'MYSQL':
	default:
		//Filters can be applied to extract only the relavant category
		$filter=" AND status != 'DISABLED'";
		if(isset($GLOBALS['TBL_LOGIN']['filter']) && $GLOBALS['TBL_LOGIN']['filter']!=''){
			$filter.=" AND ".$GLOBALS['TBL_LOGIN']['filter'];
		}

		//Login using native database from mysql user database
		if(isset($GLOBALS['TBL_LOGIN']['md5']) && $GLOBALS['TBL_LOGIN']['md5']=='false'){
			$password=$password;
		}else{
			$password=md5($password);
		}
		$SQL = "SELECT * FROM ".$GLOBALS['TBL_LOGIN']['table']." WHERE ".$GLOBALS['TBL_LOGIN']['username']."='$user' AND ".$GLOBALS['TBL_LOGIN']['password']."='".$password."' $filter";
		$RESULT_ARR   = null;

		//If the database is external then do not reconnect inside exec_auery function
		if(isset($GLOBALS['TBL_LOGIN']['db_host'])){
			$RESULT_ARR    = exec_query($SQL, Q_RET_ARRAY,null,null,null,true);
		}else{
			$RESULT_ARR    = exec_query($SQL, Q_RET_ARRAY);
		}

		break;
	}

	//Login/Logout attempts
	if(isset($RESULT_ARR[0])){
		$LOGIN=true;   
		exec_query("UPDATE ".s_t('users')." SET last_login=CURRENT_TIMESTAMP,failed_logins=0,session_id='".session_id()."' WHERE username='".$user."'", Q_RET_NONE);
	}else{
		exec_query("UPDATE ".s_t('users')." SET failed_logins=failed_logins+1 WHERE username='".$user."'", Q_RET_NONE);
		$LOGIN=false;   
		$RESULT_ARR=null;
	}
}
   
//If login successful $RESULT should be true then set the session variables
if ($LOGIN) {
	$ROW=$RESULT_ARR[0];
	foreach($GLOBALS['TBL_LOGIN'] as $key => $value){
		if(isset($ROW[$value])){
			$_SESSION[$key]   = $ROW[$value];
		}
	}
	$_SESSION['loged_module']    = MODULE;

	//get and set group theme and layout
	//will override by user theme and layout
	$group_layout_theme=exec_query("SELECT layout,theme,file_prefix FROM ".s_t('role')." WHERE role_id='".$_SESSION['role_id']."'",Q_RET_ARRAY);

	if(!is_null($group_layout_theme[0]['theme']) && $group_layout_theme[0]['theme'] != "" && $group_layout_theme[0]['theme'] != "NULL"){
		$_SESSION['THEME']=$group_layout_theme[0]['theme'];
	}

	if(!is_null($group_layout_theme[0]['layout']) && $group_layout_theme[0]['layout'] != "" && $group_layout_theme[0]['layout'] != "NULL"){
		$_SESSION['LAYOUT']=$group_layout_theme[0]['layout'];
	}

	if(!is_null($group_layout_theme[0]['file_prefix']) && $group_layout_theme[0]['file_prefix'] != "" && $group_layout_theme[0]['file_prefix'] != "NULL"){
		$_SESSION['FILE_PREFIX']=$group_layout_theme[0]['file_prefix'];
	}

	//get and set users theme and layout
	$user_layout_theme=exec_query("SELECT layout,theme FROM ".s_t('users')." WHERE user_id='".$_SESSION['user_id']."'",Q_RET_ARRAY);

	if(!is_null($user_layout_theme[0]['theme']) && $user_layout_theme[0]['theme'] != "" && $user_layout_theme[0]['theme'] != "NULL"){
		$_SESSION['THEME']=$user_layout_theme[0]['theme'];
	}

	if(!is_null($user_layout_theme[0]['layout']) && $user_layout_theme[0]['layout'] != "" && $user_layout_theme[0]['layout'] != "NULL"){
		$_SESSION['LAYOUT']=$user_layout_theme[0]['layout'];
	}

	//After login redirect to news page
	header('Location: '.gen_url(true,'home','news',null));
}else{
	//echo "<div style='float:left;padding:5px;color:brown;'>Invallid login please try again...</div>";
	//echo "<script type='text/javascript' language=javascript>alert('Invalid login please try again...');</script>";
}

function logout_idle_users(){
	exec_query("UPDATE ".s_t('users')." SET last_logout=CURRENT_TIMESTAMP,session_id=NULL WHERE ((NOW() - last_activity) >= ".SESSION_DURATION.") OR ISNULL(last_activity)",Q_RET_NONE);
}
?>
