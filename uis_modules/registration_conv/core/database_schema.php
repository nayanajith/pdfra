<?php
/*
Program database tables set of tables for each program
*/
include(A_CORE."/database_schema.php");
$program_table_schemas	=array();
$system_table_schemas	=array();

$system_table_schemas['program']="CREATE TABLE `%sprogram` (
   `program_id` 		int(3) unsigned NOT NULL AUTO_INCREMENT,
   `short_name` 		varchar(20) NOT NULL,
   `description` 		varchar(50) NOT NULL,
   `registration` 	enum('OPTIONAL','COMPULSORY') NOT NULL DEFAULT 'COMPULSORY',
   `authentication` 	enum('MOODLE','LDAP','NATIVE') NOT NULL DEFAULT 'NATIVE',
   `code` 				varchar(4) NOT NULL,
   `coordinator` 		varchar(100) NOT NULL,
   `disabled`        boolean DEFAULT false,
   `starting`        datetime DEFAULT NULL,
   `ending`        	datetime DEFAULT NULL,
   `deleted`         boolean DEFAULT false,
 	`note` 				varchar(300) DEFAULT NULL,
   UNIQUE KEY (`code`),
   PRIMARY KEY (`program_id`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$system_table_schemas['from_fields']="CREATE TABLE `%sfrom_fields` (
   `program_id` 		int(3) unsigned NOT NULL AUTO_INCREMENT,
   `field_name` 		varchar(100) NOT NULL,
   `field_label` 		varchar(100) NOT NULL,
   PRIMARY KEY (`program_id`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$system_table_schemas['filter']="CREATE TABLE `%sfilter` (
  `table_name` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `filter` 	text CHARACTER SET utf8,
  `deleted` tinyint(1) DEFAULT '0',
  `note`  	text NULL,
  `filter_name` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";


$system_table_schemas['registration']="CREATE TABLE `%sregistration` (
   `reg_id` 			int(11) NOT NULL AUTO_INCREMENT,
   `registration_type` 	varchar(20) NOT NULL,
  	`title` 					varchar(5) NOT NULL,
   `first_name` 			varchar(50) NOT NULL,
   `middle_names` 		varchar(50) NOT NULL,
   `last_name` 			varchar(50) NOT NULL,
   `NIC` 					varchar(12) NULL,
   `DOB` 					date NULL,
   `sex` 					enum('F','M') NOT NULL,
   `confirm` 				varchar(40) NULL,

	/*--degree 1 details--*/
	`degree_title_1`		varchar(300),
	`year_of_award_1`		varchar(4),
	`university_1`			varchar(300),
	`date_entered_1`		date,
	`date_left_1`			date,
	`subject1_1`			varchar(200),
	`subject2_1`			varchar(200),
	`subject3_1`			varchar(200),
	`subject4_1`			varchar(200),

	/*--degree 1 details--*/
	`degree_title_2`		varchar(300),
	`year_of_award_2`		varchar(4),
	`university_2`			varchar(300),
	`date_entered_2`		date,
	`date_left_2`			date,
	`subject1_2`			varchar(200),
	`subject2_2`			varchar(200),
	`subject3_2`			varchar(200),
	`subject4_2`			varchar(200),

	/*--other education/professional qualifications--*/
	`edu_prof_qual1`		text,
	`edu_prof_qual2`		text,
	`edu_prof_qual3`		text,
	`edu_prof_qual4`		text,
	`edu_prof_qual5`		text,
	`edu_prof_qual6`		text,

	/*--employment records--*/
	`emp_rec1`				text,
	`emp_rec2`				text,
	`emp_rec3`				text,
	`emp_rec4`				text,
	`emp_rec5`				text,

	/*--career details--*/
   `job_description` 	text,
   `affiliation` 			varchar(300) NOT NULL,
   `designation` 			varchar(300) NOT NULL,

	/*--contact information--*/
   `email` 					varchar(100) NOT NULL,
   `telephone` 			varchar(10) NOT NULL,
   `mobile` 				varchar(10) NOT NULL,
   `fax` 					varchar(50) DEFAULT NULL,
   `address1_1`			varchar(200) NOT NULL,
   `address2_1` 			varchar(200) NOT NULL,
   `address3_1` 			varchar(200) NOT NULL,
   `address1_2`			varchar(200) NOT NULL,
   `address2_2` 			varchar(200) NOT NULL,
   `address3_2` 			varchar(200) NOT NULL,
   `city` 					varchar(100) NOT NULL,
   `state` 					varchar(50) NOT NULL,
   `zip` 					varchar(10) NOT NULL,
   `country` 				varchar(50) NOT NULL,

	/*--refree information--*/
	`referee_name1`		varchar(300),
	`referee_designation1`	varchar(300),
	`referee_work_place1`	varchar(300),
	`referee_address1`		text,
	`referee_phone1`		varchar(10),
	`referee_email1`		varchar(300),

	/*--refree information--*/
	`referee_name2`		varchar(300),
	`referee_designation2`	varchar(300),
	`referee_work_place2`	varchar(300),
	`referee_address2`		text,
	`referee_phone2`		varchar(10),
	`referee_email2`		varchar(300),

	/*--login details--*/
   `password` 				varchar(50) NOT NULL,
  	`functions` 			text NULL,
  	`last_login` 			timestamp NULL,
   `status` 				enum('PENDING','ACCEPTED','REJECTED') NOT NULL DEFAULT 'PENDING',
   `updated_time` 		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   UNIQUE KEY (`email`),
   UNIQUE KEY (`nic`),
   PRIMARY KEY (`reg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

$system_table_schemas['convocation_reg']="CREATE TABLE `%sconvocation_reg` (
   `index_no`			varchar(20) NOT NULL,
   `reg_no`				varchar(20) NOT NULL,
   `password`			varchar(64) NULL,
	/*`year` 				varchar(4) NOT NULL DEFAULT date_format(CURDATE(),' ','%%Y'),
	`year` 				date NOT NULL DEFAULT CURDATE(),*/
   `name` 				text NOT NULL,
   `nic` 				varchar(10) NOT NULL,
   `email` 				varchar(100) NOT NULL,
   `name_in_english` text NOT NULL,
   `name_in_sinhala` text NOT NULL,
   `name_in_tamil` 	text NOT NULL,
	`category`			enum('MSC','MPHIL','DIP') NOT NULL DEFAULT 'MSC',
   `awarded_in` 		enum('IN_PERSON','IN_ABSENTIA') NOT NULL DEFAULT 'IN_PERSON',
	`guest_tickets`	enum('0','1','2') NOT NULL DEFAULT '0',
	`current_level`	enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
   `pay_online`      boolean DEFAULT false,
   `pay_online_status` 		enum('PENDING','ACCEPTED','REJECTED') DEFAULT NULL,
   `pay_offline_status` 	enum('PENDING','RECIEVED') DEFAULT NULL,
   `transaction_id` 			varchar(100) NULL,
   `updated_time`				timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`client_ip`					varchar(200) NULL,
   UNIQUE KEY (`reg_no`),
   PRIMARY KEY (`index_no`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$system_table_schemas['convocation_reg']="CREATE TABLE `%sconvocation_reg` (
   `index_no`			varchar(20) NOT NULL,
   `reg_no`				varchar(20) NOT NULL,
   `password`			varchar(64) NULL,
	/*`year` 				varchar(4) NOT NULL DEFAULT date_format(CURDATE(),' ','%%Y'),
	`year` 				date NOT NULL DEFAULT CURDATE(),*/
   `name` 				text NOT NULL,
   `nic` 				varchar(10) NOT NULL,
   `email` 				varchar(100) NOT NULL,
   `name_in_english` text NOT NULL,
   `name_in_sinhala` text NOT NULL,
   `name_in_tamil` 	text NOT NULL,
	`category`			enum('MSC','MPHIL','DIP') NOT NULL DEFAULT 'MSC',
   `awarded_in` 		enum('IN_PERSON','IN_ABSENTIA') NOT NULL DEFAULT 'IN_PERSON',
	`guest_tickets`	enum('0','1','2') NOT NULL DEFAULT '0',
	`current_level`	enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
   `pay_online`      boolean DEFAULT false,
   `pay_online_status` 		enum('PENDING','ACCEPTED','REJECTED') DEFAULT NULL,
   `pay_offline_status` 	enum('PENDING','RECIEVED') DEFAULT NULL,
   `transaction_id` 			varchar(100) NULL,
   `updated_time`				timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`client_ip`					varchar(200) NULL,
   UNIQUE KEY (`reg_no`),
   PRIMARY KEY (`index_no`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;";





add_table_prefix($system_table_schemas,MODULE);

/*Check and if not exists, create the database and the program table*/
$GLOBALS['CONNECTION'] 	= mysql_connect($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASS']);
$db_selected 				= mysql_select_db($GLOBALS['DB'], $GLOBALS['CONNECTION']);

if (!$db_selected) {
	log_msg($GLOBALS['DB'],"Creating database and tables...");
	mysql_query("CREATE DATABASE ".$GLOBALS['DB'],$GLOBALS['CONNECTION']);
	create_system_tables();
	$db_selected = mysql_select_db($GLOBALS['DB'], $GLOBALS['CONNECTION']);
	if ($db_selected) {
		log_msg($GLOBALS['DB'],"Successfully created the database!");
	}
}elseif(isset($_REQUEST['create_tables']) && $_REQUEST['create_tables'] == 'true'){
	log_msg($GLOBALS['DB'],"Creating tables...");
	create_system_tables();
}

?>
