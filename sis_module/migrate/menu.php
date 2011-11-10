<?php

$menu_array  = array(
	"ug_migrate"=>"Undergraduate Migrate",
	"pg_migrate"=>"Postgraduate Migrate",
	"bit_migrate"=>"BIT Migrate"
);


$toolbar	=array(
	"ug_migrate"=>array(
		'Migrate'		=>array('icon'=>'Function','action'=>'submit_form("migrate_db")')
	),
	"pg_migrate"=>array(
		'Migrate'		=>array('icon'=>'Function','action'=>'submit_form("migrate_db")')
	),
	"bit_migrate"=>array(
		'Migrate'		=>array('icon'=>'Function','action'=>'submit_form("migrate_db")')
	)
);
?>
