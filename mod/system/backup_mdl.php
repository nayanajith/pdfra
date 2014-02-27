<?php
$LOAD_DEFAULT_TOOLBAR=false;
$GLOBALS['MODEL']=array(
//-----------------KEY FIELDS OF THE MODEL----------------------
   'KEYS'=>array(
   ),
//--------------FIELDS TO BE INCLUDED IN FORM-------------------
//---------------THIS ALSO REFLECT THE TABLE--------------------
   'FORM'=>array(
	
   ),
//--------------FIELDS TO BE INCLUDED IN TOOLBAR----------------
   'TOOLBAR'=>array(
      /*
      "rid"=>array(
			"length"=>"100",
         "dojoType"=>"dijit.form.FilteringSelect",
			"required"=>"true",
			"label"=>"Group",
			"label_pos"=>"left",

         "onChange"=>'s_p_c_add("ok",fill_form,this.value);set_param(this.id,this.value)',
         "searchAttr"=>"label",
         "pageSize"=>"10",
         "store"=>"rid_store",

         "filter"=>null,
         "ref_table"=>s_t('role'),
         "order_by"=>'ORDER BY role_id DESC',
         "vid"=>array('role_id'),
      ),
       */
      "add"=>array(
         "dojoType"=>"dijit.form.Button",
			"label"=>"Create a backup",
			"label_pos"=>"left",
         "iconClass"=>get_icon_class('NewPage'),
         "showLabbel"=>'false',
         "onClick"=>'update_status_bar("OK","This operation will take some time please wait and be patient untill the system notifies the finish.");s_f_c_add("ok",reload_main);submit_form("add_backup")',
      ),
     "remove"=>array(
         "dojoType"=>"dijit.form.Button",
			"label"=>"Delete backup",
			"label_pos"=>"left",
         "iconClass"=>get_icon_class('Delete'),
         "showLabbel"=>'false',
         "onClick"=>'s_f_c_add("ok",reload_main);submit_form("del_backup")',
      ),
     "restore"=>array(
         "dojoType"=>"dijit.form.Button",
			"label"=>"Restore Database",
			"label_pos"=>"left",
         "iconClass"=>get_icon_class('Undo'),
         "showLabbel"=>'false',
         "onClick"=>'update_status_bar("OK","This operation will take some time please wait and be patient untill the system notifies the finish.");s_f_c_add("ok",reload_main);submit_form("res_backup")',
      ),
     "activate"=>array(
         "dojoType"=>"dijit.form.Button",
			"label"=>"Activate/Deactivate Database",
			"label_pos"=>"left",
         "iconClass"=>get_icon_class('Process'),
         "showLabbel"=>'false',
         "onClick"=>'s_f_c_add("ok",reload_main);submit_form("act_db")',
      ),
   ),
);

/**
 * List all the backup files in backup directory
 */

function list_backups(){
	$files = scandir(MOD_BACKUP);
   if($files){
		$files_=array();
      foreach($files as $file){
			$files_[$file]=filemtime(MOD_BACKUP . '/' . $file);
		}

		//Flag physical deleted files as deleted
	   $arr=exec_query("SELECT * FROM ".s_t('db_backup'),Q_RET_ARRAY);
		foreach($arr as $row){
			if(!in_array($row['file'],array_keys($files_))){
				$arr=exec_query("UPDATE ".s_t('db_backup')." SET `state`='DELETED'",Q_RET_NONE);
			}
		}

		$list='<center><table class="clean" border="1"><tr><th>File</th><th>Size</th><th>Backup Date/Time</th><th>Restored Date/Time</th><th>Deleted Date/Time</th><th>Restore Name</th><th>State</th><th>Active</th><th>Select to act on</th></tr>';

		//Print list of backups
	   $arr=exec_query("SELECT * FROM ".s_t('db_backup'),Q_RET_ARRAY);
		foreach($arr as $row){
			$size=hr_filesize(filesize(MOD_BACKUP . '/' . $row['file']));

         $list.="<tr><td><a href='".MOD_W_BACKUP."/".$row['file']."'>".$row['file']."</a></td><td>".$size."</td><td>".$row['backup_date']."</td><td>".$row['restore_date']."</td><td>".$row['delete_date']."</td><td>".$row['restore_name']."</td><td>".$row['state']."</td><td align='center'>".$row['active']."</td><td align='center'><input dojoType='dijit.form.CheckBox' type='checkbox' name='BACK#".$row['file']."'></td></tr>";

		}

		/*
	   arsort($files_);
		$list='<center><table class="clean" border="1"><tr><th>File</th><th>Size</th><th>Backup Date/Time</th><th>Restore Date/Time</th><th>Restore Name</th><th>Select to act on</th></tr>';
      foreach($files_ as $file => $date){
         if($file == '.' || $file == '..')continue;
			$size=hr_filesize(filesize(MOD_BACKUP . '/' . $file));
         $list.="<tr><td><a href='".MOD_W_BACKUP."/".$file."'>".$file."</a></td><td>".$size."</td><td>".date("M d Y H:i:s",$date)."</td><td>".date("M d Y H:i:s",$date)."</td><td>-</td><td align='center'><input dojoType='dijit.form.CheckBox' type='checkbox' name='BACK#$file'></td></tr>";
      }
		 */
      $list.='</table></center>';
   }
   return $list;
}

/**
 * Backup current database as to sql dump
 */
function backup_now(){
   $backup_file=$GLOBALS['DB']."_".date("j-n-Y_H:m:s").".sql.gz";
   $backup_path=MOD_BACKUP."/".$backup_file;
   log_msg("mysqldump -f -u".$GLOBALS['DB_USER']." -p".$GLOBALS['DB_PASS']."  ".$GLOBALS['DB']." | gzip > $backup_path");
   exec("mysqldump -f -u".$GLOBALS['DB_USER']." -p".$GLOBALS['DB_PASS']."  ".$GLOBALS['DB']." | gzip > $backup_path");
   if(file_exists($backup_path)){
		exec_query("INSERT INTO ".s_t('db_backup')."(`file`,`backup_by`,`backup_date`,`state`)VALUES('".$backup_file."',".$_SESSION['user_id'].",now(),'BACKEDUP')",Q_RET_NONE);
      return_status_json('OK','Backup successful!');
   }else{
      return_status_json('ERROR','Backup error!');
   }
}

/**
 * Delete the selected backups from disk
 */
function del_backup(){
   $msg="Deleted:";
   foreach($_REQUEST as $id => $value){
      $arr=explode('#',$id);
      if(sizeof($arr)==2 && $arr[0]=='BACK'){
         $msg.=$arr[1].",";
         $path=MOD_BACKUP."/".str_replace('_sql_gz','.sql.gz',$arr[1]);
         log_msg($path);
         $err=unlink($path);
			//exec_query("INSERT INTO ".s_t('db_backup')."(`file`,`backup_by`,`backup_date`,`state`)VALUES('".$backup_file."',".$_SESSION['user_id'].",now(),'BACKEDUP')",Q_RET_NONE);
      }
   }
   return_status_json('OK',$msg);
}

//Restoring the database backup
function res_backup(){
	$file="";
	foreach($_REQUEST as $id => $value){
		$arr=explode('#',$id);
		if(sizeof($arr)==2){
			switch($arr[0]){
			case 'BACK':
				$file=str_replace('_sql_gz','.sql.gz',$arr[1]);
				break;
			}
		}
	}

	//Create the database  to restore
	$db		=$GLOBALS['DB']."_".date("d_m_y__h_m_s");
	$con     = mysql_connect($GLOBALS['DB_HOST'],"root",DB_ROOT_PASS);
	$created = mysql_query("CREATE DATABASE ".$db,$con);
	$granted = mysql_query("GRANT ALL ON ".$db.".* TO ".$GLOBALS['DB_USER']."@localhost IDENTIFIED BY '".$GLOBALS['DB_PASS']."'",$con);


	//Restore the database
	$path=MOD_BACKUP."/".$file;
	exec("zcat ".$path." | mysql -u".$GLOBALS['DB_USER']." -p".$GLOBALS['DB_PASS']." ".$db);
	exec_query("UPDATE ".s_t('db_backup')." SET restore_name='$db',state='RESTORED',restore_date='now()' WHERE file='$file'",Q_RET_NONE);

	return_status_json('OK',"Database restored to $db !");
}

//Uploading the database backup file
function upl_backup(){
	$fid=$_REQUEST['file_id'];

	$up_arr=$_FILES[$fid."s"];
	$msg="";

	log_msg("type=".$up_arr["type"][0].",size=".$up_arr["size"][0].",err=".$up_arr["error"][0]);

	if(in_array(strtolower($up_arr["type"][0]),array('application/x-gzip','text/sql','txt/sql')) && $up_arr["size"][0] <= (500000*1024) && $up_arr["error"][0] <= 0){
		$type=pathinfo($up_arr["name"][0],PATHINFO_EXTENSION);
		//$date=date("d-m-y_h-m-s");
		//$file_name=$date."_".$fid.".".$type;
		$file_name=$up_arr["name"][0];
		$w_path=MOD_BACKUP."/".$file_name;
		$save_path=MOD_BACKUP."/".$file_name;
		$msg="file=".$w_path.",name=".$file_name.",type=".$type.",size=".$up_arr["size"][0].",err=".$up_arr["error"][0];

		//Check if the file already uploaded with maching md5 sum
		//$file_md5sum=md5_file($up_arr["tmp_name"][0]);
		exec_query("SELECT * FROM ".s_t('db_backup')." WHERE file='".$file_name."'",Q_RET_ARRAY);

		if(get_num_rows() == 0){
			move_uploaded_file($up_arr["tmp_name"][0],$save_path);
			exec_query("INSERT INTO ".s_t('db_backup')."(`file`,`upload_by`,`upload_date`,`state`)VALUES('".$file_name."',".$_SESSION['user_id'].",now(),'UPLOADED')",Q_RET_NONE);

			log_msg('File uploaded!');
			echo '"'.$msg.'ok=\'File uploaded!\'"';
		}else{
			echo "\"error='File previousely uploaded or exported!'\"";
			log_msg('File previousely uploaded or exported!');
		}
		return;
	}else{
		log_msg('File Type or size error!');
		echo "\"error='Type or size error'\"";
		return;
	}
}

//Activate restored backup
function activate_db(){
	$file="";
	foreach($_REQUEST as $id => $value){
		$arr=explode('#',$id);
		if(sizeof($arr)==2){
			switch($arr[0]){
			case 'BACK':
				$file=str_replace('_sql_gz','.sql.gz',$arr[1]);
				break;
			}
		}
	}

	//Find the active database
	$act=exec_query("SELECT restore_name FROM ".s_t('db_backup')." WHERE active",Q_RET_ARRAY);
	if(get_num_rows()==0){
		$act=$GLOBALS['DB'];
	}else{
		$act=$act[0]['restore_name'];
	}

	
	//If already acivated deactivate else enable while disabling other activations
	if(get_num_rows() > 0){
		exec_query("UPDATE ".s_t('db_backup')." SET active=0",Q_RET_NONE);

		exec_query("RENAME TABLE ".$GLOBALS['DB_ORIG'].".".s_t('db_backup')." TO ".$GLOBALS['DB'].".".s_t('db_backup')."_".date("d_m_y__h_m_s"),Q_RET_NONE);
		exec_query("CREATE TABLE ".$GLOBALS['DB_ORIG'].".".s_t('db_backup')." SELECT * FROM $act.".s_t('db_backup'),Q_RET_NONE);

		//Delete the active file
		if(file_exists(DB_ACTIVE)){
			unlink(DB_ACTIVE);
		}

		return_status_json('OK',"Deactivated ".$act."!");
	}else{
      //Get current activation information of the selected database
      $arr=exec_query("SELECT * FROM ".s_t('db_backup')." WHERE file='$file'",Q_RET_ARRAY);
      $arr=$arr[0];


      if(!isset($file) || $file == '' ){
         return_status_json('ERROR',"Restore not selected to activate!");
         return;
      }
		//Deactivate all the restored databases
		exec_query("UPDATE ".s_t('db_backup')." SET active=0",Q_RET_NONE);

		//Activate the sleected database
		exec_query("UPDATE ".s_t('db_backup')." SET active=1 WHERE file='$file'",Q_RET_NONE);

		//Rename the currently selected database's db_backup table
		exec_query("RENAME TABLE ".$arr['restore_name'].".".s_t('db_backup')." TO ".$arr['restore_name'].".".s_t('db_backup')."_".date("d_m_y__h_m_s"),Q_RET_NONE);

		//Create db_backup in the selected database with all the records in the previous table
		exec_query("CREATE TABLE ".$arr['restore_name'].".".s_t('db_backup')." SELECT * FROM $act.".s_t('db_backup'),Q_RET_NONE);

		return_status_json('OK',"Activated ".$arr['restore_name']." !");

		//Database configuration string
		$db_config      ="<?php 
\$GLOBALS['DB_ORIG'] = '".$GLOBALS['DB']."';
\$GLOBALS['DB']		= '".$arr['restore_name']."';
\$GLOBALS['DB_HOST'] = '".$GLOBALS['DB_HOST']."';
\$GLOBALS['DB_USER'] = '".$GLOBALS['DB_USER']."';
\$GLOBALS['DB_PASS'] = '".$GLOBALS['DB_PASS']."';
?>";

		//Write configuration to the file
		$file_handler = fopen(DB_ACTIVE, 'w');
		fwrite($file_handler, $db_config);
		fclose($file_handler);
	}
}

?>
