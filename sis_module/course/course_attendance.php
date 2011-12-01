<?php
include A_CLASSES."/xhr_combobox_class.php";
$xhr_combobox=new XHR_Combobox();
d_r('dijit.form.Select');

/*
Generate attendance sheet for the give course in given batch
*/
function gen_attendance_sheet($put_attendance=null){
   $batch_arr=exec_query("SELECT code FROM ".$GLOBALS['P_TABLES']['batch']." WHERE  batch_id='".$_SESSION[PAGE]['batch_id']."' ",Q_RET_ARRAY);

   $arr=exec_query("SELECT * FROM ".$GLOBALS['P_TABLES']['marks']." WHERE  course_id='".$_SESSION[PAGE]['course_id']."'AND exam_hid='".$_SESSION[PAGE]['exam_hid']."'",Q_RET_ARRAY);
   $count_all=get_num_rows();

   //To get the absent count to guess whether this is first time
   $count_arr=exec_query("SELECT * FROM ".$GLOBALS['P_TABLES']['marks']." WHERE state='AB' AND exam_hid='".$_SESSION[PAGE]['exam_hid']."' AND course_id='".$_SESSION[PAGE]['course_id']."'",Q_RET_MYSQL_RES);
   $count_absent=get_num_rows();

   echo "<table style='border:1px solid #C9D7F1;border-collapse:collapse;' border='1'>";
   echo "<tr><th colspan='3'>Attendance Sheet for Course ".$_SESSION[PAGE]['course_id']." <br\> Batch ".$_SESSION[PAGE]['batch_id']."</th></tr>";
   if($put_attendance == true){
      echo "<tr><th>Index No</th><th>State</th></tr>";
   }else{
      echo "<tr><th>Index No</th><th>Attendance</th></tr>";
   }
   foreach($arr as $row){
      echo "<tr>";
      echo "<td align='center'>".$row['index_no']."</td>";
      if($put_attendance == null){
         echo "<td>&nbsp;</td>";
      }else{
         echo "<td align='center'>
            <div dojoType='dijit.form.Select' name='".$row['index_no']."' value='".$row['state']."' style='width:50px;' >
               <span value='PR' ><span style='color:gray'>PR</span></span>
               <span value='AB' ><span style='color:blue'>AB</span></span>
               <span value='MC' ><span style='color:green'>MC</span></span>
               <span value='EO' ><span style='color:red'>EO</span></span>
            </div>
         </td>";
      }
      echo "</tr>";   
   }
   echo "</table>";
}

/*
Save attendance for the students
*/
function save_attendance(){
   $error=array();
   $arr=exec_query("SELECT index_no FROM ".$GLOBALS['P_TABLES']['marks']."  WHERE exam_hid='".$_SESSION[PAGE]['exam_hid']."' AND course_id='".$_SESSION[PAGE]['course_id']."'",Q_RET_ARRAY);

   foreach($arr as $c_arr){
      if(isset($_REQUEST[$c_arr['index_no']])){
      //Registering the courses
         exec_query("UPDATE ".$GLOBALS['P_TABLES']['marks']." SET state='".$_REQUEST[$c_arr['index_no']]."' WHERE index_no='".$c_arr['index_no']."' AND exam_hid='".$_SESSION[PAGE]['exam_hid']."' AND course_id='".$_SESSION[PAGE]['course_id']."'",Q_RET_MYSQL_RES);
      }

      if(!is_query_ok()){
         $error[]=get_sql_error();
      }
   }
   //Return the registration status as json
   if(sizeof($error)>0){
      return_status_json('ERROR',implode(',',$error));
   }else{
      return_status_json('OK','Updated successfully!');
   }

}

//PDF generator function
function gen_pdf(){
   include A_CLASSES."/letterhead_pdf_class.php";
   $query="SELECT index_no FROM ".$GLOBALS['P_TABLES']['marks']." WHERE exam_hid='".$_SESSION[PAGE]['exam_hid']."' AND course_id='".$_SESSION[PAGE]['course_id']."'";
   $res=exec_query($query,Q_RET_MYSQL_RES);

   $letterhead=new Letterhead("A4","P");

   $content      ="<table style='border-collapse:collapse' border='1'><tr><th>#</th><th>Index No</th><th>Attendance</th></tr>\n";
   $serial      =1;
   while($row = mysql_fetch_assoc($res)){
      $content.="<tr><td>".$serial++."</td><td>".$row['index_no']."</td><td>&nbsp;</td></tr>\n";
   }
   $content.='</table>';

   //insert the content to the pdf
   $letterhead->include_content(str_replace("'","\"",$content));

   //Acquire pdf document
   $pdf=$letterhead->getPdf();

   //name of the pdf file
   $pdf_file=$_SESSION[PAGE]['course_id'].".pdf";

   //$pdf->Output('test_pdf.pdf', 'I');
   $pdf->Output($pdf_file, 'I');
   return;
   //print $content;
}

function gen_csv(){
   $csv_file= $GLOBALS['P_TABLES']['marks'].".csv";
   $query="SELECT index_no,attendance,medical FROM ".$GLOBALS['P_TABLES']['marks']." WHERE exam_hid='".$_SESSION[PAGE]['exam_hid']."' AND course_id='".$_SESSION[PAGE]['course_id']."'";
   db_to_csv_nr($query,$csv_file,null);
   exit();
}

//id table mapper array for returning json data to find the table
$table_of_id=array(
   'batch_id'=>$GLOBALS['P_TABLES']['batch'],
   'course_id'=>$GLOBALS['P_TABLES']['course'],
   'student_year'=>$GLOBALS['P_TABLES']['course'],
   'exam_hid'=>$GLOBALS['P_TABLES']['exam'],
);

//Map filter for the given id for returning json data

$semester_filter=isset($_SESSION[PAGE]['semester'])?"semester='".$_SESSION[PAGE]['semester']."'":null;
$student_year_filter=isset($_SESSION[PAGE]['student_year'])?"student_year='".$_SESSION[PAGE]['student_year']."'":null;
$filter_map=array(
   'course_id'=>$semester_filter." AND ".$student_year_filter,
   //'exam_hid'=>isset($_SESSION[PAGE]['admission_year'])?"academic_year>='".$_SESSION[PAGE]['admission_year']."'":"academic_year>='".(date('Y')-1)."'"
);


//order the given id for returning json data
$order_by_map=array(
   'exam_hid'=>" ORDER BY exam_date DESC"
);


//Request functoin switcher
if(isset($_REQUEST['form'])){
   switch($_REQUEST['form']){
   case 'main':
   if(isset($_REQUEST['action'])){
      switch($_REQUEST['action']){
      case 'modify':
         save_attendance();
      break;
      case 'pdf':
         gen_pdf();
      break;
      case 'csv':
         gen_csv();
      break;
      case 'html':
         $_SESSION[PAGE]['course_id']=$_REQUEST['course_id'];
         $_SESSION[PAGE]['batch_id']=$_REQUEST['batch_id'];

         gen_attendance_sheet(true);
      break;
      case 'store':
         $filter   =null;
         $order_by=null;
         if(isset($filter_map[$_REQUEST['id']])){
            $filter=$filter_map[$_REQUEST['id']];
         }
         if(isset($order_by_map[$_REQUEST['id']])){
            $order_by=$order_by_map[$_REQUEST['id']];
         }

         $xhr_combobox->json_data($table_of_id[$_REQUEST['id']],$_REQUEST['id'],$filter,$order_by);
      break;
      case 'param':
         $_SESSION[PAGE][$_REQUEST['param']]=$_REQUEST[$_REQUEST['param']];

         //exceptional cases
         switch($_REQUEST['param']){
            case 'batch_id':
               $admission_year=exec_query("SELECT admission_year FROM ".$GLOBALS['P_TABLES']['batch']." WHERE batch_id='".$_SESSION[PAGE][$_REQUEST['param']]."'",Q_RET_ARRAY);
               $_SESSION[PAGE]['admission_year']=$admission_year[0]['admission_year'];
            break;
            case 'exam_hid':   
               $admission_year=exec_query("SELECT student_year,semester FROM ".$GLOBALS['P_TABLES']['exam']." WHERE exam_hid='".$_SESSION[PAGE][$_REQUEST['param']]."'",Q_RET_ARRAY);
               $_SESSION[PAGE]['student_year']=$admission_year[0]['student_year'];
               $_SESSION[PAGE]['semester']=$admission_year[0]['semester'];
            break;
         }

         return_status_json('OK',"Set ".$_REQUEST['param']."=".$_REQUEST[$_REQUEST['param']]);
      break;
      }
   }
   case 'filter':
   break;
   }
}else{
   echo "<div align='center'><div id='attendance_frm' jsId='attendance_frm' dojoType='dijit.form.Form' >";
   if(isset($_SESSION[PAGE]['course_id'])&&isset($_SESSION[PAGE]['batch_id'])&&isset($_SESSION[PAGE]['student_year'])){
      gen_attendance_sheet(true);
   }   
   echo "</div></div>";

   echo "<script type='text/javascript'>";
   echo "dojo.addOnLoad(function() {";

   //function gen_xhr_combobox($id,$label,$value,$width,$page_size,$source_array=null,$target=null);
   //$xhr_combobox->gen_xhr_combobox('student_year',"Student Year",$xhr_combobox->get_val('student_year'),30,20,null,null);
//   $xhr_combobox->gen_xhr_combobox('batch_id',"Batch",$xhr_combobox->get_val('batch_id'),80,20,null,null);
   $xhr_combobox->gen_xhr_combobox('exam_hid',"Exam",$xhr_combobox->get_val('exam_hid'),110,20,null,null);
   $xhr_combobox->gen_xhr_combobox('course_id',"Course",$xhr_combobox->get_val('course_id'),80,20,array('batch_id','course_id'),'attendance_frm');
   $xhr_combobox->param_setter();$xhr_combobox->html_requester();
   echo "});";
   $xhr_combobox->form_submitter('attendance_frm');
   echo "</script>";
}

?>
