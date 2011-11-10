<?php
include A_CLASSES."/xhr_combobox_class.php";
$xhr_combobox=new XHR_Combobox();


//Columns of the mark uploading table
$report_types=array(
	'LMS'=>array(
      'final_mark'
	),
	'FULL'=>array(
		'can_release',
		'assignment_mark',
		'paper_mark',
      'final_mark',
		'push'
	),
	'VERIFY'=>array(
		'can_release',
      'final_mark',
		'push'
	),
);

$columns=$report_types['FULL'];
if(isset($_SESSION[PAGE]['report_type'])){
	$columns=$report_types[$_SESSION[PAGE]['report_type']];
}


//Fill the available marks to the table while generating the table
function gen_report(){
	global $columns;
	$arr_rubric=exec_query("SELECT * FROM ".$GLOBALS['P_TABLES']['rubric']." WHERE  course_id='".$_SESSION[PAGE]['course_id']."' AND exam_hid='".$_SESSION[PAGE]['exam_hid']."'",Q_RET_ARRAY);
	$report='';
	if(!isset($arr_rubric[0])){
		echo "Rubric not set!";	
		return;
	}

		$report="
<style>
.report_table{

}

.report_table td{
	text-align:center;
}

.report_table th{
	text-align:center;
	font-weight:bold;
}
</style>	
	";
	//Registered students for a given course in given exam
	$reg_arr=exec_query("SELECT index_no,attendance FROM ".$GLOBALS['P_TABLES']['course_reg']." WHERE  course_id='".$_SESSION[PAGE]['course_id']."' AND exam_hid='".$_SESSION[PAGE]['exam_hid']."' AND attendance=true",Q_RET_ARRAY,null,'index_no');

	if(!isset($reg_arr)){
		$report.="No students registered for ".$_SESSION[PAGE]['course_id'];
		exit();
	}

	$report.="<h4 style='background-color:#C9D7F1;padding:2px;text-align:center' class='bgCenter'>".$_SESSION[PAGE]['course_id']."&nbsp;|&nbsp;Rubric:".$arr_rubric[0]['assignment']."(Paper),".$arr_rubric[0]['paper']."(Assignment)&nbsp;|&nbsp;Number of Students:".get_num_rows()." </h4>\n";


	$blank_tds='<td></td>';
	$report.="<table class='report_table' border='1' cellpadding='2' style='border-collapse:collapse;'>\n<tr><th>#</th><th>Index No</th>";
	foreach($columns as $key => $value){	
		$report.="<th>".style_text($value)."</th>";
		$blank_tds.='<td></td>';
	}
	$report.="<th>Grade</th></tr>\n";


	//Marks for all the student for a given course in given exam
	$marks_arr=exec_query("SELECT * FROM ".$GLOBALS['P_TABLES']['marks']." WHERE course_id='".$_SESSION[PAGE]['course_id']."' AND exam_hid='".$_SESSION[PAGE]['exam_hid']."'",Q_RET_ARRAY,null,'index_no');

	$serial_no=1;
	foreach($reg_arr as $index_no => $row){
		$report.="<tr><td>".$serial_no++."</td>";
		$report.="<td>".$index_no."</td>";
		if(!isset($marks_arr[$index_no])){
			$report.=$blank_tds;
			$report.="</tr>\n";
			continue;
		}
		foreach($columns as $column){
			$report.="<td>".$marks_arr[$index_no][$column]."</td>";
		}
		$report.='<td>'.getGradeC($marks_arr[$index_no]['final_mark']+$marks_arr[$index_no]['push']).'</td>';
		$report.="</tr>\n";
	}
	$report.="</table>";
	$report.="<center>".date("M d, Y")."</center>";

	if(isset($_REQUEST['action'])&&$_REQUEST['action']=='pdf'){
      include A_CLASSES."/letterhead_pdf_class.php";
      $letterhead=new Letterhead("A4","P");

		//insert the content to the pdf
      $letterhead->include_content(str_replace("'","\"",$report));

      //Acquire pdf document
      $pdf=$letterhead->getPdf();

		//name of the pdf file
		$pdf_file=$_SESSION[PAGE]['course_id'].".pdf";

      $pdf->Output($pdf_file, 'I');
		//$pdf->Output(TMP."/".$pdf_file, 'F');
      return;
	}elseif(isset($_REQUEST['action'])&&$_REQUEST['action']=='print'){
		echo  $report;
		echo "<script language='javascript'>window.print();</script>";
	}else{
		echo  $report;
	}
}


//id table mapper array
$table_of_id=array(
	'course_id'=>$GLOBALS['P_TABLES']['course'],
	'exam_hid'=>$GLOBALS['P_TABLES']['exam']
);

//Map filter for the given id
$sem_filter=isset($_SESSION[PAGE]['semester'])?"semester='".$_SESSION[PAGE]['semester']."'":null;
$year_filter=isset($_SESSION[PAGE]['student_year'])?"student_year='".$_SESSION[PAGE]['student_year']."'":null;
$filter_map=array(
	'course_id'=>$sem_filter." AND ".$year_filter,
);

//Map order_by for the given id of combobox
$order_by_map=array(
	'exam_hid'=>'ORDER BY exam_id DESC',
);

if(isset($_REQUEST['form'])){
	switch($_REQUEST['form']){
   case 'main':
		if(isset($_REQUEST['action'])){
			switch($_REQUEST['action']){
			case 'pdf':
			case 'print':
			case 'html':
				gen_report();
			break;
			case 'param':
				$_SESSION[PAGE][$_REQUEST['param']]=$_REQUEST[$_REQUEST['param']];

				if($_REQUEST['param'] == 'exam_hid'){
					$admission_year=exec_query("SELECT student_year,semester FROM ".$GLOBALS['P_TABLES']['exam']." WHERE exam_hid='".$_SESSION[PAGE]['exam_hid']."'");
					$_SESSION[PAGE]['student_year']=$admission_year[0]['student_year'];
					$_SESSION[PAGE]['semester']=$admission_year[0]['semester'];
				}
				return_status_json('OK',"Set ".$_REQUEST['param']."=".$_REQUEST[$_REQUEST['param']]);
			break;
			case 'store':
				$filter=null;
				if(isset($filter_map[$_REQUEST['id']])){
					$filter=$filter_map[$_REQUEST['id']];
				}

				$order_by=null;
				if(isset($order_by_map[$_REQUEST['id']])){
					$order_by=$order_by_map[$_REQUEST['id']];
				}
				$xhr_combobox->json_data($table_of_id[$_REQUEST['id']],$_REQUEST['id'],$filter,$order_by);
			break;

			}
		}	
	case 'filter':
	break;
	}
}else{
?>

<div align='center'><div id='marks_frm' jsId='marks_frm' dojoType='dijit.form.Form'>
<?php
if(isset($_SESSION[PAGE]['course_id'])&& $_SESSION[PAGE]['exam_hid']){
	gen_report();
}
?>
</div>
</div>

<script language='javascript'>
dojo.addOnLoad(function() {
	//reference to our toolbar
   var toolbar = dijit.byId('toolbar');

	<?php
	$xhr_combobox->gen_xhr_combobox('exam_hid',"Exam",$xhr_combobox->get_val('exam_hid'),110,20,null,null);
	//$xhr_combobox->gen_xhr_combobox('course_id',"Course",$xhr_combobox->get_val('course_id'),80,20,null,null);
	$xhr_combobox->gen_xhr_combobox('course_id',"Course",$xhr_combobox->get_val('course_id'),80,20,array('exam_hid','course_id'),'marks_frm');

	//Different report types to be select
	$item_array=array('FULL','LMS','VERIFY');
	$xhr_combobox->gen_xhr_static_combo('report_type','Report Type',$xhr_combobox->get_val('report_type'),110,$item_array,array('exam_hid','course_id','report_type'),'marks_frm');
	?>

});
<?php
	$xhr_combobox->param_setter();
	$xhr_combobox->form_submitter('marks_frm');
?>
</script>
<?php
}
?>
