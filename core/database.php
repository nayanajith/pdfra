<?php
/*
Tables of the system
*/
$system_tables=array(
   'program'         =>'program',          
   'users'           =>'users',              
   'role'            =>'role',              
   'permission'      =>'permission',              
   'base_data'       =>'base_data',         
   'filter'          =>'filter',         
   'news'            =>'news',         
   'db_backup'       =>'db_backup',         
   'log'             =>'log',
   'user_doc'        =>'user_doc',              
);

$GLOBALS['S_TABLES']=$system_tables;

//Custom log file for sql only log entries
define('SQL_LOG','sql');

/*
 * Database connection and disconnection
 */
function opendbi($DB=null) {
	//Check and load db_active.php
	if (file_exists(DB_ACTIVE)){
		include(DB_ACTIVE);
	}

   $DB=$DB==null?$GLOBALS['DB']:$DB;
   $db_avail=true;

   switch($GLOBALS['DB_TYPE']){
   case 'mssql':
      $GLOBALS['CONN_I'] = mssql_connect($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASS']);
      if(!mssql_select_DB($DB, $GLOBALS['CONN_I'])){
         $db_avail=false;
      }
   break;
   default:
      $GLOBALS['CONN_I'] = @mysqli_connect($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASS'],$DB);
      /*
      if(!@mysqli_select_DB($DB, $GLOBALS['CONN_I'])){
         $db_avail=false;
      }
       */
   break;
   }
   return $db_avail;
}

/*
 * Database connection and disconnection
 */
function opendb($DB=null) {

	//Check and load db_active.php
	if (file_exists(DB_ACTIVE)){
		include(DB_ACTIVE);
	}

   $DB=$DB==null?$GLOBALS['DB']:$DB;
   $db_avail=true;

   switch($GLOBALS['DB_TYPE']){
   case 'mssql':
      $GLOBALS['CONNECTION'] = mssql_connect($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASS']);
      if(!mssql_select_DB($DB, $GLOBALS['CONNECTION'])){
         $db_avail=false;
      }
   break;
   default:
      $GLOBALS['CONNECTION'] = @mysql_connect($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASS'],$DB);
      if(!@mysql_select_DB($DB, $GLOBALS['CONNECTION'])){
         $db_avail=false;
      }
   break;
   }
   return $db_avail;
}
/*
 * Disconnect from the database
 */
function closedbi() {
   switch($GLOBALS['DB_TYPE']){
   case 'mssql':
      mssql_close($GLOBALS['CONNECTION']);
   break;
   default:
      mysqli_close($GLOBALS['CONNECTION']);
   break;
   }
}


/*
 * Disconnect from the database
 */
function closedb() {
   switch($GLOBALS['DB_TYPE']){
   case 'mssql':
      mssql_close($GLOBALS['CONNECTION']);
   break;
   default:
      mysql_close($GLOBALS['CONNECTION']);
   break;
   }
}

/*
 * connect ta custom database
 */
function opendb2($DB) {
   opendb($DB);
}

/*
 * Execute queries through this function to grab total handl over queris
 Requestabble types to be returned
 $type:
    null    -> array
   1      -> mysql_resource
   2      -> json
   3      -> json_file
   4      -> csv
   5      -> csv_file
*/

define('Q_RET_ARRAY'    ,'0');//default
define('Q_RET_MYSQL_RES','1');
define('Q_RET_NONE'     ,'2');

/*Store affected rows*/
$aff_rows=0;

/*Store num rows*/
$num_rows=0;

/*query ok*/
$query_ok=false;

/*sql error*/
$GLOBALS['sql_error']=array();

/**
Execute query
@param query: query string
@param type: type of database mysql/mssql
@param db: database to be queried
@param array_key: If this parameter set, this key will be used as the key when returning array
@param deleted: if deleted is true, it will only return the deleted redcords. if deleted=all, it will return all records, if deleted is null it will return only non deleted
*/
function exec_multy_query($query,$type=null,$db=null,$array_key=null,$deleted=null,$no_connect=null){
   global $num_rows;
   global $aff_rows;
   global $query_ok;

   $num_rows=0;
   $aff_rows=0;
   $query_ok=false;
   
   if(is_null($db)){
		//Check and load db_active.php
		if (file_exists(DB_ACTIVE)){
			include(DB_ACTIVE);
		}

      $db=$GLOBALS['DB'];
   }

   //Sometimes the database connection is done externally eg: login 
   if($no_connect != true ){
      opendbi($db);
   }

   //Enable this to log all the queries
   log_msg($db.":".$query,null,SQL_LOG);

   /*Execute query*/
   if(mysqli_multi_query($GLOBALS['CONN_I'],$query)){
      $query_ok=true;
   }else{
      $query_ok=false;
   }
   
   /*Set affected rows*/
   $aff_rows   =mysqli_affected_rows($GLOBALS['CONN_I']);

   add_sql_error(mysqli_error($GLOBALS['CONN_I']));

   switch($type){
      case Q_RET_NONE:
      break;
      case Q_RET_ARRAY:
      default:
         $res_array   = array();

         /*If there are mayn row create two dimentional array*/
         $i=0;
         while(true){
            if ($result = mysqli_store_result($GLOBALS['CONN_I'])) {
               $res_res_array=array();
               while ($row = mysqli_fetch_assoc($result)) {
                  if($array_key!=null){
                     $temp_key=$row[$array_key];
                     unset($row[$array_key]);
                     $res_res_array[$temp_key]=$row;
                  }else{
                     $res_res_array[]=$row;
                  }

               }
            $res_array[$i++]=$res_res_array;
            mysqli_free_result($result);
            }
            if(mysqli_more_results($GLOBALS['CONN_I'])){
               mysqli_next_result($GLOBALS['CONN_I']);
            }else{
               break;
            }
         }

         //If we have only one element in $res_array  then return just that element
         if(sizeof($res_array) > 1){
            return $res_array;
         }else{
            if(isset($res_array[0])){
               return $res_array[0];
            }else{
               return array();
            }
         }

         if($no_connect != true ){
            closedbi();
         }
      break;
   }
}

/**
 * Return the table of a simple query
 * @param query: query string
 */
function table_of_query($query){
	//TODO
}

/**
 * Return true if the given column exists in the given table
 * @param column: string column name
 * @param table: the table which searching for the column
 */
function column_exists($column,$table=null){
	//TODO
}

/**
Execute query
@param query: query string
@param type: type of database mysql/mssql
@param db: database to be queried
@param array_key: If this parameter set, this key will be used as the key when returning array
@param deleted: if deleted is true, it will only return the deleted redcords. if deleted=all, it will return all records, if deleted is null it will return only non deleted
*/
function exec_query($query,$type=null,$db=null,$array_key=null,$purge=false,$no_connect=null,$log=false,$updated_by=null){
   global $num_rows;
   global $aff_rows;
   global $query_ok;

   $num_rows=0;
   $aff_rows=0;
   $query_ok=false;
   
   if(is_null($db)){
		//Check and load db_active.php
		if (file_exists(DB_ACTIVE)){
			include(DB_ACTIVE);
		}

      $db=$GLOBALS['DB'];
   }

   //Sometimes the database connection is done externally eg: login 
   if($no_connect != true ){
      opendb($db);
   }

	$created_by='created_by';
	$updated_by='updated_by';
	$updated_at='updated_at';

	/*
		INSERT INTO `base_data`(`base_value`,`base_class`,`base_key`)VALUES('0','VARIABLE','__DB_VERSION')
		UPDATE users SET last_login=CURRENT_TIMESTAMP,failed_logins=0 WHERE username='admin'
	 */
	if(isset($_SESSION['user_id'])){
		if(preg_match('/^INSERT|^REPLACE/i',$query) > 0 ){
         $find='/\)/';
         $replace=",`$created_by`)";
         $query=preg_replace($find,$replace,$query,1);
         $replace=")'".$_SESSION['user_id']."',";
         $query=strrev(preg_replace($find,$replace,strrev($query),1));
		}elseif(preg_match('/^UPDATE/i',$query) > 0 ){
			$query=preg_replace('/ SET /i'," SET `$updated_by`='".$_SESSION['user_id']."',`$updated_at`=NOW(),",$query);
		}
	}

   //Enable this to log all the queries
   if(!strstr($query,'INSERT INTO log'))log_msg('exec_query'.":".$db.":".$query,1,SQL_LOG);

   /*Execute query*/
   $result    = mysql_query($query, $GLOBALS['CONNECTION']);
   
   /*Set affected rows*/
   $aff_rows=mysql_affected_rows($GLOBALS['CONNECTION']);

   add_sql_error(mysql_error($GLOBALS['CONNECTION']));

   if($result){
      $query_ok=true;
   }

   /*If result is false then return false*/
   if(!is_resource($result)){
      if($no_connect != true ){
         closedb();
      }
		//even thouthe query fails 
   	switch($type){
         case Q_RET_MYSQL_RES:
            return $result;
         break;
         case Q_RET_ARRAY:
         default:
            return array();
			break;
		}


   }else{
      /*Set num rows*/
      $num_rows=mysql_num_rows($result);
   }

   switch($type){
      case Q_RET_MYSQL_RES:
         return $result;
      break;
      case Q_RET_NONE:
      break;
      case Q_RET_ARRAY:
      default:
         $res_array   = array();

         /*If there are mayn row create two dimentional array*/
         while($row = mysql_fetch_assoc($result)){
            if($array_key!=null){
               $temp_key=$row[$array_key];
               unset($row[$array_key]);
               $res_array[$temp_key]=$row;
            }else{
               $res_array[]=$row;
            }
         }

         return $res_array;
         if($no_connect != true ){
            closedb();
         }
      break;
   }
}

//Wrapper for the exec_query
function q($query,$type=null,$db=null,$array_key=null,$purge=false,$no_connect=null,$log=false,$updated_by=null){
   return exec_query($query,$type,$db,$array_key,$purge,$no_connect,$log,$updated_by);
}
function eq($query,$type=null,$db=null,$array_key=null,$purge=false,$no_connect=null,$log=false,$updated_by=null){
   return exec_query($query,$type,$db,$array_key,$purge,$no_connect,$log,$updated_by);
}

//Get  values for a given set of fields
function get_table_valus($rid,$fields=null,$table,$key_field='rid',$filter=null){
   if(!is_null($filter)){
      $filter="AND ".$filter;
   }
   if(is_array($fields)){
      $res=exec_query("SELECT `".implode('`,`',$fields)."` FROM ".$table." WHERE $key_field='".$rid."' $filter",Q_RET_ARRAY);
      return $res[0];
   }else{
      $res=exec_query("SELECT `".$fields."` FROM ".$table." WHERE $key_field='".$rid."' $filter",Q_RET_ARRAY);
      return $res[0][$fields];
   }
}

//Wrapper for the get_table_value
function tv($rid,$fields=null,$table,$key_field='rid',$filter=null){
   return get_table_valus($rid,$fields,$table,$key_field,$filter);
}

//Collect all the sql errors until it is red by the program
function add_sql_error($error=null){
   if(!is_null($error) && trim($error) != ''){
      $GLOBALS['sql_error'][]=$error;
   }
}

/*Return sql error*/
//Duplicate entry 'nmla@yape.lk' for key 'email'
function get_sql_error(){
   if(sizeof($GLOBALS['sql_error']) > 0){
      $sql_error=implode($GLOBALS['sql_error'],',');
      $GLOBALS['sql_error']=array();

      return str_replace("'","`",$sql_error);
   }else{
      return false; 
   }
}

/*Return affected rows from current query*/
function get_affected_rows(){
   global $aff_rows;
   return $aff_rows;
}

/*Return num rows selected from current query*/
function get_num_rows(){
   global $num_rows;
   return $num_rows;
}

function is_query_ok(){
   global $query_ok;
   return $query_ok;
}

/*
 * function to delete the record
 * @param table: Table name to delete the record
 * @param where: Where clause to match the records to delete
 * @param purge: Purge the record (actually delete) or flag as deleted
 * @param flag_field: If flag as deleted, flag field 
 * @param flag_value: the value should be set to the flag 
 */
function delete_query($table,$where,$purge=false,$flag_field=null,$flag_value='DELETED'){
	//If the flag_field is null flag, default flag field is 'deleted' and the flag value is '1'
	if(is_null($flag_field)){
		$flag_field='deleted';
		$flag_value=1;
	}

	//Query to flag the record as deleted
	$query="UPDATE $table SET $flag_field='$flag_value' WHERE $where";

	//If purge is true delete the record completely from the table
	if($purge){
		$query="DELETE FROM $table  WHERE $where";
	}

	exec_query($query,Q_RET_NONE);
}

/*
function db_to_csv($query,$csv_file,$db=null){
   $query="
   $query   
   INTO OUTFILE '$csv_file'
   FIELDS TERMINATED BY ','
   ENCLOSED BY '\"'
   LINES TERMINATED BY '\\n';";

   return exec_query($query,Q_RET_MYSQL_RES,$db);
}
 */
function db_to_csv($query,$csv_file,$db=null){
   db_to_csv_nr($query,$csv_file,$db=$db);
}

/*
db to csv data export function for non root users
*/
function db_to_csv_nr($query,$csv_file,$header_array=null,$delimiter=",",$enclosure='"',$terminator="\n",$db=null,$save=null){
   //$res    = exec_query($query,Q_RET_MYSQL_RES,$db);
   $res    = exec_query($query,Q_RET_ARRAY,$db);
   set_file_header($csv_file);
   $header=false;
	$csv="";

   //print column header
   if(!is_null($header_array)){
      $csv.=$enclosure.implode($enclosure.$delimiter.$enclosure,$column_array).$enclosure.$terminator;
      $header=true;
   }

   //print lines
   //while($row = mysql_fetch_assoc($res)){
   foreach($res as $key => $row){
      if(!$header){
         $csv.=$enclosure.implode($enclosure.$delimiter.$enclosure,array_keys($row)).$enclosure.$terminator;
         $header=true;
      }
      $csv.=$enclosure.implode($enclosure.$delimiter.$enclosure,array_values($row)).$enclosure.$terminator;
   }
	if(!is_null($save)){
		file_put_contents($save."/".$csv_file, $csv);
	}
	echo $csv;
   exit();
}

/**
 * field array should imply the order of columns in csv
 * data import from csv functio for non root users
 */
function csv_to_db($csv_file,$table,$field_array,$delimiter=',',$enclosure="'",$first_line_header=true,$first_line_columns=false,$db=null){
   $first_line =true;
   $comma      ="";
   $query      ="INSERT INTO $table(`".implode($field_array,'`,`')."`)VALUES";
   //Mac support
   ini_set('auto_detect_line_endings',TRUE);
   if (($handle = fopen($csv_file, "r")) !== FALSE) {
      //fgetcsv will not work with null values (eg: for enclosure)
      if (is_null($enclosure) || $enclosure != '') {
         while(($line=fgetcsv($handle,$length=0,$delimiter)) !== FALSE){
            if($first_line_columns && $first_line){
               $field_array=$line;
               $query      ="INSERT INTO $table(`".implode($field_array,'`,`')."`)VALUES";
            }
            if($first_line_header && $first_line){
               $first_line=false;
               continue;
            }
            $query   .=$comma."('".implode($line,"','")."')";
            $comma   =",";
         }
      }else{
          while(($line=fgetcsv($handle,$length=0,$delimiter,$enclosure)) !== FALSE){
            if($first_line_columns && $first_line){
               $field_array=$line;
               $query      ="INSERT INTO $table(`".implode($field_array,'`,`')."`)VALUES";
            }
            if($first_line_header && $first_line){
               $first_line=false;
               continue;
            }
            $query   .=$comma."('".implode($line,"','")."')";
            $comma   =",";
         }
      }
      $res=exec_query($query,Q_RET_MYSQL_RES,$db);
      fclose($handle);
      //Return error state
      if(get_sql_error() == false){
         return true;
      }else{
         log_msg(get_sql_error());
         return false;
      }
   }
   return false; 
}

function csv_to_db2($csv_file,$table,$field_array,$delimiter,$encloser,$terminator,$first_line_header,$db=null){
   /*If the first line header is true  ignore first line*/
   $ignore_first_line="";
   if($first_line_header){
      $ignore_first_line="IGNORE 1 LINES";
   }
   $query="LOAD DATA LOCAL INFILE '$csv_file' INTO TABLE $table FIELDS TERMINATED BY '$delimiter' ENCLOSED BY '$encloser' LINES TERMINATED BY '$terminator' $ignore_first_line (".implode(',',$field_array).")";
   return exec_query($query,Q_RET_MYSQL_RES,$db);
}

/*Addd prefix to each array entrye*/
function add_prefix(&$value,$key,$prefix){
   //$value=sprintf($value,$prefix,$prefix,$prefix,$prefix,$prefix,$prefix,$prefix,$prefix);
   $value=str_replace('%s',$prefix,$value);
}

/*Addd prefix to each table to reflect the module*/
function add_table_prefix(&$schemas,$prefix){
   array_walk($schemas,'add_prefix',$prefix."_");
}

//add_table_prefix($program_table_schemas,'bit');


/*
 * Generic table creation function
 */
function create_tables($schemas=null){
   $state=true;

   foreach($schemas as $key=>$schema){
      if(exec_query($schema,Q_RET_MYSQL_RES)){
         log_msg("create_tables [OK] ".$key,null,SQL_LOG);
      }else{
         log_msg("create_tables[ERROR] ".get_sql_error(),null,SQL_LOG);
         $state=false;
      }
   }
   return $state;
}


/**
 * chec if the given schema is a table or view
 */
function is_view($schema){
   $arr=exec_query("SHOW FULL TABLES WHERE TABLE_TYPE LIKE 'VIEW' AND TABLES_IN_".$GLOBALS['DB']." LIKE '$schema'",Q_RET_ARRAY);
   if(isset($arr[0])){
      return true;
   }else{
      return false;
   }
}

function drop_tables($tables){
   $state=true;
   foreach($tables as $key=>$name){
      if(is_view($name)){
         if(exec_multy_query("SET FOREIGN_KEY_CHECKS = 0;DROP VIEW ".$name,Q_RET_MYSQL_RES)){
            log_msg('drop_view'.$name,null,SQL_LOG);
         }else{
            log_msg(get_sql_error(),null,SQL_LOG);
            $state=false;
         }
      }else{
         $del_res=exec_query("SELECT * FROM ".$name,Q_RET_MYSQL_RES);

         /*IF the table have data backup the table instead of deleting*/
         if(get_num_rows()>0){
            if(exec_query("RENAME TABLE ".$name." TO ".$name."_BAK_".Date('d_m_Y'),Q_RET_MYSQL_RES)){
               log_msg('rename_tables'.$name,null,SQL_LOG);
            }else{
               log_msg(get_sql_error(),null,SQL_LOG);
               $state=false;
            }
         }else{
            if(exec_multy_query("SET FOREIGN_KEY_CHECKS = 0;DROP TABLE ".$name,Q_RET_MYSQL_RES)){
               log_msg('drop_tables'.$name,null,SQL_LOG);
            }else{
               log_msg(get_sql_error(),null,SQL_LOG);
               $state=false;
            }
         }
      }
   }
   return $state;
}

/*
 * Generic mysql function creation function
 */
function create_functions($schemas=null){
   $state=true;

   foreach($schemas as $key=>$schema){
      if(exec_query($schema,Q_RET_MYSQL_RES)){
         log_msg('create_functions'."Creating function:$key",null,SQL_LOG);
      }else{
         log_msg(get_sql_error(),null,SQL_LOG);
         $state=false;
      }
   }
   return $state;
}

/*
 * Delete triggers 
 */
function drop_functions($schemas){
   $state=true;
   foreach($schemas as $name=>$sql){
     if(exec_query("DROP TRIGGER ".$name,Q_RET_MYSQL_RES)){
        log_msg('drop_system_tables'."Drop table:$name",null,SQL_LOG);
     }else{
        log_msg(get_sql_error(),null,SQL_LOG);
        $state=false;
     }   
   }
   return $state;
}


/**
This function will create all the tables required to manage a program eg: BIT,BICT, BCSC

@param table_prefix prefix to be added when generating program tables eg: bit_, bcsc_, mcs_
DEPRICATED
*/

function create_program_tables($schemas=null){
   global $program_table_schemas;
   $state=true;

   //If a custom schema requested select that
   if($schemas != null){
      $program_table_schemas=$schemas;
   }

   echo "\n";
   foreach($program_table_schemas as $key=>$schema){
      if(exec_query($schema,Q_RET_MYSQL_RES)){
         log_msg('create_program_tables'."Creating table:$key",null,SQL_LOG);
      }else{
         log_msg(get_sql_error(),null,SQL_LOG);
         $state=false;
      }
   }
   return $state;
}

/**
This function will delete all the tables from the given program eg: BIT,BICT, BCSC
@param table_prefix prefix to be searched when deleting program tables eg: bit_, bcsc_, mcs_
*/



/**
This will create set of tables to be run the system. These tables are common for all programs
*/
function create_system_tables($schemas = null){
   global $system_table_schemas;
   $state=true;

   //If a custom schema requested overwrite default
   if($schemas != null){
      $system_table_schemas=$schemas;
   }

   foreach($system_table_schemas as $key=>$schema){
      if(exec_query($schema,Q_RET_MYSQL_RES)){
         log_msg('create_system_tables'."Creating table:$key",null,SQL_LOG);
      }else{
         log_msg(get_sql_error(),null,SQL_LOG);
         $state=false;
      }
   }
   return $state;
}

/**
testing
*/

$trigger="delimiter //
CREATE TRIGGER updtrigger BEFORE UPDATE ON Employee
FOR EACH ROW
BEGIN
IF NEW.Salary<=500 THEN
SET NEW.Salary=10000;
ELSEIF NEW.Salary>500 THEN
SET NEW.Salary=15000;
END IF;
END
//
";

$view="
CREATE VIEW myView AS SELECT id, first_name FROM employee WHERE id = 1;
";



$stored_procedure="
delimiter //
DROP PROCEDURE IF EXISTS colavg//
CREATE PROCEDURE colavg(IN tbl CHAR(64), IN col CHAR(64))
READS SQL DATA
COMMENT 'Selects the average of column col in table tbl'
BEGIN
SET @s = CONCAT('SELECT AVG(' , col , ') FROM ' , tbl);
PREPARE stmt FROM @s;
EXECUTE stmt;
END;
//

CALL colavg('Country', 'LifeExpectancy');

";

/**
 * Backup current database as to sql dump
 */
function backup_db(){
   $backup_file=MOD_BACKUP."/".$GLOBALS['DB']."_".date("j-n-Y_H:m:s").".sql.gz";
   log_msg("mysqldump -f -u".$GLOBALS['DB_USER']." -p".$GLOBALS['DB_PASS']."  ".$GLOBALS['DB']." | gzip > $backup_file");
   exec("mysqldump -f -u".$GLOBALS['DB_USER']." -p".$GLOBALS['DB_PASS']."  ".$GLOBALS['DB']." | gzip > $backup_file");
   if(file_exists($backup_file)){
      return_status_json('OK','Backup successful!');
   }else{
      return_status_json('ERROR','Backup error!');
   }
}

   
   
?>
