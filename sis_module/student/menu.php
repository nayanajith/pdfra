<?php

$menu_array  = array(
	"manage_batch"=>"Manage batches",
	"student_registration"=>"Student Registration"
	/*
	"manage_student"=>"Manage student",
	"push"          =>"Push",
	"bit_push"      =>"BIT Push",
	"grid"          =>"Grid"
	 */
);


$toolbar	=array(
	"student_registration"		=>array(
		'Add'		=>array('icon'=>'NewPage','action'=>'submit_form("add")'),
		'Save'	=>array('icon'=>'Save','action'=>'submit_form("modify")'),
		'Delete'	=>array('icon'=>'Delete','action'=>'submit_form("delete")'),
		'CSV'		=>array('icon'=>'Database','action'=>'get_csv()'),
		'Grid'	=>array('icon'=>'Table','action'=>'grid()'),
		'Print'	=>array('icon'=>'Print'),
		'Manage Filter'	=>array('icon'=>'Filter','action'=>'show_dialog()')
	),
	"manage_batch"		=>array(
		'Add'		=>array('icon'=>'NewPage','action'=>'submit_form("add")'),
		'Save'	=>array('icon'=>'Save','action'=>'submit_form("modify")'),
		'Delete'	=>array('icon'=>'Delete','action'=>'submit_form("delete")'),
		'CSV'		=>array('icon'=>'Database','action'=>'get_csv()'),
		'Grid'	=>array('icon'=>'Table','action'=>'grid()'),
		'Print'	=>array('icon'=>'Print'),
		'Manage Filter'	=>array('icon'=>'Filter','action'=>'show_dialog()')
	)

);

?>
