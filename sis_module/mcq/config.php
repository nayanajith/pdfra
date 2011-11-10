<?php 
define('MOD_CLASSES',A_MODULES."/".MODULE."/classes");
define('MOD_CORE',A_MODULES."/".MODULE."/core");
define('MOD_A_ROOT',A_MODULES."/".MODULE);
define('MOD_A_CSV',A_MODULES."/".MODULE."/csv");
define('MOD_W_CSV',W_MODULES."/".MODULE."/csv");
$GLOBALS['MARK_FILE_STORE'] = "mcq/scanned_mark_sheets";

/*---------------------------onfigure Database--------------------------------*/

//$GLOBALS['DB']     = 'bict_admissions_2010';
/*
$GLOBALS['DB']     = 'mcq_processing';
$GLOBALS['DB_HOST']= 'localhost';
$GLOBALS['DB_USER']= 'root';
$GLOBALS['DB_PASS']= 'letmein';
$GLOBALS['DB_TYPE']= 'mysql';
*/

$GLOBALS['TITLE_SHORT'] = 'MCQPROC';
$GLOBALS['TITLE']       = 'MCQ Proccessing';
$GLOBALS['TITLE_LONG']  = 'University of Colombo School of Computing Attendance System';
$GLOBALS['LOGO']        = 'ucsc-logo.png';
$GLOBALS['FAVICON']     = 'favicon.ico';

/*MCQ processing status array*/
$GLOBALS['MCQ_PROC_STATUS']=array(
	'INIT', 				//Initial stat where an entry added to the paper and csv files were uploaded
	'EXTRACTED', 		//Marking logic  and students answers where extracted from the csv files to the database
	'ITEM_ANALYSIS',	//Item analysis report where generated 
	'MARK_ANSWERS'		//Answers where markd and marks generated for all students
);

include_once(A_CORE."/database_schema.php");
include(MOD_CORE."/database.php");
?>
