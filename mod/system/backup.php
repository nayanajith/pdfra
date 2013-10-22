<?php
$GLOBALS['PAGE']=array(
   'name'                =>'backup',
   'table'               =>null,
   'primary_key'         =>null,
   'filter_table'        =>null,
   'filter_primary_key'  =>null,

);

//Common control swithces included
include A_CORE."/ctrl_common.php";


if(isset($_REQUEST['action']) && $_REQUEST['action']=='add_backup'){
   backup_now();
}

if(isset($_REQUEST['action']) && $_REQUEST['action']=='del_backup'){
   del_backup();
}

if(isset($_REQUEST['action']) && $_REQUEST['action']=='res_backup'){
   res_backup();
}

if(isset($_REQUEST['action']) && $_REQUEST['action']=='act_db'){
   activate_db();
}

if(isset($_REQUEST['file_id']) && isset($_FILES[$_REQUEST['file_id']."s"])){
   upl_backup();
}


?>
