<?php

$menu_array  = array(
   "eligibility"  =>"Eligibility",
   "pass_list"  =>"Pass list",
   "push" =>"Push students",
);


$toolbar   =array(
   "push"  =>array(
      'CSV'   =>array('icon'=>'Database','action'=>'submit_form("csv")'),
      'Print'   =>array('icon'=>'Print','action'=>'submit_form("print")')
   ),

   "year_pass"      =>array(
      'CSV'      =>array('icon'=>'Database','action'=>'submit_form("csv")')
   ),
   "pass_list"  =>array(
      'Save'   =>array('icon'=>'Save','action'=>'submit_form("modify")'),
      'CSV'      =>array('icon'=>'Database','action'=>'submit_form("csv")'),
      'PDF'      =>array('icon'=>'NewPage','action'=>'submit_form("pdf")'),
      'Print'   =>array('icon'=>'Print','action'=>'submit_form("print")')
   ),
   "eligibility"  =>array(
      'Save'   =>array('icon'=>'Save','action'=>'submit_form("modify")'),
      'CSV'      =>array('icon'=>'Database','action'=>'submit_form("csv")'),
      'Print'   =>array('icon'=>'Print','action'=>'submit_form("print")')
   ),
);


?>
