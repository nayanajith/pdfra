<?php
/*
This will include in to $GLOBALS['PAGE_GEN']
*/
/*
Tables for the program
*/
include A_CORE."/database.php";

$program_tables=array(
	'course'					=>'course',
	'reg' 					=>'reg',
	'student'				=>'student',			
	'schedule'           =>'schedule'
	
);     

$GLOBALS['P_TABLES']=$program_tables;
/*
Tables of the system
*/

?>
