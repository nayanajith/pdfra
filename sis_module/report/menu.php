<?php

$menu_array  = array(
	"transcpt"     =>"Transcript",
	"degree_cert"  =>"Degree Certificate",
	"mark_book"    =>"Mark Book",
	"gpa"    		=>"GPA",
	"help"         =>"Help"
);

$toolbar	=array(
	"transcpt"		=>array(
		'Transcript'		=>array('action'=>'submit_form("transcpt")'),
		'Transcript PDF'	=>array('action'=>'submit_form("pdf")'),
		'Print'				=>array('icon'=>'Print','action'=>'submit_form("print")')
	),
	"mark_book"		=>array(
		'Print'				=>array('icon'=>'Print','action'=>'select_report("print")')
	),
	"degree_cert"		=>array(
		'Generate'		=>array('action'=>'submit_form("generate")')
	),
	"gpa"			=>array(
	)

);

?>
