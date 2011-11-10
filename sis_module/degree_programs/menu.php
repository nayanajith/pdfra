<?php

$menu_array  = array(
	"manage_programs"		=>"Manage Degree Programs",
	"manage_eligibility"	=>"Eligibility Levels",
	"init_db"				=>">Init System Tables<"
);

$toolbar	=array(
	"manage_programs"		=>array(
		'Add'		=>array('icon'=>'NewPage','action'=>'submit_form("add")'),
		'Save'	=>array('icon'=>'Save','action'=>'submit_form("modify")'),
		'Delete'	=>array('icon'=>'Delete','action'=>'submit_form("delete")'),
		'Search'	=>array('icon'=>'Search'),
		'CSV'		=>array('icon'=>'Database','action'=>'get_csv()'),
		'Grid'	=>array('icon'=>'Table','action'=>'grid()'),
		'Print'	=>array('icon'=>'Print'),
		'Add Filter'	=>array('icon'=>'Filter','action'=>'show_dialog()','dojoType'=>'dijit.form.Button','label'=>'Add Filter')
	),

	"manage_eligibility"		=>array(
		'Add'		=>array('icon'=>'NewPage','action'=>'submit_form("add")'),
		'Save'	=>array('icon'=>'Save','action'=>'submit_form("modify")'),
		'Delete'	=>array('icon'=>'Delete','action'=>'submit_form("delete")'),
		'CSV'		=>array('icon'=>'Database','action'=>'get_csv()'),
		'Add Filter'	=>array('icon'=>'Filter','action'=>'show_dialog()','dojoType'=>'dijit.form.Button','label'=>'Add Filter')
	)
);


?>
