<?php
//include A_CLASSES."/data_entry_class.php";
include A_CLASSES."/xhr_combobox_class.php";
$xhr_combobox=new XHR_Combobox();


//id table mapper array
$table_of_id=array(
	'batch_id'=>$GLOBALS['P_TABLES']['batch'],
);

//Map filter for the given id
$filter_map=array(
);



//Request functoin switcher
if(isset($_REQUEST['form'])){
	switch($_REQUEST['form']){
      case 'main':
		if(isset($_REQUEST['action'])){
			switch($_REQUEST['action']){
			case 'gpa':
				gen_gpa();
			break;
			case 'pdf':
				gpa_pdf();
			break;
			case 'html':
				$_SESSION[PAGE]['batch_id']=$_REQUEST['batch_id'];
				gen_gpa();
			break;
			case 'store':
				$filter=null;
				if(isset($filter_map[$_REQUEST['id']])){
					$filter=$filter_map[$_REQUEST['id']];
				}
				$xhr_combobox->json_data($table_of_id[$_REQUEST['id']],$_REQUEST['id'],$filter);
			break;
			case 'param':
				$_SESSION[PAGE][$_REQUEST['param']]=$_REQUEST[$_REQUEST['param']];
				return_status_json('OK',"Set ".$_REQUEST['param']."=".$_REQUEST[$_REQUEST['param']]);
			break;
			}
		}
		case 'filter':
		break;
	}
}else{
	echo "<div align='center'><div id='gpa_frm' jsId='gpa_frm' dojoType='dijit.form.Form' >";
	if(isset($_SESSION[PAGE]['index_no'])){
		transcript();
	}	
	echo "</div></div>";

	echo "<script type='text/javascript'>";
	echo "dojo.addOnLoad(function() {";

	//function gen_xhr_combobox($id,$label,$value,$width,$page_size,$source_array=null,$target=null);
	//$xhr_combobox->gen_xhr_combobox('student_year',"Student Year",$xhr_combobox->get_val('student_year'),30,20,null,null);
	$xhr_combobox->gen_xhr_combobox('batch_id',"Batch",$xhr_combobox->get_val('batch_id'),80,20,array('batch_id'),'gpa_frm');
	$xhr_combobox->param_setter();
	echo "});";
	$xhr_combobox->form_submitter('gpa_frm');
	echo "</script>";
}

function gen_gpa(){
	include A_CLASSES."/student_class.php";
	$arr=exec_query("SELECT index_no FROM ".$GLOBALS['P_TABLES']['student']." WHERE index_no LIKE '".$_SESSION[PAGE]['batch_id']."%'",Q_RET_ARRAY,null,'index_no');
	foreach(array_keys($arr) as $index_no){
		$student = new Student($index_no);
		$row=array(
			'index_no'=>$index_no,
			'degree_class'=>$student->getClass($student->getCGPA()),
			'GPV1'=>round($student->getYearCGPV(1),4),
			'credits1'=>$student->getYearCredits(1),
			'GPA1'=>round($student->getYearCGPA(1),4),
			'GPV2'=>round($student->getYearCGPV(2),4),
			'credits2'=>$student->getYearCredits(2),
			'GPA2'=>round($student->getYearCGPA(2),4),
			'GPV3'=>round($student->getYearCGPV(3),4),
			'credits3'=>$student->getYearCredits(3),
			'GPA3'=>round($student->getYearCGPA(3),4),
			'GPV4'=>round($student->getYearCGPV(4),4),
			'credits4'=>$student->getYearCredits(4),
			'GPA4'=>round($student->getYearCGPA(4),4),
			'GPV'=>round($student->getCGPV(),4),
			'GPA'=>round($student->getCGPA(),4),
			'credits'=>$student->getTotalCredits(),
		);
		exec_query("REPLACE INTO ".$GLOBALS['P_TABLES']['gpa']."(".implode(array_keys($row),",").")values('".implode(array_values($row),"','")."')",Q_RET_NONE);
	}

	$row=array(
		'index_no',
		'degree_class',
		'GPV1',
		'credits1',
		'GPA1',
		'GPV2',
		'credits2',
		'GPA2',
		'GPV3',
		'credits3',
		'GPA3',
		'GPV4',
		'credits4',
		'GPA4',
		'GPV',
		'GPA',
		'credits',
	);
	$arr=exec_query("SELECT ".implode($row,",")." FROM ".$GLOBALS['P_TABLES']['gpa']." WHERE index_no LIKE '".$_SESSION[PAGE]['batch_id']."%'",Q_RET_ARRAY,null,'index_no');
	echo "<table>";
	echo "<tr><th>".implode($row,"</th><th>")."</th></tr>";
	foreach($arr as $index_no => $row){
		echo "<tr><td>$index_no</td><td>".implode(array_values($row),"</td><td>")."</td></tr>";
	}
	echo "</table>";
}

?>
