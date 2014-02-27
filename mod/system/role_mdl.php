<?php
$theme_inner      =gen_select_inner(get_common_list('theme',true),null,true);
$layout_inner     =gen_select_inner(get_common_list('layout',true),null,true);

$GLOBALS['MODEL']=array(
//-----------------KEY FIELDS OF THE MODEL----------------------
   'KEYS'=>array(
      'PRI'	=>array('rid'),
      'UNI'	=>array('role_id'=>array('role_id')),
      'MUL'	=>array(),
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
      "role_id"=>array(
         "length"	=>"350",
         "dojoType"	=>"dijit.form.ValidationTextBox",
         "required"	=>"true",
         "label"	=>"Role name",
         "label_pos"	=>"top",
         "value"=>""
      ),
      "file_prefix"=>array(
         "length"	=>"70",
         "dojoType"	=>"dijit.form.ValidationTextBox",
         "required"	=>"true",
         "label"	=>"File prefix",
         "label_pos"	=>"top",
         "value"=>""
      ),
      "layout"=>array(
         "length"	=>"70",
         "dojoType"	=>"dijit.form.Select",
         "required"	=>"true",
         "label"	=>"Layout",
         "inner"  =>$layout_inner,
         "label_pos"	=>"top",
         "value"=>""
      ),
      "theme"=>array(
         "length"	=>"70",
         "dojoType"	=>"dijit.form.Select",
         "required"	=>"true",
         "label"	=>"Theme",
         "inner"  =>$theme_inner,
         "label_pos"	=>"top",
         "value"=>""
      ),
      "description"=>array(
         "length"	=>"350",
         "dojoType"	=>"dijit.form.ValidationTextBox",
         "required"	=>"true",
         "label"	=>"Description",
         "label_pos"	=>"top",
         "value"=>""
      ),
   ),
   'GRIDS'=>array(
       'GRID'=>array(
          'columns'      =>array('rid'=>array('hidden'=>'true'),'role_id','file_prefix','layout','theme'),
          'filter'       =>isset($_SESSION[PAGE]['FILTER'])?$_SESSION[PAGE]['FILTER']:null,
          'selector_id'  =>'toolbar__rid',
          'ref_table'    =>s_t('role'),
          'order_by'     =>'ORDER BY rid DESC',
          'event_key'    =>'rid',
          'dojoType'     =>'dojox.grid.EnhancedGrid',
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
//--------------FIELDS TO BE INCLUDED IN TOOLBAR----------------
   'TOOLBAR'=>array(
      "rid"=>array(
         "length"=>"100",
         "dojoType"=>"dijit.form.FilteringSelect",
         "required"=>"false",
         "label"=>"Role",
         "label_pos"=>"left",

         "onChange"=>'s_p_c_add("ok",fill_form,this.value);set_param(this.id,this.value,this.displayedValue)',
         "searchAttr"=>"label",
         "pageSize"=>"10",
         "store"=>"rid_store",

         "filter"=>get_filter(null,true),
         "ref_table"=>s_t('role'),
         "ref_key"=>'rid',
         "order_by"=>'ORDER BY rid DESC',
         "vid"=>array('role_id'),
      ),  

   ),
   'WIDGETS'=>array(
   ),
);
?>
