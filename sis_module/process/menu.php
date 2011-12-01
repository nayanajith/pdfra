<?php

$menu_array  = array(
   "gpa"          =>"GPA",
   "push"         =>"Push students"
);

$toolbar   =array(
   "gpa"         =>array(
      'Generate'      =>array('action'=>'submit_form("gen")'),
   ),
   "push"  =>array(
      'CSV'   =>array('icon'=>'Database','action'=>'submit_form("csv")'),
      'Print'   =>array('icon'=>'Print','action'=>'submit_form("print")')
   )
);

?>
