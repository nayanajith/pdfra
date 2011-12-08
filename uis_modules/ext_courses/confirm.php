<?php
if((isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") || isset($_SESSION['user_id']) == false ){

echo "Please login to the system <a href='javascript:open_page(\"".MODULE."\",\"login\")'>HERE</a>";
}else{
include A_CLASSES."/data_entry_class.php";
$super_table		='confirm';
$keys					=array('reg_id');
$key1					='reg_id';
//$grid_array			=array('registration_no','NIC','email_1');
//$grid_array_long	=array('registration_no','NIC','first_name','status');

$table				=$GLOBALS['MOD_P_TABLES']['reg'];
$formgen 			=null;
if(isset($_REQUEST['reg_id'])){
	$formgen 		= new Formgenerator($table,$keys,$super_table,$_REQUEST['reg_id']);
}else{
   $table = $GLOBALS['MOD_P_TABLES']["reg"];
   $query = "SELECT * FROM ".$table." WHERE student_id = '". $_SESSION['user_id']."' AND session_id = '".$_REQUEST['sid']."'" ;
   $res = exec_query($query,Q_RET_MYSQL_RES);
   $reg = mysql_fetch_array($res);

   if($reg['reg_id'] != ""){
      $formgen 		= new Formgenerator($table,$keys,$super_table,$_REQUEST['reg_id']);
   }else{
      $_REQUEST['reg_id'] = $reg['reg_id'];
      $formgen 		= new Formgenerator($table,$keys,$super_table,null);
   }
	
}

//$formgen 		= new Formgenerator($table,$keys,$super_table,null);


$help_file			=$super_table."_help.php";
$modif_file			=$super_table."_modif.php";
$filter_string		="";

/*Extract filter according to the filter_id in request string*/
if(isset($_REQUEST['filter_name']) && $_REQUEST['filter_name'] != ''){
	$filter_string=$formgen->ret_filter($_REQUEST['filter_name'],$GLOBALS['MOD_S_TABLES']['filter']);
	log_msg('filter',$filter_string);
}

/*generate csv with column headers*/
if(isset($_REQUEST['data']) && $_REQUEST['data']=='csv'){
	$filter_str=$filter_string!=""?" WHERE ".$filter_string:"";
	$query="";
	if(isset($_REQUEST['form']) && $_REQUEST['form']=='grid'){
		$fields=implode(",",$grid_array);
		$query="SELECT $fields FROM ".$table.$filter_str;
	}else{
      include $modif_file;
		$columns=array();
		foreach($fields as $k => $v){
			if(isset($v['custom']) && $v['custom']=='true'){
			}else{
				$columns[]=$k;
			}
		}
		$comma="";


		$fields=implode(",",$columns);
		$query="SELECT $fields FROM ".$table.$filter_str;
	}
	
	$csv_file= $table.".csv";
	db_to_csv_nr($query,$csv_file);
	return;
}

if(isset($_REQUEST['form'])){
	switch($_REQUEST['form']){
      case 'main':
			if(isset($_REQUEST['action'])){
			  
				switch($_REQUEST['action']){
				 case 'add':
					if($formgen->add_record()){
					   /*
						$_SESSION['sid']	= $_REQUEST['session_id'];
						$_SESSION['reg_id'] = $_REQUEST['reg_id'];*/
					}
					return;
				 break;
				 case 'modify':
					if($formgen->modify_record()){
					
					 /*  $_SESSION['sid']	=$_REQUEST['session_id'];
						$_SESSION['reg_id'] = $_REQUEST['reg_id'];*/
					}
				 break;
				 case 'delete':
					return $formgen->delete_record();
				 break;

				}	
			}else{
				if(isset($_REQUEST['data'])&&$_REQUEST['data']=='json'){
					if(isset($_REQUEST['id'])){
						$formgen->xhr_form_filler_data($_REQUEST['id']);
					}else{
						$formgen->xhr_filtering_select_data(null,null,$filter_string);
					}
				}
			}
		break;
		case 'filter':
			if(isset($_REQUEST['action'])){
				switch($_REQUEST['action']){
				 case 'add':
					return $formgen->add_filter($GLOBALS['MOD_S_TABLES']['filter']);
				 break;
				 case 'modify':
					return $formgen->modify_filter($GLOBALS['MOD_S_TABLES']['filter']);
				 break;
				 case 'delete':
					return $formgen->delete_filter($GLOBALS['MOD_S_TABLES']['filter']);
				 break;

				}	
			}else{
				if(isset($_REQUEST['data'])&&$_REQUEST['data']=='json'){
					if(isset($_REQUEST['id'])){
						$formgen->xhr_filter_filler_data($_REQUEST['id']);
					}else{
						$filter_string.="table_name='".$table."'";
						$formgen->xhr_filtering_select_data($GLOBALS['MOD_S_TABLES']['filter'],'filter_name',$filter_string);
					}

				}
			}
		break;
		case 'grid':
			//$json_url=$formgen->gen_json($grid_array_long,$filter_string,false);
			echo $formgen->gen_data_grid($grid_array_long,null,$key1);
			$formgen->filter_selector();
		break;
		case 'select_filter':
			$formgen->xhr_filtering_select_data($GLOBALS['MOD_S_TABLES']['filter'],'filter_name',"table_name='".$table."'");
		break;
	}
}else{

	if($GLOBALS['LAYOUT'] == 'pub'){
      if((isset($_REQUEST['reg_id']) && $_REQUEST['reg_id'] == "") || isset($_REQUEST['reg_id']) == false ){


	      echo "<h1>Confirmation form</h1>";
         echo "<hr style='border:1px solid silver;'/>";
         echo '<table> <tr><td width = 70% valign = "top" >';
	      echo "<table width=100%><tr><td style='vertical-align:top;valign:top' width=100%>";
	      echo "Please select a payment method and click confirm if u wish to attend this session. If u do not confirm your attendance a place cannot be reserved for you. However, you may apply at a later date given that there are still places available";
	      echo "<hr style='border:1px solid silver;'/>";
	   }else{
	      echo "<h1>Payment Selection</h1>";
         echo "<hr style='border:1px solid silver;'/>";
         echo '<table> <tr><td width = 70% valign = "top" >';
	      echo "<table width=100%><tr><td style='vertical-align:top;valign:top' width=100%>";
	      echo "Please select a payment method and click Make payment to proceed with your payment.";
	      echo "<hr style='border:1px solid silver;'/>";
	   }
	   	   
	   if(isset($_REQUEST['sid'])){
	      $sid = $_REQUEST['sid'];	   
	   }
	   
	   if(isset($_REQUEST['reg_id'])){
	   $table = $GLOBALS['MOD_P_TABLES']["reg"];
      $query = "SELECT * FROM ".$table." WHERE reg_id = '". $_REQUEST['reg_id']."'" ;
      $res = exec_query($query,Q_RET_MYSQL_RES);
      $row = mysql_fetch_array($res);
      $sid = $row['session_id']; 
	   }
	  
	   
	   $table = $GLOBALS['MOD_P_TABLES']["schedule"];
      $query = "SELECT * FROM ".$table." WHERE session_id = '". $sid."'" ;
      $res = exec_query($query,Q_RET_MYSQL_RES);
      $row = mysql_fetch_array($res);


	   $table2 = $GLOBALS['MOD_P_TABLES']["course"];
      $query2 = "SELECT * FROM ".$table2." WHERE course_id = '". $row['course_id']."'" ;
      $res2 = exec_query($query2,Q_RET_MYSQL_RES);
      $row2 = mysql_fetch_array($res2);
      echo '<p>Course Name: '.$row2['long_name'].' ('.$row2['short_name'].')</p>';
      echo '<p>Conducted by: '.$row2['lecturer'].'</p>';
      echo '<p> Session name: '.$row['session_name'].'</p>';
      echo '<p> Held from '.$row['start_date'].' to '.$row["end_date"] .'</p>';      
      echo "<hr style='border:1px solid silver;'/>";
      	   
		$_SESSION['sid'] =  $sid;
		echo $formgen->gen_form(false,false);
	}else{
		echo $formgen->gen_form(true,true);
		echo $formgen->gen_filter();
	}
	echo "
		<script language='javascript'>
			function grid(){
				url='".gen_url()."&form=grid';
				open(url,'_self');
			}
		</script>
	";
	//$json_url=$formgen->gen_json($grid_array,$filter_string,false,null);
if($GLOBALS['LAYOUT'] != 'pub'){
	echo "</td><td width=40% style='vertical-align:top;valign:top'>";
	echo $formgen->gen_data_grid($grid_array,null,$key1);
	echo "</td></tr></table>";
}else{
   d_r('dijit.form.Button');
		echo "</td><td width=40% style='vertical-align:top;valign:top;'>";
		
		echo "</td></tr></table>";


	if(isset($_REQUEST['reg_id'])){
		echo "<div align='right' >
		<button dojoType='dijit.form.Button' type='button' name='loginBtn' onClick=\"submit_form('modify','".MODULE."','payment')\">Make Payment&nbsp;&raquo;</button>
		</div>";
	}else{
		echo "<div align='right'>
		<button dojoType='dijit.form.Button' type='button' name='loginBtn' onClick=\"submit_form('add','".MODULE."','payment')\">Confirm&nbsp;&raquo;</button>
		</div>";

	}
echo "</td><td valign = 'top'  style = 'border-left:1px solid silver'>";
echo '<h4>Course Application procedure</h4>';
echo "<ol>
		<li>Find a course that you are interested in completing from the <a href='javascript:open_page(\"".MODULE."\",\"courses\")'>Find Courses</a> Page</li>
		<li>Once you have found such a course click on the Apply button next to it to go to the course page</li>
		<li>In the course page, Apply for a session which you are able to attend. The available sessions are displayed at the bottom of that page</li>
		<li>Then you must confirm your attendance by selecting a payment method. Note that unless you confirm this, your place will not be reserved</li>
		<li>Once you have confirmed, you are then able to pay either online or offline</li>
		<li>If you pay online, your place will be confirmed as soon as the payment goes through</li>
		<li>If you pay offline, your place will be confirmed when the payment has been recieved. Until such time, the status of your application will be set to 'PENDING' </li>
			</ol>";
echo "</td></tr></table>";

}

$formgen->filter_selector();

//generate help tips 
include $help_file;
$formgen->set_help_tips($help_array);
/*
echo "<script language='javascript'>";
echo $formgen->param_setter();
echo "</script>";
*/
}
}
?>
