<?php
/*
System Database tables
*/
$schema_version=3;
         
$system_table_schemas['program']="CREATE TABLE `program` (
  `rid`               INT(3) unsigned NOT NULL AUTO_INCREMENT,
  `short_name`       VARCHAR(20) NOT NULL,
  `full_name`        VARCHAR(300) NOT NULL,
  `logo`             VARCHAR(300) NOT NULL,
  `degree`           VARCHAR(500) NOT NULL,
  `class`            VARCHAR(500) NOT NULL,
  `grade`            VARCHAR(500) NOT NULL,
  `gpv`              VARCHAR(500) NOT NULL,
  `table_prefix`     VARCHAR(100) NOT NULL,
  `deleted`          BOOLEAN     DEFAULT false,
  `note`             VARCHAR(300) DEFAULT NULL,
  PRIMARY KEY (`rid`),
  UNIQUE KEY (`short_name`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$system_table_schemas['users']="CREATE TABLE `users` (
  `user_id`          INT NOT NULL AUTO_INCREMENT,
  `syear`            decimal(4,0) DEFAULT NULL,
  `current_school_id`decimal(10,0) DEFAULT NULL,
  `title`            VARCHAR(5) DEFAULT NULL,
  `first_name`       VARCHAR(100) DEFAULT NULL,
  `last_name`        VARCHAR(100) DEFAULT NULL,
  `middle_names`     VARCHAR(100) DEFAULT NULL,
  `username`         VARCHAR(100) DEFAULT NULL,
  `password`         VARCHAR(100) DEFAULT NULL,
  `phone`            VARCHAR(100) DEFAULT NULL,
  `email`            VARCHAR(100) DEFAULT NULL,
  `ldap_user_id`     VARCHAR(100) DEFAULT NULL,
  `auth_mod`         VARCHAR(50)  DEFAULT NULL,
  `role_id`          VARCHAR(100),
  `theme`            VARCHAR(20) DEFAULT NULL,
  `layout`           VARCHAR(20) DEFAULT NULL,
  `homeroom`         VARCHAR(5) DEFAULT NULL,
  `programs`         TEXT DEFAULT NULL,
  `last_login`       DATETIME,
  `last_logout`      DATETIME,
  `failed_logins`    INT NOT NULL DEFAULT 0,
  `deleted`          BOOLEAN     DEFAULT false,
  `note`             VARCHAR(300) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY (`username`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$system_table_schemas['role']="CREATE TABLE `role`(
  `rid`              INT unsigned NOT NULL AUTO_INCREMENT,
  `group_name`       VARCHAR(100) NOT NULL COMMENT 'A short name to identify the group',
  `file_prefix`      VARCHAR(10) NOT NULL COMMENT 'The prefix for the group related files',
  `layout`           VARCHAR(10) NOT NULL COMMENT 'The page layout for the group',
  `theme`            VARCHAR(10) NOT NULL COMMENT 'Theme for the group',
  `description`      VARCHAR(300) NOT NULL COMMENT 'Description about the group',
  `timestamp`        TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`rid`),
  UNIQUE KEY (`group_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";


$system_table_schemas['permission']="CREATE TABLE `permission`(
  `rid`              INT unsigned NOT NULL AUTO_INCREMENT,
  `group_user_id`    VARCHAR(100) NOT NULL,
  `module`           VARCHAR(100) NOT NULL,
  `page`             VARCHAR(100) NOT NULL,
  `is_user`          BOOLEAN NOT NULL,
  `timestamp`        TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `access_right`     enum('DENIED','READ','WRITE') NOT NULL DEFAULT 'DENIED',
   PRIMARY KEY (`rid`),
   UNIQUE KEY (`group_user_id`,`module`,`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$system_table_schemas['log']="CREATE TABLE `log` (
  `rid`              BIGINT(10) unsigned NOT NULL AUTO_INCREMENT,
  `proto`            VARCHAR(5) DEFAULT NULL,
  `timestamp`        TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id`          INT NOT NULL,
  `ip`               VARCHAR(15) NOT NULL DEFAULT '',
  `module_id`        VARCHAR(50) NOT NULL DEFAULT '',
  `page_id`          VARCHAR(50) NOT NULL DEFAULT '',
  `cmid`             BIGINT(10) unsigned NOT NULL DEFAULT '0',
  `action_`          VARCHAR(40) NOT NULL DEFAULT '',
  `url`              VARCHAR(100) NOT NULL DEFAULT '',
  `host`             VARCHAR(100) DEFAULT NULL,
  `request`          TEXT DEFAULT NULL,
  `info`             TEXT DEFAULT NULL,
  `agent`            TEXT DEFAULT NULL,
  `deleted`          BOOLEAN     DEFAULT false,
  `note`             VARCHAR(300) DEFAULT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$system_table_schemas['filter']="CREATE TABLE `filter` (
  `rid`              INT unsigned NOT NULL AUTO_INCREMENT,
  `filter_name`      VARCHAR(50) DEFAULT NULL,
  `table_name`       VARCHAR(50) DEFAULT NULL,
  `timestamp`        TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id`          INT NOT NULL,
  `filter_type`      ENUM('SQL','JSON') DEFAULT 'JSON',
  `filter`           TEXT,
  `deleted`          BOOLEAN     DEFAULT false,
  `note`             VARCHAR(300) DEFAULT NULL,
   PRIMARY KEY (`rid`),
   UNIQUE KEY (`filter_name`,`table_name`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$system_table_schemas['base_data']="CREATE TABLE `base_data` (
  `rid`             INT(11)        NOT NULL AUTO_INCREMENT,
  `base_class`      VARCHAR(50)    DEFAULT NULL,
  `base_key`        VARCHAR(100)   NOT NULL,
  `base_value`      TEXT           NOT NULL,
  `status`          VARCHAR(100)   DEFAULT NULL,
  `timestamp`        TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   UNIQUE KEY (`base_class`,`base_key`),
   PRIMARY KEY (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8"; 

$system_table_schemas['news']="CREATE TABLE `news`(
  `rid`              INT unsigned NOT NULL AUTO_INCREMENT,
  `role_id`          VARCHAR(100) NOT NULL,
  `title`            VARCHAR(100) NOT NULL,
  `content`          TEXT NOT NULL,
  `display_from`     DATE NOT NULL,
  `display_until`    DATE NOT NULL,
  `timestamp`        TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   PRIMARY KEY (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

//Base data which should be populated at the first time the system is set up;
$system_base_data['base_data']="
INSERT INTO `base_data`(`base_class`,`base_key`,`base_value`,`status`)VALUES
('VARIABLE','SYSTEM__DB_VERSION','$schema_version','ENABLED'),
('title','[\"MR\",\"MS\",\"MISS\",\"DR\",\"Dr\",\"PROF\"],'ENABLED'),
('district','{\"17\":\"Ampara\",\"20\":\"Anuradhapura\",\"22\":\"Badulla\",\"16\":\"Batticaloa\",\"1\":\"Colombo\",\"7\":\"Galle\",\"2\":\"Gampaha\",\"9\":\"Hambantota\",\"10\":\"Jaffna\",\"3\":\"Kalutara\",\"5\":\"Kandy\",\"24\":\"Kegalle\",\"11\":\"Kilinochchi\",\"19\":\"Kurunegala\",\"12\":\"Mannar\",\"4\":\"Matale\",\"8\":\"Matara\",\"23\":\"Moneragala\",\"13\":\"Mullaitivu\",\"6\":\"Nuwara Eliya\",\"21\":\"Polonnaruwa\",\"18\":\"Puttalam\",\"25\":\"Ratnapura\",\"15\":\"Trincomalee\",\"14\":\"Vavuniya\"},'ENABLED'),
('province','[\"Central\",\"Eastern\",\"North Central\",\"Northern\",\"North Western\",\"Sabaragamuwa\",\"Southern\",\"Uva\",\"Western\"] ','ENABLED'),
('al_subjects','{\"1\":\"PHYSICS\",\"2\":\"CHEMISTERY\",\"10\":\"COMBINED MATHEMATICS\",\"09\":\"BIOLOGY\",\"71\":\"SINHALA\",\"23\":\"ELEMENT OF POLITICAL SCIENCE\",\"24\":\"LOGIC &amp; SCIENTIFIC METHOD\",\"21\":\"ECONOMICS\",\"31\":\"BUSINESS STATISTICS\",\"32\":\"BUSINESS STUDIES\",\"33\":\"ACCOUNTING\",\"22\":\"GEOGRAPHY\",\"25\":\"HISTORY\",\"44\":\"ISLAM\"} ','ENABLED'),
('days_of_week','[\"SUN\",\"MON\",\"TUE\",\"WED\",\"THU\",\"FRI\",\"SAT\"]','ENABLED')
";

//In order to migrate from previous version (0) to current(1) execute these queries;
//db v0 v1
$system_table_migrate[1]="
ALTER TABLE users ADD auth_mod VARCHAR(100);
ALTER TABLE users CHANGE group_id role_id VARCHAR(100);
";

//db v1 -> v2
$system_table_migrate[2]="
alter table users change failed_login failed_logins int not null default 0;
alter table users change last_login last_login datetime;
alter table users drop profile_id;
alter table users drop rollover_id;
alter table users change deleted status varchar(100);
alter table users add last_logout datetime;
";

//db v2 -> v3
$system_table_migrate[3][]=$system_table_schemas['base_data'];
$system_table_migrate[3][]="
insert into base_data(base_class,base_key,base_value,status) select 'LIST',list_name,json,'ACTIVE' from common_lists; 
";
$system_table_migrate[3][]="
drop table common_lists;
";
?>
