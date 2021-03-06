<?php
$modules_have_schema=array('core'=>'Core');
foreach($GLOBALS['MODULES'] as $key => $value){
   $schema_file=A_MODULES."/".$key."/core/database_schema.php";
   if(file_exists($schema_file)){
      if(is_array($value))$value=$value['MODULE'];
      $modules_have_schema[$key]=$value;
   }
}
$schema_module_inner=gen_select_inner($modules_have_schema,null,true);

//Disable deafult toolbar controls loading
$LOAD_DEFAULT_TOOLBAR=false;

$GLOBALS['MODEL']=array(
//-----------------KEY FIELDS OF THE MODEL----------------------
   'KEYS'=>array(
   ),
//--------------FIELDS TO BE INCLUDED IN FORM-------------------
//---------------THIS ALSO REFLECT THE TABLE--------------------
   'FORM'=>array(
   ),
//--------------FIELDS TO BE INCLUDED IN TOOLBAR----------------
   'GRIDS'=>array(
   ),
   'TOOLBAR'=>array(
      "schema_module"=>array(
         "length"=>"170",
         "dojoType"=>"dijit.form.Select",
         "required"=>"false",
         "label"=>"Module",
         "label_pos"=>"left",
         "onMouseOver"=>'reloading_on()',
         "onChange"=>'s_p_c_add("ok",reload_page,null);set_param(this.id,this.value)',
         "inner"=>$schema_module_inner,
      ),
      "create"=>array(
         "dojoType"=>"dijit.form.Button",
         "label"=>"Create/Re-create",
         "iconClass"=>get_icon_class('dbProcessIcon'),
         "showLabbel"=>'true',
         "onMouseOver"=>'reloading_on()',
         "onClick"=>'xhr_c_add("ok",reload_page);xhr_generic("create_tables","create","json")',
      ),
      "migrate"=>array(
         "dojoType"=>"dijit.form.Button",
         "label"=>"Migrate",
         "iconClass"=>get_icon_class('dbMigrateIcon'),
         "showLabbel"=>'true',
         "onMouseOver"=>'reloading_on()',
         "onClick"=>'xhr_c_add("ok",reload_page);xhr_generic("db_migrate","migrate","json")',
      ),
   ),
   'WIDGETS'=>array(
   ),
);

//add_to_model('true','TOOLBAR','migrate','disabled');
include "db_admin_mdl.inc.php";
?>
