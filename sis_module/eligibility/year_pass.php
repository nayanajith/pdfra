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


$pass_credit_limit=10;


//Request functoin switcher
if(isset($_REQUEST['form'])){
	switch($_REQUEST['form']){
      case 'main':
		if(isset($_REQUEST['action'])){
			switch($_REQUEST['action']){
			case 'gpa':
				gen_year_pass($pass_credit_limit);
			break;
			case 'pdf':
				gpa_pdf();
			break;
			case 'csv':
				gen_year_pass_csv($pass_credit_limit);
			break;
			case 'html':
				$_SESSION[PAGE]['batch_id']=$_REQUEST['batch_id'];
				gen_year_pass();
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
	echo "<h3>Sum of credits earned by each student in each year fo the subject where the grades are geater than C</h3>";
	echo "<h4>Select A Batch to generate the report</h4>";
	echo "<div><div id='year_pass_frm' jsId='year_pass_frm' dojoType='dijit.form.Form' >";
	if(isset($_SESSION[PAGE]['batch_id'])){
		gen_year_pass($pass_credit_limit);
	}	
	echo "</div></div>";

	echo "<script type='text/javascript'>";
	echo "dojo.addOnLoad(function() {";

	//function gen_xhr_combobox($id,$label,$value,$width,$page_size,$source_array=null,$target=null);
	//$xhr_combobox->gen_xhr_combobox('student_year',"Student Year",$xhr_combobox->get_val('student_year'),30,20,null,null);
	$xhr_combobox->gen_xhr_combobox('batch_id',"Batch",$xhr_combobox->get_val('batch_id'),80,20,array('batch_id'),'year_pass_frm');
	$xhr_combobox->param_setter();
	echo "});";
	$xhr_combobox->form_submitter('year_pass_frm');
	echo "</script>";
}

function gen_year_pass($pass_credit_limit=null){
	include A_CLASSES."/student_class.php";
	$arr=exec_query("SELECT index_no FROM ".$GLOBALS['P_TABLES']['student']." WHERE index_no LIKE '".$_SESSION[PAGE]['batch_id']."%'",Q_RET_ARRAY,null,'index_no');
	echo "<table style='border-collapse:collapse' border='1'>";
	$header=array("Index No","Pass Credit Y1","Pass Credit Y2", "Pass Credit Y3");
	echo "<tr>";
	echo "<th>".implode($header,"</th><th>")."</th>";
	echo "</tr>";
	foreach(array_keys($arr) as $index_no){
		$failed=false;
		$student = new Student($index_no);
		$row=array($index_no);
		if(is_null($pass_credit_limit)){
			$info=$student->getYearPass(1);
			$row[]=$info['credits'];	
			$info=$student->getYearPass(2);
			$row[]=$info['credits'];	
			$info=$student->getYearPass(3);
			$row[]=$info['credits'];	

			echo "<tr>";
			echo "<td>".implode($row,"</td><td>")."</td>";
			echo "</tr>";
		}else{
			$info=$student->getYearPass(1);
			if($info['credits']<$pass_credit_limit)$failed=true;	
			$row[]=$info['credits'];	
			$info=$student->getYearPass(2);
			if($info['credits']<$pass_credit_limit)$failed=true;	
			$row[]=$info['credits'];	
			$info=$student->getYearPass(3);
			if($info['credits']<$pass_credit_limit)$failed=true;	
			$row[]=$info['credits'];	
			if($failed){
				echo "<tr>";
				echo "<td>".implode($row,"</td><td>")."</td>";
				echo "</tr>";
			}
		}
		
	}
	echo "</table>";
}

function gen_year_pass_csv($pass_credit_limit){
   header('Content-Type', 'application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=year_pass.csv');
	header("Pragma: no-cache");
	header("Expires: 0");

	include A_CLASSES."/student_class.php";
	$arr=exec_query("SELECT index_no FROM ".$GLOBALS['P_TABLES']['student']." WHERE index_no LIKE '".$_SESSION[PAGE]['batch_id']."%'",Q_RET_ARRAY,null,'index_no');
	$header=array("Index No","Pass Credit Y1","Pass Credit Y2", "Pass Credit Y3");
	echo "'".implode($header,"','")."'\n";

	foreach(array_keys($arr) as $index_no){
		$failed=false;
		$student = new Student($index_no);
		$row=array($index_no);

		if(is_null($pass_credit_limit)){
			$info=$student->getYearPass(1);
			$row[]=$info['credits'];	
			$info=$student->getYearPass(2);
			$row[]=$info['credits'];	
			$info=$student->getYearPass(3);
			$row[]=$info['credits'];	
			echo "'".implode($row,"','")."'\n";
		}else{
			$info=$student->getYearPass(1);
			if($info['credits']<$pass_credit_limit)$failed=true;	
			$row[]=$info['credits'];	
			$info=$student->getYearPass(2);
			if($info['credits']<$pass_credit_limit)$failed=true;	
			$row[]=$info['credits'];	
			$info=$student->getYearPass(3);
			if($info['credits']<$pass_credit_limit)$failed=true;	
			$row[]=$info['credits'];	
			if($failed){
				echo "'".implode($row,"','")."'\n";
			}

		}
	}
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
