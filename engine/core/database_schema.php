<?php
/*
System Database tables
*/
         
$system_table_schemas['program']="CREATE TABLE `program` (
  `id`               int(3) unsigned NOT NULL AUTO_INCREMENT,
  `short_name`       varchar(20) NOT NULL,
  `full_name`        varchar(300) NOT NULL,
  `logo`             varchar(300) NOT NULL,
  `degree`           varchar(500) NOT NULL,
  `class`            varchar(500) NOT NULL,
  `grade`            varchar(500) NOT NULL,
  `gpv`              varchar(500) NOT NULL,
  `table_prefix`     varchar(100) NOT NULL,
  `deleted`          boolean     DEFAULT false,
  `note`             varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$system_table_schemas['users']="CREATE TABLE `users` (
  `user_id`          INT NOT NULL AUTO_INCREMENT,
  `syear`             decimal(4,0) DEFAULT NULL,
  `current_school_id` decimal(10,0) DEFAULT NULL,
  `title`             varchar(5) DEFAULT NULL,
  `first_name`       varchar(100) DEFAULT NULL,
  `last_name`          varchar(100) DEFAULT NULL,
  `middle_name`       varchar(100) DEFAULT NULL,
  `username`          varchar(100) DEFAULT NULL,
  `password`          varchar(100) DEFAULT NULL,
  `phone`             varchar(100) DEFAULT NULL,
  `email`             varchar(100) DEFAULT NULL,
  `ldap_user_id`       varchar(100) DEFAULT NULL,
  `permission`       enum('SUPER','NORMAL') NOT NULL DEFAULT 'NORMAL',
  `theme`             varchar(20) DEFAULT NULL,
  `layout`             varchar(20) DEFAULT NULL,
  `homeroom`          varchar(5) DEFAULT NULL,
  `programs`          varchar(255) DEFAULT NULL,
  `last_login`       timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `failed_login`       decimal(10,0) DEFAULT NULL,
  `profile_id`       decimal(10,0) DEFAULT NULL,
  `rollover_id`       decimal(10,0) DEFAULT NULL,
  `deleted`          boolean     DEFAULT false,
   `note`             varchar(300) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$system_table_schemas['permission']="CREATE TABLE `permission`(
  `user_id`          varchar(100) NOT NULL,
  `module`             varchar(100) NOT NULL,
  `page`             varchar(100) NOT NULL,
  `access_right`       enum('DENIED','READ','WRITE') NOT NULL DEFAULT 'DENIED',
  primary key (`user_id`,`module`,`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";



$system_table_schemas['log']="CREATE TABLE `log` (
  `id`                bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `proto`             varchar(5) DEFAULT NULL,
  `timestamp`          timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id`          INT NOT NULL,
  `ip`                varchar(15) NOT NULL DEFAULT '',
  `module`             varchar(50) NOT NULL DEFAULT '',
  `page`             varchar(50) NOT NULL DEFAULT '',
  `cmid`             bigint(10) unsigned NOT NULL DEFAULT '0',
  `action`             varchar(40) NOT NULL DEFAULT '',
  `url`                varchar(100) NOT NULL DEFAULT '',
  `host`             varchar(100) DEFAULT NULL,
  `request`          text DEFAULT NULL,
  `info`             text DEFAULT NULL,
  `agent`             text DEFAULT NULL,
  `deleted`          boolean     DEFAULT false,
  `note`             varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$system_table_schemas['filter']="CREATE TABLE `filter` (
  `filter_name`       varchar(50) DEFAULT NULL,
  `table_name`       varchar(50) DEFAULT NULL,
  `user_id`          INT NOT NULL,
  `filter`             text,
  `deleted`          boolean     DEFAULT false,
   `note`             varchar(300) DEFAULT NULL,
   PRIMARY KEY (`filter_name`,`table_name`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";



/*Addd prefix to each array entrye*/
function add_prefix(&$value,$key,$prefix){
   $value=sprintf($value,$prefix,$prefix,$prefix,$prefix,$prefix);
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
         log_msg('create_program_tables',"Creating table:$key");
      }else{
         log_msg('create_program_tables',get_sql_error());
         $state=false;
      }
   }
   return $state;
}


function drop_tables($tables){
   $state=true;
   foreach($tables as $key=>$name){
      $del_res=exec_query("SELECT * FROM ".$name,Q_RET_MYSQL_RES);

      /*IF the table have data backup the table instead of deleting*/
      if(get_num_rows()>0){
         if(exec_query("RENAME TABLE ".$name." TO ".$name."_BAK_".Date('d_m_Y'),Q_RET_MYSQL_RES)){
            log_msg('drop_system_tables',"Drop table:$name");
         }else{
            log_msg('drop_system_tables',get_sql_error());
            $state=false;
         }
      }else{
         if(exec_query("DROP TABLE ".$name,Q_RET_MYSQL_RES)){
            log_msg('drop_system_tables',"Drop table:$name");
         }else{
            log_msg('drop_system_tables',get_sql_error());
            $state=false;
         }
      }
   }
   return $state;
}

/**
This function will create all the tables required to manage a program eg: BIT,BICT, BCSC

@param table_prefix prefix to be added when generating program tables eg: bit_, bcsc_, mcs_
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
         log_msg('create_program_tables',"Creating table:$key");
      }else{
         log_msg('create_program_tables',get_sql_error());
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
         log_msg('create_system_tables',"Creating table:$key");
      }else{
         log_msg('create_system_tables',get_sql_error());
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

?>
