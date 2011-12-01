<?php
$menu_array  = array(
   "summary"        =>"Summary",
   "manage_exam"    =>"Manage Exam",
   "manage_rubric"=>"Manage Rubric",
   "upload_marks"   =>"Upload Marks",
   "reports"      =>"Reports"
);

$toolbar   =array(
   "manage_exam"      =>array(
      'Add'      =>array('icon'=>'NewPage','action'=>'submit_form("add")'),
      'Save'   =>array('icon'=>'Save','action'=>'submit_form("modify")'),
      'Delete'   =>array('icon'=>'Delete','action'=>'submit_form("delete")'),
      'CSV'      =>array('icon'=>'Database','action'=>'get_csv()'),
      'Grid'   =>array('icon'=>'Table','action'=>'grid()'),
      'Print'   =>array('icon'=>'Print'),
      'Add Filter'   =>array('icon'=>'Filter','action'=>'show_dialog()','dojoType'=>'dijit.form.Button','label'=>'Add Filter')
   ),
   "manage_rubric"      =>array(
      'Add'      =>array('icon'=>'NewPage','action'=>'submit_form("add")'),
      'Save'   =>array('icon'=>'Save','action'=>'submit_form("modify")'),
      'Delete'   =>array('icon'=>'Delete','action'=>'submit_form("delete")'),
      'CSV'      =>array('icon'=>'Database','action'=>'get_csv()'),
      'Grid'   =>array('icon'=>'Table','action'=>'grid()'),
      'Print'   =>array('icon'=>'Print'),
      'Add Filter'   =>array('icon'=>'Filter','action'=>'show_dialog()','dojoType'=>'dijit.form.Button','label'=>'Add Filter')
   ),
   "manage_marks"      =>array(
      'Add'      =>array('icon'=>'NewPage','action'=>'submit_form("add")'),
      'Save'   =>array('icon'=>'Save','action'=>'submit_form("modify")'),
      'Delete'   =>array('icon'=>'Delete','action'=>'submit_form("delete")'),
      'CSV'      =>array('icon'=>'Database','action'=>'get_csv()'),
      'Grid'   =>array('icon'=>'Table','action'=>'grid()'),
      'Print'   =>array('icon'=>'Print'),
      'Add Filter'   =>array('icon'=>'Filter','action'=>'show_dialog()','dojoType'=>'dijit.form.Button','label'=>'Add Filter')
   ),

   "upload_marks"=>array(
      'Save'   =>array('icon'=>'Save','action'=>'submit_form("modify")'),
      'Print'   =>array('icon'=>'Print','action'=>'submit_form("print")')
   ),
   "reports"=>array(
      'Help'   =>array('icon'=>'Help','action'=>'help_dialog()'),
      'CSV'   =>array('icon'=>'Database','action'=>'submit_form("modify")'),
      'Print'   =>array('icon'=>'Print','action'=>'submit_form("print")'),
      'PDF'   =>array('icon'=>'NewPage','action'=>'submit_form("pdf")')
   ),
   "summery" => array(
      'Print'   =>array('icon'=>'Print','action'=>'submit_form("print")')
   )
);

?>
