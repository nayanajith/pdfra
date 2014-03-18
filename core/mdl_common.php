<?php
$del_filter_inner="
<span>Show Filter</span>
   <div dojoType='dijit.TooltipDialog' preventCache=true refreshOnShow=true parseOnLoad=true doLayout=true align='center' href='".gen_url()."section=FILTER'>
   </div>
";
//-----------------KEY FIELDS OF THE MODEL----------------------
$KEYS=array(
);
//--------------FIELDS TO BE INCLUDED IN FORM-------------------
//---------------THIS ALSO REFLECT THE TABLE--------------------
$FORM=array(
);

$GRIDS=array(
);

//--------------FIELDS TO BE INCLUDED IN TOOLBAR----------------
$TOOLBAR=array();
if(!isset($LOAD_DEFAULT_TOOLBAR) || $LOAD_DEFAULT_TOOLBAR){
$TOOLBAR=array(
   "clear"=>array(
      "dojoType"=>"dijit.form.Button",
      "label"=>"Clear form",
      "iconClass"=>get_icon_class('Clear'),
      "showLabbel"=>'true',
      "onClick"=>'clear_form("main")',
   ),

   "add"=>array(
      "dojoType"=>"dijit.form.Button",
      "label"=>"Add",
      "iconClass"=>get_icon_class('addRecordIcon'),
      "showLabbel"=>'true',
      "onClick"=>'s_f_c_add("ok",reload_grid,grid__GRID);submit_form("add")',
   ),  
   "save"=>array(
      "dojoType"=>"dijit.form.Button",
      "label"=>"Save",
      "iconClass"=>get_icon_class('saveRecordIcon'),
      "showLabbel"=>'true',
      "onClick"=>'s_f_c_add("ok",reload_grid,grid__GRID);submit_form("modify")',
   ),  
   "remove"=>array(
      "dojoType"=>"dijit.form.Button",
      "label"=>"Delete",
      "iconClass"=>get_icon_class('deleteRecordIcon'),
      "showLabbel"=>'true',
      "onClick"=>'s_f_c_add("ok",reload_grid,grid__GRID);submit_form("delete")',
   ),
  "add_filter"=>array(
      "dojoType"=>"dijit.form.Button",
      "label"=>"Add fIlter",
      "iconClass"=>get_icon_class('addFilterIcon'),
      "showLabbel"=>'true',
      "onClick"=>'s_f_c_add("ok",reload_grid,grid__GRID);s_f_c_add("ok",w_e,toolbar__del_filter);submit_form("add_filter")',
   ),  
   "del_filter"=>array(
      "dojoType"=>"dijit.form.DropDownButton",
      //"disabled"=>(isset($_SESSION[PAGE]['FILTER'])?"false":"true"),
      "inner"=>$del_filter_inner,
      "iconClass"=>get_icon_class('showFilterIcon'),
      "showLabbel"=>'true',
   ),
   "csv"=>array(
      "dojoType"=>"dijit.form.DropDownButton",
      "label"=>"Export as CSV",
      "iconClass"=>get_icon_class('gridIcon'),
      "showLabbel"=>'true',
   ),
   "reload_grid"=>array(
      "dojoType"=>"dijit.form.Button",
      "label"=>"Reload grid",
      "iconClass"=>get_icon_class('reloadGridIcon'),
      "showLabbel"=>'true',
      "onClick"=>'reload_grid(grid__GRID)',
   ),
   "csv_grid"=>array(
      "dojoType"=>"dijit.form.Button",
      "label"=>"Grid to CSV",
      "iconClass"=>get_icon_class('gridConvIcon'),
      "showLabbel"=>'true',
      "onClick"=>'grid_to_csv(grid__GRID)',
   ),
   "print_grid"=>array(
      "dojoType"=>"dijit.form.Button",
      "label"=>"Grid print",
      "iconClass"=>get_icon_class('Print'),
      "showLabbel"=>'true',
      "onClick"=>'grid_print(grid__GRID,dojo.cookie("module")+"/"+dojo.cookie("page"))',
   ),
   "table_grid"=>array(
      "dojoType"=>"dijit.form.Button",
      "label"=>"Grid html",
      "iconClass"=>get_icon_class('htmlIcon'),
      "showLabbel"=>'true',
      "onClick"=>'grid_to_table(grid__GRID,dojo.cookie("module")+"/"+dojo.cookie("page"))',
   ),
);
}
$CALLBACKS=array(
   "add_record"=>array(
      "OK"     =>array(
         "func"   =>null,
         "vars"   =>array(),
         "status" =>false,
         "return" =>null
      ),  
      "ERROR"  =>array(
         "func"   =>null,
         "vars"   =>array(),
         "status" =>false,
         "return" =>null
      ),
   ),  
   "update_record"=>array(
      "OK"     =>array( 
         "func"   =>null,
         "vars"   =>array(),
         "status" =>false,
         "return" =>null
      ),
      "ERROR"  =>array(
         "func"   =>null,
         "vars"   =>array(),
         "status" =>false,
         "return" =>null
      ),
   ),  
   "delete_record"=>array(
      "OK"     =>array(
         "func"   =>null,
         "vars"   =>array(),
         "status" =>false,
         "return" =>null
      ),  
      "ERROR"  =>array(
         "func"   =>null,
         "vars"   =>array(),
         "status" =>false,
         "return" =>null
      ),
   ),  
);

//If the toolbar items not set for the given fields default will be added to the model.toolbar
foreach($TOOLBAR as $key => $arr){
   if(isset($GLOBALS['MODEL']['TOOLBAR'])){
      if(!isset($GLOBALS['MODEL']['TOOLBAR'][$key])){
         $GLOBALS['MODEL']['TOOLBAR'][$key]=$arr;
      }elseif($GLOBALS['MODEL']['TOOLBAR'][$key]){
         $GLOBALS['MODEL']['TOOLBAR'][$key]=$arr;
      }
   }else{
      $GLOBALS['MODEL']['TOOLBAR']=array();
   }
}

//For the read only users
if(get_page_access_right(MODULE, PAGE) == 'READ'){
   unset($GLOBALS['MODEL']['TOOLBAR']['add']);
   unset($GLOBALS['MODEL']['TOOLBAR']['remove']);
   unset($GLOBALS['MODEL']['TOOLBAR']['save']);
   unset($GLOBALS['MODEL']['TOOLBAR']['csv']);
   unset($GLOBALS['MODEL']['TOOLBAR']['csv_grid']);
   unset($GLOBALS['MODEL']['TOOLBAR']['table_grid']);
} 

?>
