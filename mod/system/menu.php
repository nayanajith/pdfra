<?php

$menu_array  = array(
//   "modules"            =>"Modules",
   "status"             =>"Status",
   "users"              =>"Users",
   "role"               =>"Roles",
   "manage_permission"  =>"Manage Permission",
   "permission"         =>"Manage Permission (Manual)",
   "base_data"          =>"Base Data",
//   "reset_password"     =>array("label"=>"Reset Password","visible"=>"true"),
   "activity"           =>"Activity Log",
   "system_log"         =>"System Log",
   "backup"             =>"Database Backup",
   "db_admin"           =>"Database Upgrade/Migrate",
 //  "init_db"            =>"Regenerate Database",
);

$toolbar   =array(
   "manage_permission"      =>array(
      'Save'   =>array('icon'=>'Save','action'=>'submit_form_("modify")'),
   ),
   "system_log"      =>array(
      'Print'   =>array('icon'=>'Print','action'=>'print_data()'),
      'Number of Lines'   =>array('icon'=>'Filter','dojoType'=>'dijit.form.NumberTextBox','name'=>'numLines','id'=>'numLines','style'=>'width:50px','action'=>'null'),
      'Update'   =>array('icon'=>'Process','action'=>'get_lines()')
   )
);


?>
