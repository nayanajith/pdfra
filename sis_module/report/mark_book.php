<?php
//include A_CLASSES."/data_entry_class.php";
include A_CLASSES."/xhr_combobox_class.php";
$xhr_combobox=new XHR_Combobox();


//id table mapper array
$table_of_id=array(
	'batch_id'=>$GLOBALS['P_TABLES']['batch'],
	'from_exam_date'=>$GLOBALS['P_TABLES']['exam'],
	'to_exam_date'=>$GLOBALS['P_TABLES']['exam'],
);

//Map filter for the given id
$filter_map=array(
	'from_exam_date'=>isset($_SESSION[PAGE]['admission_year'])?" YEAR(exam_date)>='".$_SESSION[PAGE]['admission_year']."'":null,
);

//Map filter for the given id
$order_by_map=array(
	'batch_id'=>'ORDER BY batch_id DESC',
	'from_exam_date'=>'ORDER BY exam_date DESC',
	'to_exam_date'=>'ORDER BY exam_date DESC',
);


//Request functoin switcher
if(isset($_REQUEST['form'])){
	switch($_REQUEST['form']){
      case 'main':
		if(isset($_REQUEST['action'])){
			switch($_REQUEST['action']){
			case 'pdf':
			case 'print':
			case 'html':
				@$_SESSION[PAGE]['batch_id']=$_REQUEST['batch_id'];
				print_gpa();
			break;
			case 'store':
				$filter=null;
				if(isset($filter_map[$_REQUEST['id']])){
					$filter=$filter_map[$_REQUEST['id']];
				}

				if(isset($order_by_map[$_REQUEST['id']])){
					$order_by=$order_by_map[$_REQUEST['id']];
				}

            if($_REQUEST['id']=='from_exam_date' || $_REQUEST['id']=='to_exam_date'){
				   $xhr_combobox->json_data($table_of_id[$_REQUEST['id']],'exam_date',$filter,$order_by,$_REQUEST['id']);
            }else{
				   $xhr_combobox->json_data($table_of_id[$_REQUEST['id']],$_REQUEST['id'],$filter,$order_by);
            }
			break;
			case 'param':
				$_SESSION[PAGE][$_REQUEST['param']]=$_REQUEST[$_REQUEST['param']];
            if($_REQUEST['param']=='batch_id'){
               //Getting year of the batch to use with exam_hid filter
               $arr=exec_query("SELECT admission_year FROM ".$GLOBALS['P_TABLES']['batch']." WHERE batch_id='".$_REQUEST['batch_id']."'",Q_RET_ARRAY);
				   $_SESSION[PAGE]['admission_year']=$arr[0]['admission_year'];
            }
				return_status_json('OK',"Set ".$_REQUEST['param']."=".$_REQUEST[$_REQUEST['param']]);
			break;
			}
		}
	}
}else{
   echo "<div align='center'>";
   echo "<div id='mark_book_frm' jsId='mark_book_frm' dojoType='dijit.form.Form' >";
	if(isset($_SESSION[PAGE]['batch_id'])){
      print_gpa();
	}	
	echo "</div></div>";

	echo "<script type='text/javascript'>";
	echo "dojo.addOnLoad(function() {";

	$xhr_combobox->gen_xhr_combobox('batch_id',"Batch",$xhr_combobox->get_val('batch_id'),80,20,null,null);
	$xhr_combobox->gen_xhr_static_combo('student_year',"Study year",$xhr_combobox->get_val('student_year'),40,array(1,2,3,4),null,null);
	$xhr_combobox->gen_xhr_combobox('from_exam_date',"From exam",$xhr_combobox->get_val('from_exam_date'),80,20,null,null);
	$xhr_combobox->gen_xhr_combobox('to_exam_date',"To exam",$xhr_combobox->get_val('to_exam_date'),80,20,null,null);
   echo "
	var reload_button=new dijit.form.Button({
		iconClass:'dijitIcon dijitIconFunction',
		label: 'Generate',
		onClick:function(){request_html('mark_book_frm',new Array('batch_id','from_exam_date','to_exam_date'),null);},
	});
	toolbar.addChild(reload_button);";


	$xhr_combobox->param_setter();
	echo "});";
	$xhr_combobox->form_submitter('mark_book_frm');
	echo "</script>";
}

function print_gpa(){
}
?>
