<?php

$menu_array   = array(
   //"manage_programs"           =>"Programs",
   //"manage_course"           =>"Course",
   //"manage_exam"             =>"Exam",
   "manage_paper"            =>"Paper",
   "manage_answers"          =>"Answers",
   "manage_mcq_marking_logic"=>"Mark Logic",
   "process_csv"             =>"Process Answers csv",
   "process_db"              =>"Process Answers db",
   "reports"                 =>"Reports"
);

$toolbar   =array(
   "manage_programs"      =>array(
      'Add'      =>array('icon'=>'NewPage','action'=>'submit_form("add")'),
      'Save'   =>array('icon'=>'Save','action'=>'submit_form("modify")'),
      'Delete'   =>array('icon'=>'Delete','action'=>'submit_form("delete")'),
      'Grid'   =>array('icon'=>'Table','action'=>'grid()'),
      'Print'   =>array('icon'=>'Print')
   ),

   "manage_course"      =>array(
      'Add'      =>array('icon'=>'NewPage','action'=>'submit_form("add")'),
      'Save'   =>array('icon'=>'Save','action'=>'submit_form("modify")'),
      'Delete'   =>array('icon'=>'Delete','action'=>'submit_form("delete")'),
      'Search'   =>array('icon'=>'Search'),
      'CSV'      =>array('icon'=>'Database','action'=>'get_csv()'),
      'Grid'   =>array('icon'=>'Table','action'=>'grid()'),
      'Print'   =>array('icon'=>'Print'),
      'Add Filter'   =>array('icon'=>'Filter','action'=>'show_dialog()','dojoType'=>'dijit.form.Button','label'=>'Add Filter')
   ),
   "manage_exam"      =>array(
      'Add'      =>array('icon'=>'NewPage','action'=>'submit_form("add")'),
      'Save'   =>array('icon'=>'Save','action'=>'submit_form("modify")'),
      'Delete'   =>array('icon'=>'Delete','action'=>'submit_form("delete")'),
      'Search'   =>array('icon'=>'Search'),
      'CSV'      =>array('icon'=>'Database','action'=>'get_csv()'),
      'Grid'   =>array('icon'=>'Table','action'=>'grid()'),
      'Print'   =>array('icon'=>'Print'),
      'Add Filter'   =>array('icon'=>'Filter','action'=>'show_dialog()','dojoType'=>'dijit.form.Button','label'=>'Add Filter')
   ),
   "manage_paper"      =>array(
      'Add'      =>array('icon'=>'NewPage','action'=>'submit_form("add")'),
      'Save'   =>array('icon'=>'Save','action'=>'submit_form("modify")'),
      'Delete'   =>array('icon'=>'Delete','action'=>'submit_form("delete")'),
      'Search'   =>array('icon'=>'Search'),
      'CSV'      =>array('icon'=>'Database','action'=>'get_csv()'),
      'Grid'   =>array('icon'=>'Table','action'=>'grid()'),
      'Print'   =>array('icon'=>'Print'),
      'Add Filter'   =>array('icon'=>'Filter','action'=>'show_dialog()','dojoType'=>'dijit.form.Button','label'=>'Add Filter')
   ),

   "manage_answers"      =>array(
      'Add'      =>array('icon'=>'NewPage','action'=>'submit_form("add")'),
      'Save'   =>array('icon'=>'Save','action'=>'submit_form("modify")'),
      'Delete'   =>array('icon'=>'Delete','action'=>'submit_form("delete")'),
      'Search'   =>array('icon'=>'Search'),
      'CSV'      =>array('icon'=>'Database','action'=>'get_csv()'),
      'Grid'   =>array('icon'=>'Table','action'=>'grid()'),
      'Print'   =>array('icon'=>'Print'),
      'Add Filter'   =>array('icon'=>'Filter','action'=>'show_dialog()','dojoType'=>'dijit.form.Button','label'=>'Add Filter')
   ),

   "process_csv"   => array(
      'Extract'         =>array('icon'=>'Function','action'=>'submit_form("extract")'),
      'Item Analysis'   =>array('icon'=>'Function','action'=>'submit_form("item")'),
      'Mark Answers'      =>array('icon'=>'Function','action'=>'submit_form("mark")'),
      'CSV'      =>array('icon'=>'Database','action'=>'submit_form("data&data=csv")')
   ),

   "process_db"   => array(
      'Extract'         =>array('icon'=>'Function','action'=>'submit_form("extract")'),
      'Item Analysis'   =>array('icon'=>'Function','action'=>'submit_form("item")'),
      'Mark Answers'      =>array('icon'=>'Function','action'=>'submit_form("mark")'),
      'CSV'      =>array('icon'=>'Database','action'=>'submit_form("data&data=csv")')
   ),
   "reports"   => array(
      'Generate'      =>array('icon'=>'Function','action'=>'submit_form("generate")'),
      'View'      =>array('icon'=>'Function','action'=>'submit_form("view")')
   )

);


?>
