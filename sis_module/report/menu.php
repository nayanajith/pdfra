<?php

$menu_array  = array(
   "gpa"          =>"GPA",
   "eligibility"  =>"Eligibility",
   "pass_list"    =>"Pass list",
   "mark_book"    =>"Mark Book",
   "transcpt"     =>"Transcript",
   "degree_cert"  =>"Degree Certificate"
);

$toolbar   =array(
   "eligibility"  =>array(
      'Save'   =>array('icon'=>'Save','action'=>'submit_form("modify")'),
      'CSV'      =>array('icon'=>'Database','action'=>'submit_form("csv")'),
      'Print'   =>array('icon'=>'Print','action'=>'submit_form("print")')
   ),
   "pass_list"  =>array(
      'Save'   =>array('icon'=>'Save','action'=>'submit_form("modify")'),
      'CSV'      =>array('icon'=>'Database','action'=>'submit_form("csv")'),
      'PDF'      =>array('icon'=>'NewPage','action'=>'submit_form("pdf")'),
      'Print'   =>array('icon'=>'Print','action'=>'submit_form("print")')
   ),
   "transcpt"      =>array(
      'Transcript'      =>array('action'=>'submit_form("transcpt")'),
      'Transcript PDF'   =>array('action'=>'submit_form("pdf")'),
      'Print'            =>array('icon'=>'Print','action'=>'submit_form("print")')
   ),
   "mark_book"      =>array(
      'help'      =>array('action'=>'help_dialog()')
   ),
   "degree_cert"      =>array(
      'Generate'      =>array('action'=>'submit_form("generate")')
   ),
   "gpa"         =>array(
      'PDF'      =>array('icon'=>'NewPage','action'=>'submit_form("pdf")'),
      'CSV'      =>array('icon'=>'Database','action'=>'submit_form("csv")'),
      'Print'   =>array('icon'=>'Print','action'=>'submit_form("print")')
   )

);

?>
