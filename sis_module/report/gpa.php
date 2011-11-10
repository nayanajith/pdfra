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
	echo "<div><div id='gpa_frm' jsId='gpa_frm' dojoType='dijit.form.Form' >";
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
	echo "<table style='border-collapse:collapse' border='1'>";
	$header=array("Index No","Credit Y1","Credit Y2","Credit Y3","Credit Y4","GPV Y1","GPV Y2","GPV Y3","GPV Y4","GPV T(C)","GPV T(D)","GPA(C)","GPA(D)");
	echo "<tr>";
	echo "<th>".implode($header,"</th><th>")."</th>";
	echo "</tr>";

	foreach(array_keys($arr) as $index_no){
		$student = new Student($index_no);
		$row=array(
			$index_no,
			$student->getYearCredits(1),
			$student->getYearCredits(2),
			$student->getYearCredits(3),
			$student->getYearCredits(4),
			round($student->getYearCGPV(1),2),
			round($student->getYearCGPV(2),2),
			round($student->getYearCGPV(3),2),
			round($student->getYearCGPV(4),2),
			round($student->getCGPV(),2),
			round($student->getDGPV(),2),
			round($student->getCGPA(),2),
			round($student->getDGPA(),2)
		);
		echo "<tr>";
		echo "<td>".implode($row,"</td><td>")."</td>";
		echo "</tr>";
	}
	echo "</table>";
}

function gpa_pdf(){
	include(MOD_CLASSES."/transcript_pdf_class.php");
	//Generate the transcript
	$transcript=new Transcript($_REQUEST['index_no']);

	//Acquire pdf document
	$pdf=$transcript->getPdf();

	//$pdf->Output('payment_transcript.pdf', 'I');
	$pdf->Output("/tmp/tt.pdf", 'F');
	//return $pdf_file;
}

?>
