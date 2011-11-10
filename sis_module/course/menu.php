<?php

$menu_array  = array(
	   "manage_course"=>"Manage courses",
	   "course_registration"=>"Courses Registration",
		"course_attendance"=>"Attendance Sheets"
);


$toolbar	=array(
	"manage_course"		=>array(
		'Add'		=>array('icon'=>'NewPage','action'=>'submit_form("add")'),
		'Save'	=>array('icon'=>'Save','action'=>'submit_form("modify")'),
		'Delete'	=>array('icon'=>'Delete','action'=>'submit_form("delete")'),
		'Search'	=>array('icon'=>'Search'),
		'CSV'		=>array('icon'=>'Database','action'=>'get_csv()'),
		'Grid'	=>array('icon'=>'Table','action'=>'grid()'),
		'Print'	=>array('icon'=>'Print'),
		'Add Filter'	=>array('icon'=>'Filter','action'=>'show_dialog()','dojoType'=>'dijit.form.Button','label'=>'Add Filter')
	),
	"course_registration"		=>array(
		'Save'	=>array('icon'=>'Save','action'=>'submit_form("modify")')
	),
	"course_attendance"		=>array(
		'Print'	=>array('icon'=>'NewPage','label'=>'PDF','action'=>'submit_form("pdf")'),
		'CSV'		=>array('icon'=>'Database','action'=>'submit_form("csv")'),
		'Save'	=>array('icon'=>'Save','action'=>'submit_form("modify")')
	)
);
?>
