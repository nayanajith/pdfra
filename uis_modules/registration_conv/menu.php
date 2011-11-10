<?php

$menu_array   = array(
	"manage_config"	=>"Configure",
	"manage_programs" =>"Programs",
	"convocation" =>"Convocations Registrations/Login",
	"pay_online" =>array("PAGE"=>"Pay Online","VISIBLE"=>"false"),
	"pay_offiline" =>array("PAGE"=>"Pay Offline","VISIBLE"=>"false"),
	"offline_voucher" =>array("PAGE"=>"Generate voucher","VISIBLE"=>"false"),
	"callback" =>array("PAGE"=>"callback","VISIBLE"=>"false")
);


$toolbar	=array(
	"manage_config"		=>array(
		'Regenerate database'		=>array('icon'=>'Table','action'=>'submit_form("generate_db")')
	),
	"manage_programs"		=>array(
		'Add'		=>array('icon'=>'NewPage','action'=>'submit_form("add")'),
		'Save'	=>array('icon'=>'Save','action'=>'submit_form("modify")'),
		'Delete'	=>array('icon'=>'Delete','action'=>'submit_form("delete")'),
		'Grid'	=>array('icon'=>'Table','action'=>'grid()'),
		'Print'	=>array('icon'=>'Print')
	),
	"convocation"		=>array(
		'Add'		=>array('icon'=>'NewPage','action'=>'submit_form("add")'),
		'Save'	=>array('icon'=>'Save','action'=>'submit_form("modify")'),
		'Delete'	=>array('icon'=>'Delete','action'=>'submit_form("delete")'),
		'Grid'	=>array('icon'=>'Table','action'=>'grid()'),
		'Print'	=>array('icon'=>'Print'),
		'Add Filter'	=>array('icon'=>'Filter','action'=>'show_dialog()','label'=>'Add Filter')
	),
	"postgraduate_apl"		=>array(
		'Add'		=>array('icon'=>'NewPage','action'=>'submit_form("add")'),
		'Save'	=>array('icon'=>'Save','action'=>'submit_form("modify")'),
		'Delete'	=>array('icon'=>'Delete','action'=>'submit_form("delete")'),
		'Grid'	=>array('icon'=>'Table','action'=>'grid()'),
		'Print'	=>array('icon'=>'Print'),
		'Add Filter'	=>array('icon'=>'Filter','action'=>'show_dialog()','label'=>'Add Filter')
	)

);


?>
