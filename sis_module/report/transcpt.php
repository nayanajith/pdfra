<?php
//include A_CLASSES."/data_entry_class.php";
include A_CLASSES."/xhr_combobox_class.php";
$xhr_combobox=new XHR_Combobox();


//id table mapper array
$table_of_id=array(
	'index_no'=>$GLOBALS['P_TABLES']['student'],
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
			case 'transcript':
				transcript();
			break;
			case 'pdf':
				transcript_pdf();
			break;
			case 'push':
				push();
			break;
			case 'cert':
				gen_certificate();
			break;
			case 'print':
				transcript();
			break;
			case 'html':
				$_SESSION[PAGE]['index_no']=$_REQUEST['index_no'];
				transcript();
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
	echo "<div><div id='attendance_frm' jsId='attendance_frm' dojoType='dijit.form.Form' >";
	if(isset($_SESSION[PAGE]['index_no'])){
		transcript();
	}	
	echo "</div></div>";

	echo "<script type='text/javascript'>";
	echo "dojo.addOnLoad(function() {";

	//function gen_xhr_combobox($id,$label,$value,$width,$page_size,$source_array=null,$target=null);
	//$xhr_combobox->gen_xhr_combobox('student_year',"Student Year",$xhr_combobox->get_val('student_year'),30,20,null,null);
	$xhr_combobox->gen_xhr_combobox('index_no',"Index No",$xhr_combobox->get_val('index_no'),80,20,array('index_no'),'attendance_frm');
	//Different report types to be select
	$item_array=array('WITH_MARkS','WITHOUT_MARkS');
	$xhr_combobox->gen_xhr_static_combo('transcpt_marks','Marks',$xhr_combobox->get_val('transcpt_marks'),110,$item_array,array('index_no','transcpt_marks'),'attendance_frm');

	$item_array=array('SUBJECT_TO_APPROVED_BY_SENNATE','PENDING');
	$xhr_combobox->gen_xhr_static_combo('transcpt_note','Note',$xhr_combobox->get_val('transcpt_note'),210,$item_array,array('index_no','transcpt_marks'),'attendance_frm');

	$xhr_combobox->param_setter();
	echo "});";
	$xhr_combobox->form_submitter('attendance_frm');
	echo "</script>";
}



function transcript(){
	include A_CLASSES."/student_class.php";
	$student = new Student($_SESSION[PAGE]['index_no']);
	$trancpt_detail=$student->getTranscript();

	//total information other than subject breakdown to be printed in transcript
	$transcript=array(
		'index_no'	=>$_SESSION[PAGE]['index_no'],
      'fullname'	=>$student->getName(2),
      'RegNo'		=>$student->getRegNo(),
      'DIssue'		=>date("Y-m-d"),
      'dgrad'		=>$trancpt_detail['YOA'],
      'dreg'		=>$trancpt_detail['DOA'],
  	  	'DegreeName'=>$trancpt_detail['DEGREE'],
  		'DClass'		=>$trancpt_detail['CLASS'],
  		'GPA'			=>$trancpt_detail['GPA']
	);

	//print students personal information
	echo "<table>";
	foreach( $transcript as $key => $value){
		echo "<tr><th align=left>$key</th><td>$value</td></tr>";	
	}
	echo "</table>";

	//Print studetns socoring on each course in each year
	for($i=1;$i<=4;$i++){
		if($student->getYearCGPV($i)<=0)continue;
		echo "<h2>Year-".$i."</h2>";
		echo "Year GPA: ".round($student->getYearCGPV($i)/$student->getYearCredits($i),2);
		echo "<table>";
		foreach($student->getYearMarks($i) as $key => $course ){
			echo "<tr>";
			foreach($course as $key => $value){
				echo "<td>$value</td>";	
			}
			echo "</tr>";
		}
		echo "</table>";
	}
}

function transcript_pdf(){
	include(MOD_CLASSES."/transcript1_pdf_class.php");
	//include(MOD_CLASSES."/transcript2_pdf_class.php");
	//Generate the transcript
	$with_marks=false;
	if(isset($_SESSION[PAGE]['transcpt_marks']) && $_SESSION[PAGE]['transcpt_marks'] == 'WITH_MARKS'){
		$with_marks=true;
	}
	$transcript=new Transcript($_SESSION[PAGE]['index_no'],$with_marks);

	//Acquire pdf document
	$pdf=$transcript->getPdf();

	$pdf->Output('transcript.pdf', 'I');
	//$pdf->Output(TMP."/".$_SESSION[PAGE]['index_no']."_transcript.pdf", 'F');
	//return $pdf_file;
}

function gen_certificate(){
	echo "cert";
}
?>
