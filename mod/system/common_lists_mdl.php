<?php
$GLOBALS['MODEL']=array(
//-----------------KEY FIELDS OF THE MODEL----------------------
   'KEYS'=>array(
      'PRIMARY_KEY'	=>'rid',
      'UNIQUE_KEY'	=>array('list_name'),
      'MULTY_KEY'	=>array(''),
   ),
//--------------FIELDS TO BE INCLUDED IN FORM-------------------
//---------------THIS ALSO REFLECT THE TABLE--------------------
   'FORM'=>array(
      "rid"=>array(
         "length"	=>"70",
         "dojoType"	=>"dijit.form.NumberTextBox",
         "type"	=>"hidden",
         "required"	=>"false",
         "label"	=>"Rid",
         "label_pos"	=>"top",
         "value"=>""
      ),
      "list_name"=>array(
         "length"	=>"350",
         "dojoType"	=>"dijit.form.ValidationTextBox",
         "required"	=>"true",
         "label"	=>"List name",
         "label_pos"	=>"top",
         "value"=>""
      ),
      "list_label"=>array(
         "length"	=>"350",
         "dojoType"	=>"dijit.form.ValidationTextBox",
         "required"	=>"true",
         "label"	=>"List label",
         "label_pos"	=>"top",
         "value"=>""
      ),
      "json"=>array(
         "length"	=>"100",
         "dojoType"	=>"dijit.form.SimpleTextarea",
         "required"	=>"true",
         "label"	=>"Json",
         "label_pos"	=>"top",
         "value"=>""
      ),
   ),
//--------------FIELDS TO BE INCLUDED IN TOOLBAR----------------
   'GRIDS'=>array(
       'GRID'=>array(
          'columns'      =>array('rid','list_name'),
          'filter'       =>isset($_SESSION[PAGE]['FILTER'])?$_SESSION[PAGE]['FILTER']:null,
          'selector_id'  =>'toolbar__rid',
          'ref_table'    =>$GLOBALS['S_TABLES']['common_lists'],
          'event_key'    =>'rid',
          'dojoType'     =>'dojox.grid.DataGrid',
          'jsId'         =>'main_grid',
          'store'        =>'main_grid_store' ,
          'query'        =>'{ "rid": "*" }',
          'rowsPerPage'  =>'40',
          'clientSort'   =>'true',
          'style'        =>'width:100%;height:400px',
          'onClick'      =>'load_grid_item',
          'rowSelector'  =>'20px',
          'columnReordering'=>'true',
          'headerMenu'   =>'gridMenu',
       ),
    ),
   'TOOLBAR'=>array(
      "rid"=>array(
         "length"=>"170",
         "dojoType"=>"dijit.form.FilteringSelect",
         "required"=>"false",
         "label"=>"Label",
         "label_pos"=>"left",

         "onChange"=>'set_param(this.name,this.value);fill_form(this.value,"main")',
         "searchAttr"=>"label",
         "pageSize"=>"10",
         "store"=>"rid_store",

         "filter"=>isset($_SESSION[PAGE]['FILTER'])?" AND ".$_SESSION[PAGE]['FILTER']:null,
         "ref_table"=>$GLOBALS['S_TABLES']['common_lists'],
         "ref_key"=>'rid',
         "order_by"=>'ORDER BY rid DESC',
         "vid"=>array('list_name'),
      ),  

      "clear"=>array(
         "dojoType"=>"dijit.form.Button",
         "label"=>"Clear form",
         "iconClass"=>get_icon_class('Clear'),
         "showLabbel"=>'true',
         "onClick"=>'clear_form("main")',
         //"onClick"=>'load_selected_value(toolbar__rid,"NULL")',
      ),

      "add"=>array(
         "dojoType"=>"dijit.form.Button",
         "label"=>"Add",
         "iconClass"=>get_icon_class('NewPage'),
         "showLabbel"=>'true',
         "onClick"=>'submit_form("add");reload_grid(main_grid)',
      ),  
      "modify"=>array(
         "dojoType"=>"dijit.form.Button",
         "label"=>"Modify",
         "iconClass"=>get_icon_class('Save'),
         "showLabbel"=>'true',
         "onClick"=>'submit_form("modify");reload_grid(main_grid)',
      ),  
      "remove"=>array(
         "dojoType"=>"dijit.form.Button",
         "label"=>"Delete",
         "iconClass"=>get_icon_class('Delete'),
         "showLabbel"=>'true',
         "onClick"=>'submit_form("delete");reload_grid(main_grid)',
      ),
     "add_filter"=>array(
         "dojoType"=>"dijit.form.Button",
         "label"=>"Add fIlter",
         "iconClass"=>get_icon_class('Filter'),
         "showLabbel"=>'true',
         "onClick"=>'submit_form("add_filter");reload_grid(main_grid)',
      ),  
      "del_filter"=>array(
         "dojoType"=>"dijit.form.Button",
         "label"=>"Delete filter",
         "iconClass"=>get_icon_class('Cancel'),
         "showLabbel"=>'true',
         "onClick"=>'submit_form("del_filter");reload_grid(main_grid)',
      ),
      "reload_grid"=>array(
         "dojoType"=>"dijit.form.Button",
         "label"=>"Reload grid",
         "iconClass"=>get_icon_class('Undo'),
         "showLabbel"=>'true',
         "onClick"=>'reload_grid(main_grid)',
      ),
   ),
   'WIDGETS'=>array(
   ),
);
?>
