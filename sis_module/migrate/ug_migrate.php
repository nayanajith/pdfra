<?php
$program_=$_REQUEST["program"];
$source	="courseadmin";
$dest		="sis";
$pc		="cs";
$cc		="SCS";
if($program_ == 'bict'){
	$pc="it";
	$cc="ICT";
}
$source	=isset($_REQUEST['source_db'])?$_REQUEST['source_db']:'';
$dest		=isset($_REQUEST['dest_db'])?$_REQUEST['dest_db']:'';

$migrate_queries=array(
	//If the tables are filled with any data clean all
	"prepare1"	=>"DELETE FROM ".$program_."_student",
	"prepare2"	=>"DELETE FROM  ".$program_."_marks",
	"prepare3"	=>"DELETE FROM ".$program_."_exam",
	"prepare4"	=>"DELETE FROM ".$program_."_batch",
	"prepare5"	=>"DELETE FROM ".$program_."_gpa",
	"prepare6"	=>"DELETE FROM ".$program_."_course",

	//Reset auto increment numbers
	"prepare7"	=>"ALTER TABLE ".$program_."_exam AUTO_INCREMENT = 1",
	
	//migrate student information
	"student"	=>"REPLACE INTO ".$program_."_student(index_no,registration_no,initials,last_name,full_name,date_of_regist,date_of_graduation,date_of_birth,status,batch_id) SELECT IndexNo,RegNo,Initials,Name,fullname,dreg,dgrad,dob,upper(Status),LEFT(IndexNo,2) FROM ".$source.".".$pc."student",

	//Migrate student marks
	"marks1"		=>"REPLACE INTO ".$program_."_marks(exam_hid,index_no,course_id,assignment_mark,paper_mark,final_mark,push) SELECT concat('20',LEFT(ExamId,2),'-01-01',':',LEFT(RIGHT(ExamId,2),1),':',RIGHT(ExamId,1)),IndexNo,CourseId,Marks1,Marks2,Marks3,Adjustment FROM ".$source.".".$pc."marks WHERE ".$source.".".$pc."marks.final NOT IN('NA','WH','CH','AB','MC','EO')  ",

	"marks2"		=>"REPLACE INTO ".$program_."_marks(exam_hid,index_no,course_id,assignment_mark,paper_mark,final_mark) SELECT concat('20',LEFT(examid,2),'-01-01',':',LEFT(RIGHT(examid,2),1),':',RIGHT(examid,1)),indexno,courseid,marks1,marks2,final FROM ".$source.".".$pc."marks WHERE ".$source.".".$pc."marks.final IN('NA','CM','NC')  ",

	"marks3"		=>"REPLACE INTO ".$program_."_marks(exam_hid,index_no,course_id,state) SELECT concat('20',LEFT(examid,2),'-01-01',':',LEFT(RIGHT(examid,2),1),':',RIGHT(examid,1)),indexno,courseid,final FROM ".$source.".".$pc."marks WHERE ".$source.".".$pc."marks.final IN('AB','MC','EO')  ",

	//Extracting exam information from  marks table
	"exam1"		=>"REPLACE INTO ".$program_."_exam(exam_hid,exam_date,semester,student_year) SELECT DISTINCT exam_hid,CONCAT((LEFT(exam_hid,10)),'-01','-01'),RIGHT(exam_hid,1),(LEFT(RIGHT(exam_hid,3),1)) FROM ".$program_."_marks",

	//Set new exam_hid s in marks table
//	"marks4"		=>"UPDATE ".$program_."_marks m, ".$program_."_exam e set m.exam_hid=e.exam_hid where m.exam_old_id=e.exam_old_id;",

	//Extract batch ids from student information table
	"batch"		=>"REPLACE INTO ".$program_."_batch(batch_id,admission_year) SELECT DISTINCT LEFT(index_no,2),CONCAT('20',LEFT(index_no,2)) FROM ".$program_."_student",

	//Migrate gpa information of the students
	"gpa"			=>"REPLACE INTO ".$program_."_gpa(index_no,degree_class,GPV1,credits1,GPA1,GPV2,credits2,GPA2,GPV3,credits3,GPA3,GPV4,credits4,GPA4,GPV,GPA,credits) SELECT IndexNo,Tag,GPV1,credits1,GPA1,GPV2,credits2,GPA2,GPV3,credits3,GPA3,GPV4,credits4,GPA4,GPVT,GPAT,CreditsT FROM ".$source.".".$pc."gpv",

	//Migrate course information
	"course"		=>"REPLACE INTO ".$program_."_course(course_id,student_year,semester,course_name,prerequisite,lecture_credits,practical_credits,maximum_students,compulsory,alt_course_id,offered_by,non_gpa) SELECT CourseId,SYear,Semester,CourseName,Prerequisite,Credits_L,Credits_P,MaxStudents,Compulsory,AltCourseId,OfferedBy,GPACon FROM ".$source.".courses where courseid like '".$cc."%' or courseid like 'ENH%'"
);


if(isset($_REQUEST['action'])){ /*haldle requests*/
	switch($_REQUEST['action']){
      case 'migrate_db':
			$create=true;
			$error="";
			foreach($migrate_queries as $key => $query){
				$GLOBALS['CONNECTION'] = mysql_connect("localhost", "root", $_REQUEST['root_pwd']);
				if($GLOBALS['CONNECTION'] && mysql_select_DB($dest, $GLOBALS['CONNECTION'])){
					if(!exec_query($query,Q_RET_NONE,$db=null,$array_key=null,$deleted=null,$no_connect=true)){
						$create=false;
						$error.=get_sql_error();
					}	
				}
			}
			if(!$create){
				return_status_json('ERROR',$error);
			}else{
				return_status_json('OK','Database was migrated successfully!');
			}
		break;
	}
return;
}
d_r('dijit.form.Form');
d_r('dijit.form.Button');

?>

<form id='test_frm' dojoType='dijit.form.Form'>
<table>
<tr>
<td>Source Database</td><td><input type='text' dojoType='dijit.form.ValidationTextBox' name='source_db' id='source_db' jsId='source_db' value='courseadmin'></td>
</tr>
<tr>
<td>Destination Database</td><td><input type='text' dojoType='dijit.form.ValidationTextBox' name='dest_db' id='dest_db' jsId='dest_db' value='sis'></td>
</tr>

<tr>
<td>Database root password:</td><td><input type='password' dojoType='dijit.form.ValidationTextBox' name='root_pwd' id='root_pwd' jsId='root_pwd'></td>
</tr>
</tr>
<td>Program:</td><td>
<select dojoType='dijit.form.ComboBox' name='program' >
<option value='bcsc'>bcsc</option>
<option value='bict'>bict</option>
</select>
</td></tr></table>
</form>
<script language="javascript">
	function submit_form(action){
		update_status_bar('OK','...');
		update_progress_bar(10);
		if (dijit.byId('test_frm').validate()) {
			dojo.xhrGet({
			url			: '<?php echo gen_url(); ?>&action='+action, 
			handleAs		: 'json',
			form			: 'test_frm', 

			handle: function(response,ioArgs){
				update_status_bar(response.status,response.info);
				if(response.status=='ERROR'){	
					//update_progress_bar(0);
				}else{
					update_progress_bar(100);
				}
			},

			load: function(response) {
				update_status_bar('OK','rquest sent successfully');
				update_progress_bar(50);
			}, 
			error: function() {
				update_status_bar('ERROR','error on submission');
				update_progress_bar(0);
			}
		});

		return false;
	}else{
		update_status_bar('ERROR','Form contains invalid data.  Please correct first');
		return false;
	}
	return true;
}
</script>
