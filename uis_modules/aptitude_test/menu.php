<?php
$menu_array  = array(
	"manage_programs"          =>"Manage Programs",
	"register"                 =>"Register",
	"validate"                 =>"Validate",
	"manage_hall"              =>"Manage Hall",
	"student_hall_allocation"  =>"Allocate Students",
	"generate_admissions"      =>"Generate Admissions",
	"generate_attendane_sheets"=>"Attendance Sheets",
	"generate_index_sheets"    =>"Index Sheets",
	"generate_index_stickers"  =>"Index Stickers",
	"generate_summery_sheets"  =>"Summery Sheets",
	"post_processing"          =>"Post Processing"
);

$toolbar	=array(
	"manage_programs"		=>array(
		'Add'		=>array('icon'=>'NewPage','action'=>'submit_form("add")'),
		'Save'	=>array('icon'=>'Save','action'=>'submit_form("modify")'),
		'Delete'	=>array('icon'=>'Delete','action'=>'submit_form("delete")'),
		'Grid'	=>array('icon'=>'Table','action'=>'grid()'),
		'Print'	=>array('icon'=>'Print')
	),

	"manage_hall"		=>array(
		'Add'		=>array('icon'=>'NewPage','action'=>'submit_form("add")'),
		'Save'	=>array('icon'=>'Save','action'=>'submit_form("modify")'),
		'Delete'	=>array('icon'=>'Delete','action'=>'submit_form("delete")'),
		'Search'	=>array('icon'=>'Search'),
		'CSV'		=>array('icon'=>'Database','action'=>'get_csv()'),
		'Grid'	=>array('icon'=>'Table','action'=>'grid()'),
		'Print'	=>array('icon'=>'Print'),
		'Add Filter'	=>array('icon'=>'Filter','action'=>'show_dialog()','dojoType'=>'dijit.form.Button','label'=>'Add Filter')
	),

	"post_processing"		=>array(
		'Add'		=>array('icon'=>'NewPage','action'=>'submit_form("add")'),
		'Save'	=>array('icon'=>'Save','action'=>'submit_form("modify")'),
		'Delete'	=>array('icon'=>'Delete','action'=>'submit_form("delete")'),
		'Search'	=>array('icon'=>'Search'),
		'CSV'		=>array('icon'=>'Database','action'=>'get_csv()'),
		'Grid'	=>array('icon'=>'Table','action'=>'grid()'),
		'Print'	=>array('icon'=>'Print'),
		'Add Filter'	=>array('icon'=>'Filter','action'=>'show_dialog()','dojoType'=>'dijit.form.Button','label'=>'Add Filter')
	),


	"student_hall_allocation"		=>array(
		'Start'	=>array('icon'=>'Filter','action'=>'alert()','dojoType'=>'dijit.form.Button','label'=>'Start')
	),

	"generate_admissions"		=>array(
		'Start'	=>array('icon'=>'Filter','action'=>'alert()','dojoType'=>'dijit.form.Button','label'=>'Start')
	),
	"generate_attendane_sheets"	=>array(
			"generate"=>array('icon'=>'Function','action'=>'submit_form()','label'=>'Generate Attendanc')
	),
	"generate_index_sheets"	=>array(
			"generate"=>array('icon'=>'Function','action'=>'submit_form()','label'=>'Generate Index List')
	),
	"generate_index_stickers"	=>array(
			"generate"=>array('icon'=>'Function','action'=>'submit_form()','label'=>'Generate Index Sticker List')
	),
	"generate_summery_sheets"	=>array(
			"generate"=>array('icon'=>'Function','action'=>'submit_form()','label'=>'Generate Summery Sheet')
	)
);

?>
