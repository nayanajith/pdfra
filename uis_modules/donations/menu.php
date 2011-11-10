<?php

$menu_array   = array(
	"manage_config"	=>"Configure",
	"manage_programs" =>"Programs",
	"registration"		=>"Make a Donation",
	"reset_password"	=>"Forgot Password",
	"donation_to"		=>array("PAGE"=>"Donation type","VISIBLE"=>"false"),
	"payment"			=>"Payment",
	"login"				=>"Login",
	"reports"			=>"Reports",
	"reports2"			=>array("PAGE"=>"Reports2","VISIBLE"=>"false"),
	"email_verification"			=>array("PAGE"=>"Email verification","VISIBLE"=>"false"),
	"pay_online"		=>array("PAGE"=>"Pay Online","VISIBLE"=>"false"),
	"pay_offiline"		=>array("PAGE"=>"Pay Offline","VISIBLE"=>"false"),
	"offline_voucher" =>array("PAGE"=>"Generate voucher","VISIBLE"=>"false"),
	"captcha"			=>array("PAGE"=>"Captcha","VISIBLE"=>"false"),
	"callback"			=>array("PAGE"=>"Callback","VISIBLE"=>"false")
);
//hide application and login link after login
if(isset($_SESSION['user_id'])){
	$menu_array["registration"]=array("PAGE"=>"Application","VISIBLE"=>"false");
	$menu_array["login"]=array("PAGE"=>"Login","VISIBLE"=>"false");
}else{
	//Payment link only show after login
	$menu_array["payment"]=array("PAGE"=>"Payment","VISIBLE"=>"false");
}

//Visible application window after login if the users is a system user
if(isset($_SESSION['loged_module']) && $_SESSION['loged_module']=='home'){
	$menu_array["registration"]=array("PAGE"=>"Application","VISIBLE"=>"true");
}

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
	"registration"		=>array(
		'Add'		=>array('icon'=>'NewPage','action'=>'submit_form("add")'),
		'Save'	=>array('icon'=>'Save','action'=>'submit_form("modify")'),
		'Delete'	=>array('icon'=>'Delete','action'=>'submit_form("delete")'),
		'Grid'	=>array('icon'=>'Table','action'=>'grid()'),
		'Print'	=>array('icon'=>'Print'),
		'CSV'		=>array('icon'=>'Database','action'=>'get_csv()'),
		'Add Filter'	=>array('icon'=>'Filter','action'=>'show_dialog()','label'=>'Add Filter')
	)

);


?>
