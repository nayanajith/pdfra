<?php
/*
Program database tables set of tables for each program
*/
$aptitude_test_table_schemas=array();
$aptitude_test_system_table_schemas=array();

$aptitude_test_table_schemas['al_subjects']="CREATE TABLE `%sal_subjects` (
  `sub_no` int(10) unsigned NOT NULL,
  `sub_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sub_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$aptitude_test_table_schemas['attached_docs']="CREATE TABLE `%sattached_docs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `doc` varchar(2) NOT NULL,
  `doc_path` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;";

$aptitude_test_table_schemas['exam_hall']="CREATE TABLE `%sexam_hall` (
  `hall_id` int(11) NOT NULL,
  `center` varchar(200) DEFAULT NULL,
  `hall` varchar(200) DEFAULT NULL,
  `no_of_rooms` int(11) DEFAULT NULL,
  `sutdents_per_room` int(11) DEFAULT NULL,
  `center_id` int(11) NOT NULL DEFAULT '0',
  `center_address` text,
  `sutdents_allocated` int(11) NOT NULL DEFAULT '0',
  `hid` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`center_id`,`hall_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$aptitude_test_table_schemas['student_alloc']="CREATE TABLE `%sstudent_alloc` (
  `index_no` varchar(10) NOT NULL DEFAULT '',
  `exam_no` varchar(10) NOT NULL DEFAULT '',
  `hall_id` int(11) DEFAULT NULL,
  `room_no` int(11) DEFAULT NULL,
  `center_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`exam_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$aptitude_test_table_schemas['validation']="CREATE TABLE `%svalidation` (
  `index_no` varchar(8) NOT NULL DEFAULT '',
  `lot_no` int(11) DEFAULT NULL,
  `validation` tinyint(1) DEFAULT NULL,
  `user_name` varchar(8) DEFAULT NULL,
  `log_id` bigint(20) DEFAULT NULL,
  `note` text,
  `hall_allocated` tinyint(1) NOT NULL DEFAULT '0',
  `admission_generated` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$aptitude_test_table_schemas['validation_log']="CREATE TABLE `%svalidation_log` (
  `log_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `index_no` varchar(8) DEFAULT NULL,
  `user_name` varchar(8) DEFAULT NULL,
  `ip` varchar(40) DEFAULT NULL,
  `log` text,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3286 DEFAULT CHARSET=utf8;";

$aptitude_test_table_schemas['users_log']="CREATE TABLE `%susers_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(45) DEFAULT NULL,
  `log_in` varchar(45) DEFAULT NULL,
  `date_in` varchar(45) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `local_ip` varchar(45) DEFAULT NULL,
  `log_out` varchar(45) DEFAULT NULL,
  `date_out` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21144 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;";

$aptitude_test_table_schemas['filter']="CREATE TABLE `%sfilter` (
  `table_name` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `filter` text CHARACTER SET utf8,
  `deleted` tinyint(1) DEFAULT '0',
  `note` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `filter_name` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$aptitude_test_table_schemas['ugc_data']="CREATE TABLE `%sugc_data` (
  `indexNo` int(10) unsigned NOT NULL,
  `initial_name` varchar(30) DEFAULT NULL,
  `exam_center` varchar(90) DEFAULT NULL,
  `medium` varchar(1) DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `nic` varchar(11) DEFAULT NULL,
  `steam` varchar(1) DEFAULT NULL,
  `sub1_code` varchar(3) DEFAULT NULL,
  `sub1_result` varchar(1) DEFAULT NULL,
  `sub2_code` varchar(3) DEFAULT NULL,
  `sub2_result` varchar(1) DEFAULT NULL,
  `sub3_code` varchar(3) DEFAULT NULL,
  `sub3_result` varchar(1) DEFAULT NULL,
  `sub4_code` int(11) DEFAULT NULL,
  `sub4_result` varchar(6) DEFAULT NULL,
  `zscore` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`indexNo`),
  KEY `id_indexNo` (`indexNo`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;";

$aptitude_test_table_schemas['user_info']="CREATE TABLE `%suser_info` (
  `id` int(10) NOT NULL DEFAULT '0',
  `index_no` varchar(45) DEFAULT NULL,
  `surname` varchar(500) DEFAULT NULL,
  `fullname` varchar(900) DEFAULT NULL,
  `gender` varchar(2) DEFAULT NULL,
  `district` varchar(45) DEFAULT NULL,
  `zscore` varchar(45) DEFAULT NULL,
  `phone` varchar(500) DEFAULT NULL,
  `subject_grades` varchar(45) DEFAULT NULL,
  `ol_maths_year` varchar(10) DEFAULT NULL,
  `ol_english_year` varchar(10) DEFAULT NULL,
  `pref1` varchar(45) DEFAULT NULL,
  `pref2` varchar(45) DEFAULT NULL,
  `pref3` varchar(45) DEFAULT NULL,
  `pref4` varchar(45) DEFAULT NULL,
  `pref5` varchar(45) DEFAULT NULL,
  `pref6` varchar(45) DEFAULT NULL,
  `exam_center` varchar(45) DEFAULT NULL,
  `attached_docs` varchar(45) DEFAULT NULL,
  `submitted_date` datetime DEFAULT NULL,
  `ip_addr` varchar(18) DEFAULT NULL,
  `complete` varchar(4) DEFAULT NULL,
  `address` text,
  `nic` varchar(10) DEFAULT NULL,
  `surname_2` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$aptitude_test_table_schemas['post_processing']="CREATE TABLE `%spost_processing` (
  `exam_no` varchar(8) default NULL,
  `absetnt` tinyint(1) default 0,
  `unauthorized` tinyint(1) default 0,
  `user_name` varchar(8) default NULL,
  `log_id` bigint(20) default NULL,
  `note` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";



/*
System Database tables
*/
         
$aptitude_test_system_table_schemas['program']="CREATE TABLE `program` (
  `id` 					int(3) unsigned NOT NULL AUTO_INCREMENT,
  `short_name` 		varchar(20) NOT NULL,
  `check_modulus` 	int NOT NULL,
  `index_length` 		int NOT NULL,
  `center_id_digits` int NOT NULL,
  `hall_id_digits` 	int NOT NULL,
  `student_id_digits` 	int NOT NULL,
  `base_no` 			bigint NOT NULL,
  `exam_date` 			varchar(20) NOT NULL,
  `exam_duration` 	varchar(20) NOT NULL,
  `student_come_before` 				int NOT NULL,
  `issued_date` 		varchar(20) NOT NULL,
  `sheet_header` 		text NOT NULL,
  `full_name` 			varchar(300) NOT NULL,
  `logo` 				varchar(300) NOT NULL,
  `table_prefix` 		varchar(100) NOT NULL,
  `deleted`          boolean     DEFAULT false,
	`note` 				varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;";

/**
This function will create all the tables required to manage a program eg: BIT,BICT, BCSC

@param table_prefix prefix to be added when generating program tables eg: bit_, bcsc_, mcs_
*/

function create_aptitude_test_tables($table_prefix){
	global $aptitude_test_table_schemas;
	echo "\n";
	foreach($aptitude_test_table_schemas as $key=>$schema){
		if(exec_query(sprintf($schema,$table_prefix),1)){
			echo "Creating table:$key:OK\n";
		}else{
			echo "Creating table:$key:ERROR\n";
		}
	}
}

/**
This function will delete all the tables from the given program eg: BIT,BICT, BCSC

@param table_prefix prefix to be searched when deleting program tables eg: bit_, bcsc_, mcs_
*/
function drop_aptitude_test_tables($table_prefix){
	global $aptitude_test_table_schemas;
	foreach($aptitude_test_table_schemas as $key=>$schema){
		if(exec_query("DROP TABLE ".$table_prefix.$key,1)){
			echo "Drop table:$key:OK\n";
		}else{
			echo "Drop table:$key:ERROR\n";
		}
	}
}

/**
This will create set of tables to be run the system. These tables are common for all programs
*/
function create_aptitude_test_system_tables(){
	global $aptitude_test_system_table_schemas;
	foreach($aptitude_test_system_table_schemas as $key=>$schema){
		if(exec_query($schema,Q_RET_MYSQL_RES,null)){
			echo "Creating table:$key:OK\n";
		}else{
			echo "Creating table:$key:ERROR\n";
		}
	}
}

/*Check and if not exists, create the database and the program table*/

$GLOBALS['CONNECTION'] = mysql_connect($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASS']);

$db_selected = mysql_select_db($GLOBALS['DB'], $GLOBALS['CONNECTION']);

if (!$db_selected) {
	mysql_query("CREATE DATABASE ".$GLOBALS['DB'],$GLOBALS['CONNECTION']);
	create_aptitude_test_system_tables();
	//$db_selected = mysql_select_db($GLOBALS['DB'], $GLOBALS['CONNECTION']);
	if ($db_selected) {
		echo "Successfully created the database!";
	}
}

?>
