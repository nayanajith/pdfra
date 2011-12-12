<?php
include A_CLASSES."/data_entry_class.php";
$super_table		='batch';
$keys					=array('batch_id');
$key1					='batch_id';
$grid_array			=array('batch_id','start_date','end_date');
$grid_array_long	=array('batch_id','description','start_date','end_date');

$table				=$GLOBALS['MOD_P_TABLES'][$super_table];
$formgen 			=null;

$file_name        ="manage_batches";

$formgen 		   = new Formgenerator($table,$keys,$file_name,null);

$help_file			=$file_name."_help.php";
$modif_file			=$file_name."_modif.php";
$filter_string		="";



if(isset($_REQUEST['form'])){
	switch($_REQUEST['form']){
      case 'main':
			if(isset($_REQUEST['action'])){
				switch($_REQUEST['action']){
				 case 'add':
					return $formgen->add_record();
				 break;
				 case 'modify':
					return $formgen->modify_record();
				 break;
				 case 'delete':
					return $formgen->delete_record();
				 break;
				}	
			}else{
				if(isset($_REQUEST['data'])&&$_REQUEST['data']=='json'){
					if(isset($_REQUEST['id'])){
						$formgen->xhr_form_filler_data($_REQUEST['id']);
					}else{
						$formgen->xhr_filtering_select_data();
					}
				}
			}
		break;
		case 'filter':
			if(isset($_REQUEST['action'])){
				switch($_REQUEST['action']){
				 case 'add':
					return $formgen->add_filter();
				 break;
				 case 'modify':
					return $formgen->modify_filter();
				 break;
				 case 'delete':
					return $formgen->delete_filter();
				 break;

				}	
			}else{
				if(isset($_REQUEST['data'])&&$_REQUEST['data']=='json'){
					if(isset($_REQUEST['id'])){
						$formgen->xhr_filter_filler_data($_REQUEST['id']);
					}else{
						$formgen->xhr_filtering_select_data($GLOBALS['MOD_P_TABLES']['filter'],'filter_id',true);
					}

				}
			}
		break;
		case 'grid':
			echo $formgen->gen_data_grid($grid_array,null,$key1);
		break;
	}
}else{
echo "<table width=100%><tr><td style='vertical-align:top;valign:top'>";
	echo $formgen->gen_form(null,true);
	echo $formgen->gen_filter();
	echo "
		<script language='javascript'>
			function grid(){
            url='".gen_url().(isset($_REQUEST['filter_name'])?"&filter_name=".$_REQUEST['filter_name']:"")."&form=grid';
				open(url,'_self');
			}
		</script>
	";
echo "</td><td width=40% style='vertical-align:top;valign:top'>";
   echo $formgen->gen_data_grid($grid_array,null,$key1);
echo "</td></tr></table>";

$formgen->filter_selector();

//generate help tips 
include $help_file;
$formgen->set_help_tips($help_array);
echo "<script language='javascript'>";
echo $formgen->param_setter();
echo "</script>";

}


?>