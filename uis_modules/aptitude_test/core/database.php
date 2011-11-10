<?php
/*
This will include in to $GLOBALS["PAGE_GEN"]
*/
/*
Tables for the program
*/
$prefix="bict_";
$program_tables=array(
	"user_info"				=>$prefix."user_info",
	"validation"			=>$prefix."validation",
	"exam_hall"				=>$prefix."exam_hall",
	"student_alloc"		=>$prefix."student_alloc",

	"al_subjects"			=>$prefix."al_subjects",
	"attached_docs"		=>$prefix."attached_docs",
	"validation_log"		=>$prefix."validation_log",
	"drs_users_log"		=>$prefix."drs_users_log",
	"ugc_data"				=>$prefix."ugc_data",
	"post_processing"		=>$prefix."post_processing",

	"filter"					=>$prefix."filter"
);     

$GLOBALS["P_TABLES"]=$program_tables;

/*
Tables of the system
*/
$aptitude_system_tables=array(
	"program"	=>"program"          
);
$GLOBALS["S_TABLES"]=$aptitude_system_tables;

?>
